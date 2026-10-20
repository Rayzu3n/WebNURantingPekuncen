<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Support\NikProtection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function index(): View
    {
        $applications = MembershipApplication::query()
            ->whereIn('status', ['pending_review', 'needs_revision'])
            ->with('user:id,name,email')
            ->latest()
            ->paginate(15);

        return view('admin.membership-applications.index', compact('applications'));
    }

    public function show(MembershipApplication $membershipApplication): View
    {
        // Approved applications contain sensitive identity data and are no longer reviewable.
        abort_if($membershipApplication->status === 'approved', 404);

        $membershipApplication->load('user');

        return view('admin.membership-applications.show', [
            'application' => $membershipApplication,
        ]);
    }

    public function photo(MembershipApplication $membershipApplication): Response
    {
        // Application photos are private and can only be served inside the admin middleware.
        abort_if($membershipApplication->status === 'approved', 404);
        abort_unless(filled($membershipApplication->photo), 404);

        $disk = Storage::disk('membership-private');
        abort_unless($disk->exists($membershipApplication->photo), 404);

        return $disk->response(
            $membershipApplication->photo,
            basename($membershipApplication->photo),
            [
                'Cache-Control' => 'private, no-store, max-age=0',
                'X-Content-Type-Options' => 'nosniff',
                'Referrer-Policy' => 'no-referrer',
            ],
            'inline',
        );
    }

    public function decide(Request $request, MembershipApplication $membershipApplication): RedirectResponse
    {
        $validated = $request->validate([
            'decision' => ['required', Rule::in(['approve', 'needs_revision', 'reject'])],
            'admin_note' => ['nullable', 'string', 'max:3000', 'required_if:decision,needs_revision'],
        ]);

        $promotedPhotoPath = null;
        $privatePhotoPath = null;

        try {
            DB::transaction(function () use ($request, $membershipApplication, $validated, &$promotedPhotoPath, &$privatePhotoPath): void {
            $application = MembershipApplication::query()
                ->lockForUpdate()
                ->with('user')
                ->findOrFail($membershipApplication->id);

            if (! in_array($application->status, ['pending_review', 'needs_revision'], true)) {
                abort(422, 'This application has already been decided.');
            }

            $decision = $validated['decision'];
            $application->admin_note = $validated['admin_note'] ?? null;
            $application->reviewed_by = $request->user()->id;
            $application->reviewed_at = now();

            if ($decision === 'approve') {
                $privatePhotoPath = $application->photo;
                $memberPhotoPath = null;

                if ($privatePhotoPath !== null) {
                    $privateDisk = Storage::disk('membership-private');

                    abort_unless(
                        $privateDisk->exists($privatePhotoPath),
                        422,
                        'The applicant photo is unavailable. Please request a new photo before approval.',
                    );

                    $extension = pathinfo($privatePhotoPath, PATHINFO_EXTENSION);
                    $promotedPhotoPath = 'members/' . Str::uuid() . ($extension !== '' ? '.' . $extension : '');

                    if (! Storage::disk('public')->put($promotedPhotoPath, $privateDisk->get($privatePhotoPath))) {
                        throw new \RuntimeException('The approved member photo could not be published.');
                    }

                    $memberPhotoPath = $promotedPhotoPath;
                }

                $nikHash = NikProtection::fingerprint($application->nik);

                if (Member::where('nik_hash', $nikHash)->exists()) {
                    abort(422, 'This NIK already belongs to an existing member. Resolve the duplicate before approving.');
                }

                do {
                    $memberNumber = 'NU-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
                } while (Member::where('member_number', $memberNumber)->exists());

                $member = Member::create([
                    'user_id' => $application->user_id,
                    'member_number' => $memberNumber,
                    'nik' => $application->nik,
                    'birth_place' => $application->birth_place,
                    'birth_date' => $application->birth_date,
                    'gender' => $application->gender,
                    'phone' => $application->phone,
                    'address' => $application->address,
                    'photo' => $memberPhotoPath,
                    'status' => 'active',
                ]);

                if (! $member->exists) {
                    throw new \RuntimeException('The member record could not be created.');
                }

                $application->status = 'approved';
                if (! $application->user->update(['account_status' => 'active'])) {
                    throw new \RuntimeException('The applicant account could not be activated.');
                }
            } elseif ($decision === 'needs_revision') {
                $application->status = 'needs_revision';
            } else {
                $application->status = 'rejected';
                if (! $application->user->update(['account_status' => 'suspended'])) {
                    throw new \RuntimeException('The applicant account could not be suspended.');
                }
            }

            $application->save();
            });
        } catch (\Throwable $exception) {
            if ($promotedPhotoPath !== null) {
                Storage::disk('public')->delete($promotedPhotoPath);
            }

            throw $exception;
        }

        // Only publish the approved photo; remove the private source after the DB transaction succeeds.
        if ($validated['decision'] === 'approve' && $privatePhotoPath !== null) {
            Storage::disk('membership-private')->delete($privatePhotoPath);
        }

        return redirect()->route('admin.membership-applications.index')
            ->with('success', 'Membership application decision saved.');
    }
}

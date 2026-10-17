<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Support\NikProtection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function index(): View
    {
        $applications = MembershipApplication::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.membership-applications.index', compact('applications'));
    }

    public function show(MembershipApplication $membershipApplication): View
    {
        $membershipApplication->load('user');

        return view('admin.membership-applications.show', [
            'application' => $membershipApplication,
        ]);
    }

    public function decide(Request $request, MembershipApplication $membershipApplication): RedirectResponse
    {
        $validated = $request->validate([
            'decision' => ['required', Rule::in(['approve', 'needs_revision', 'reject'])],
            'admin_note' => ['nullable', 'string', 'max:3000', 'required_if:decision,needs_revision'],
        ]);

        DB::transaction(function () use ($request, $membershipApplication, $validated): void {
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
                    'photo' => $application->photo,
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

        return redirect()->route('admin.membership-applications.index')
            ->with('success', 'Membership application decision saved.');
    }
}

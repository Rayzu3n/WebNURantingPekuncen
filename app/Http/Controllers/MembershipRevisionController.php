<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipApplication;
use App\Support\NikProtection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MembershipRevisionController extends Controller
{
    public function edit(Request $request): View
    {
        $application = MembershipApplication::where('user_id', $request->user()->id)->firstOrFail();
        abort_unless($application->status === 'needs_revision', 404);

        return view('membership.revise', compact('application'));
    }

    public function update(Request $request): RedirectResponse
    {
        $application = MembershipApplication::where('user_id', $request->user()->id)->firstOrFail();
        abort_unless($application->status === 'needs_revision', 404);

        $request->merge([
            'nik' => NikProtection::normalize((string) $request->input('nik')),
            'nik_fingerprint' => NikProtection::fingerprint((string) $request->input('nik')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'nik_fingerprint' => ['required'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:5000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $nikHash = $validated['nik_fingerprint'];

        if (Member::where('nik_hash', $nikHash)->exists()
            || MembershipApplication::where('nik_hash', $nikHash)->where('id', '!=', $application->id)->exists()) {
            return back()->withInput($request->except(['nik', 'nik_fingerprint']))->withErrors([
                'nik' => 'This NIK is already associated with a member or another registration.',
            ]);
        }

        $applicantName = $validated['name'];
        unset($validated['name'], $validated['nik_fingerprint']);
        $originalPhoto = $application->photo;
        $replacementPhoto = null;

        if ($request->hasFile('photo')) {
            $replacementPhoto = $request->file('photo')->store('membership-applications', 'membership-private');

            if ($replacementPhoto === false) {
                return back()->withInput($request->except(['nik', 'nik_fingerprint']))->withErrors([
                    'photo' => 'The photo could not be saved. Please try again.',
                ]);
            }

            $validated['photo'] = $replacementPhoto;
        }

        try {
            DB::transaction(function () use ($application, $validated, $request, $applicantName): void {
                $application->fill($validated);
                $application->status = 'pending_review';
                $application->admin_note = null;
                $application->reviewed_by = null;
                $application->reviewed_at = null;

                if (! $application->save() || ! $request->user()->update(['name' => $applicantName])) {
                    throw new \RuntimeException('The revised application could not be saved.');
                }
            });
        } catch (\Throwable $exception) {
            if ($replacementPhoto !== null) {
                Storage::disk('membership-private')->delete($replacementPhoto);
            }

            throw $exception;
        }

        if ($replacementPhoto !== null && $originalPhoto) {
            Storage::disk('membership-private')->delete($originalPhoto);
        }

        return redirect()->route('membership.pending')->with('success', 'Your revised application has been resubmitted for review.');
    }
}

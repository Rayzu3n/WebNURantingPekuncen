<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Support\NikProtection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $member = $request->user()->member;

        abort_unless($member, 404);

        return view('member.profile', compact('member'));
    }

    public function update(Request $request): RedirectResponse
    {
        $member = $request->user()->member;

        abort_unless($member, 404);

        $request->merge(['nik_fingerprint' => NikProtection::fingerprint((string) $request->input('nik'))]);

        if (Member::where('nik_hash', $request->input('nik_fingerprint'))
            ->where('id', '!=', $member->id)
            ->exists()) {
            return back()->withInput($request->except(['nik', 'nik_fingerprint']))->withErrors(['nik' => 'This NIK is already associated with another member.']);
        }

        $validated = $request->validate([
            'nik' => ['required', 'string', 'max:30'],
            'nik_fingerprint' => ['required'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        unset($validated['nik_fingerprint']);

        $originalPhoto = $member->photo;
        $replacementPhoto = null;

        if ($request->hasFile('photo')) {
            $replacementPhoto = $request
                ->file('photo')
                ->store('members', 'public');

            if ($replacementPhoto === false) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'photo' => 'The profile photo could not be saved. Please try again.',
                    ]);
            }

            $validated['photo'] = $replacementPhoto;
        }

        try {
            $updated = $member->update($validated);
        } catch (\Throwable $exception) {
            if ($replacementPhoto !== null) {
                Storage::disk('public')->delete($replacementPhoto);
            }

            throw $exception;
        }

        if (! $updated) {
            if ($replacementPhoto !== null) {
                Storage::disk('public')->delete($replacementPhoto);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'photo' => 'The profile could not be updated. Please try again.',
                ]);
        }

        if ($replacementPhoto !== null && $originalPhoto) {
            Storage::disk('public')->delete($originalPhoto);
        }

        return redirect()
            ->route('member.profile')
            ->with('success', 'Member profile updated successfully.');
    }
}

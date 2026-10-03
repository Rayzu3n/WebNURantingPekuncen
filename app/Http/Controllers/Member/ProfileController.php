<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
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

        $validated = $request->validate([
            'nik' => ['required', 'string', 'max:30', Rule::unique('members', 'nik')->ignore($member->id)],
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

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $validated['photo'] = $request
                ->file('photo')
                ->store('members', 'public');
        }

        $member->update($validated);

        return redirect()
            ->route('member.profile')
            ->with('success', 'Member profile updated successfully.');
    }
}
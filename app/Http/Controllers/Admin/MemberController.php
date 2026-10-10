<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $members = Member::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    public function create(): View
    {
        return view('admin.members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

            'member_number' => [
                'required',
                'string',
                'max:100',
                'unique:members,member_number',
            ],

            'nik' => [
                'required',
                'string',
                'max:30',
                'unique:members,nik',
            ],

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

            'status' => ['required', 'in:active,inactive'],
        ]);

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
        }

        $memberData = [
            'member_number' => $validated['member_number'],
            'nik' => $validated['nik'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'],
            'status' => $validated['status'],
        ];

        if ($replacementPhoto !== null) {
            $memberData['photo'] = $replacementPhoto;
        }

        try {
            DB::transaction(function () use ($validated, $memberData): void {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => 'member',
                ]);

                if (! $user->exists) {
                    throw new \RuntimeException(
                        'The member account could not be created.'
                    );
                }

                $memberData['user_id'] = $user->id;

                $member = Member::create($memberData);

                if (! $member->exists) {
                    throw new \RuntimeException(
                        'The member record could not be created.'
                    );
                }
            });
        } catch (\Throwable $exception) {
            if ($replacementPhoto !== null) {
                Storage::disk('public')->delete($replacementPhoto);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member created successfully.');
    }

    public function edit(Member $member): View
    {
        $member->load('user');

        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $member->load('user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($member->user_id),
            ],

            'member_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('members', 'member_number')->ignore($member->id),
            ],

            'nik' => [
                'required',
                'string',
                'max:30',
                Rule::unique('members', 'nik')->ignore($member->id),
            ],

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

            'status' => ['required', 'in:active,inactive'],
        ]);

        // Preserve the current photo until the update succeeds.
        $originalPhoto = $member->photo;
        $replacementPhoto = null;

        // Store the replacement photo before changing the database.
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
        }

        $memberData = [
            'member_number' => $validated['member_number'],
            'nik' => $validated['nik'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'],
            'status' => $validated['status'],
        ];

        if ($replacementPhoto !== null) {
            $memberData['photo'] = $replacementPhoto;
        }

        try {
            DB::transaction(function () use (
                $member,
                $validated,
                $memberData
            ): void {
                if (! $member->user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ])) {
                    throw ValidationException::withMessages([
                        'update' => 'The member account could not be updated. Please try again.',
                    ]);
                }

                if (! $member->update($memberData)) {
                    throw ValidationException::withMessages([
                        'update' => 'The member profile could not be updated. Please try again.',
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            // Remove the replacement if the database update fails.
            if ($replacementPhoto !== null) {
                Storage::disk('public')->delete($replacementPhoto);
            }

            throw $exception;
        }

        // Delete the old photo only after the database update succeeds.
        if ($replacementPhoto !== null && $originalPhoto) {
            Storage::disk('public')->delete($originalPhoto);
        }

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->load('user');

        $user = $member->user;
        $originalPhoto = $member->photo;

        DB::transaction(function () use ($member, $user): void {
            if (! $member->delete()) {
                throw new \RuntimeException(
                    'The member record could not be deleted.'
                );
            }

            if (! $user->delete()) {
                throw new \RuntimeException(
                    'The member account could not be deleted.'
                );
            }
        });

        // Delete the photo only after the transaction succeeds.
        if ($originalPhoto) {
            Storage::disk('public')->delete($originalPhoto);
        }

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member deleted successfully.');
    }
}

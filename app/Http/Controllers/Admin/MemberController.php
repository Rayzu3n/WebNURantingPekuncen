<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

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

        DB::transaction(function () use ($request, &$validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'member',
            ]);

            $memberData = [
                'user_id' => $user->id,
                'member_number' => $validated['member_number'],
                'nik' => $validated['nik'],
                'birth_place' => $validated['birth_place'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'],
                'status' => $validated['status'],
            ];

            if ($request->hasFile('photo')) {
                $memberData['photo'] = $request
                    ->file('photo')
                    ->store('members', 'public');
            }

            Member::create($memberData);
        });

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

        DB::transaction(function () use ($request, $member, $validated) {
            $member->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

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

            if ($request->hasFile('photo')) {
                if ($member->photo) {
                    Storage::disk('public')->delete($member->photo);
                }

                $memberData['photo'] = $request
                    ->file('photo')
                    ->store('members', 'public');
            }

            $member->update($memberData);
        });

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->load('user');

        DB::transaction(function () use ($member) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $member->user->delete();
        });

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member deleted successfully.');
    }
}   
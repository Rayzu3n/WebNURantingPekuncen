<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->news()->exists()) {
            return Redirect::route('profile.edit')
                ->withErrors([
                    'password' => 'Your account cannot be deleted while you are still the author of existing news.',
                ], 'userDeletion');
        }

        $memberPhoto = $user->member?->photo;

        $deletionResult = DB::transaction(function () use ($user): string {
            if ($user->isAdmin()) {
                $admins = User::query()
                    ->where('role', 'admin')
                    ->lockForUpdate()
                    ->get(['id']);

                if ($admins->count() <= 1) {
                    return 'last_admin';
                }
            }

            return $user->delete() ? 'deleted' : 'failed';
        });

        if ($deletionResult !== 'deleted') {
            $message = $deletionResult === 'last_admin'
                ? 'The last administrator account cannot be deleted.'
                : 'Your account could not be deleted. Please try again.';

            return Redirect::route('profile.edit')
                ->withErrors([
                    'password' => $message,
                ], 'userDeletion');
        }

        if ($memberPhoto) {
            Storage::disk('public')->delete($memberPhoto);
        }

        Auth::logoutCurrentDevice();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

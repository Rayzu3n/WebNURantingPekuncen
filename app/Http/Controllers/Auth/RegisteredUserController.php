<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Support\NikProtection;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'nik' => NikProtection::normalize((string) $request->input('nik')),
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'digits:16'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:5000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'terms' => ['accepted'],
        ]);

        $nikHash = NikProtection::fingerprint($validated['nik']);

        if (Member::where('nik_hash', $nikHash)->exists()
            || MembershipApplication::where('nik_hash', $nikHash)->exists()) {
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['nik' => 'This NIK is already associated with a member or registration.']);
        }

        $token = Str::random(64);
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('membership-applications', 'membership-private');

            if ($photoPath === false) {
                return back()->withInput()->withErrors([
                    'photo' => 'The photo could not be saved. Please try again.',
                ]);
            }
        }

        try {
            $application = DB::transaction(function () use ($validated, $token, $photoPath): MembershipApplication {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'member',
                    'account_status' => 'pending',
                ]);

                do {
                    $registrationNumber = 'REG-' . now()->format('Ymd') . '-' . Str::upper(Str::random(8));
                } while (MembershipApplication::where('registration_number', $registrationNumber)->exists());

                return MembershipApplication::create([
                    'user_id' => $user->id,
                    'registration_number' => $registrationNumber,
                    'access_token_hash' => hash('sha256', $token),
                    'nik' => $validated['nik'],
                    'birth_place' => $validated['birth_place'],
                    'birth_date' => $validated['birth_date'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'],
                    'photo' => $photoPath,
                    'status' => 'pending_review',
                ]);
            });
        } catch (\Throwable $exception) {
            if ($photoPath !== null) {
                Storage::disk('membership-private')->delete($photoPath);
            }

            throw $exception;
        }

        $user = $application->user;
        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('membership.pending')
            ->with('registration_number', $application->registration_number)
            ->with('registration_token', $token);
    }

    public function pending(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->account_status === 'active') {
            return redirect()->route('member.dashboard');
        }

        $application = MembershipApplication::where('user_id', $user->id)->firstOrFail();

        if ($user->account_status === 'pending') {
            return view('membership.pending', compact('application'));
        }

        // Rejected applicants may access this status-only page to read the decision,
        // but remain suspended from all member features.
        if ($user->account_status === 'suspended' && $application->status === 'rejected') {
            return view('membership.pending', compact('application'));
        }

        abort(403, 'This account is not currently permitted to access the member portal.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipTrackingController extends Controller
{
    public function create(): View
    {
        return view('membership.track');
    }

    public function store(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'registration_number' => ['required', 'string', 'max:40'],
            'access_token' => ['required', 'string', 'max:128'],
        ]);

        $application = MembershipApplication::query()
            ->where('registration_number', strtoupper(trim($validated['registration_number'])))
            ->where('access_token_hash', hash('sha256', $validated['access_token']))
            ->first();

        if (! $application) {
            return back()->withInput($request->only('registration_number'))->withErrors([
                'tracking' => 'The registration details could not be verified. Check the number and access token.',
            ]);
        }

        return view('membership.tracking-result', [
            'registrationNumber' => $application->registration_number,
            'status' => $application->status,
        ]);
    }
}

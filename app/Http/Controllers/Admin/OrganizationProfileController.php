<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationProfileController extends Controller
{
    public function edit(): View
    {
        $profile = OrganizationProfile::query()->first()
            ?? new OrganizationProfile(['name' => 'NU Ranting Pekuncen']);

        return view('admin.organization-profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'history' => ['nullable', 'string', 'max:20000'],
            'vision' => ['nullable', 'string', 'max:5000'],
            'mission' => ['nullable', 'string', 'max:10000'],
            'structure' => ['nullable', 'string', 'max:10000'],
            'programs' => ['nullable', 'string', 'max:10000'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
        ]);

        $profile = OrganizationProfile::query()->first() ?? new OrganizationProfile();
        $profile->fill($validated);
        $profile->save();

        return redirect()
            ->route('admin.organization-profile.edit')
            ->with('success', 'Profil organisasi berhasil diperbarui.');
    }
}

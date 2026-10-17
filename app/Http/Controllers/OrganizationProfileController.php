<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use Illuminate\View\View;

class OrganizationProfileController extends Controller
{
    public function show(): View
    {
        $profile = OrganizationProfile::query()->first();

        return view('about.index', compact('profile'));
    }
}

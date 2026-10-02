<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'newsCount' => News::count(),
            'memberCount' => Member::count(),
            'categoryCount' => NewsCategory::count(),
        ]);
    }
}
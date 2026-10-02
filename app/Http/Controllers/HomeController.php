<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredNews = News::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->first();

        $latestNews = News::with('category')
            ->where('status', 'published')
            ->when(
                $featuredNews,
                fn ($query) => $query->where('id', '!=', $featuredNews->id)
            )
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('home', compact(
            'featuredNews',
            'latestNews'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredNews = News::query()
            ->with(['category', 'author'])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->first();

        $secondaryNews = News::query()
            ->with(['category', 'author'])
            ->where('status', 'published')
            ->when(
                $featuredNews,
                fn ($query) => $query->where('id', '!=', $featuredNews->id)
            )
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(2)
            ->get();

        $excludedNewsIds = collect([$featuredNews?->id])
            ->merge($secondaryNews->modelKeys())
            ->filter()
            ->values();

        $galleryNews = News::query()
            ->with('category')
            ->where('status', 'published')
            ->whereNotNull('thumbnail')
            ->whereNotIn('id', $excludedNewsIds)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $excludedNewsIds = $excludedNewsIds
            ->merge($galleryNews->modelKeys())
            ->values();

        $latestNews = News::query()
            ->with(['category', 'author'])
            ->where('status', 'published')
            ->whereNotIn('id', $excludedNewsIds)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $categories = NewsCategory::query()
            ->whereHas('news', fn ($query) => $query->where('status', 'published'))
            ->withCount([
                'news' => fn ($query) => $query->where('status', 'published'),
            ])
            ->orderByDesc('news_count')
            ->orderBy('name')
            ->take(6)
            ->get();

        return view('home', compact(
            'featuredNews',
            'secondaryNews',
            'galleryNews',
            'latestNews',
            'categories'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category');

        $news = News::with(['category', 'author'])
            ->where('status', 'published')
            ->when(
                $selectedCategory,
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery->where('slug', $selectedCategory)
                )
            )
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        $activeCategory = $selectedCategory
            ? NewsCategory::where('slug', $selectedCategory)->first()
            : null;

        return view('news.index', compact('news', 'activeCategory'));
    }

    public function show(string $slug): View
    {
        $news = News::with(['category', 'author'])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('news.show', compact('news'));
    }
}

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
        $categorySlug = $request->query('category');
        $selectedCategory = null;

        if ($categorySlug !== null) {
            abort_unless(is_string($categorySlug), 404);

            $selectedCategory = NewsCategory::query()
                ->where('slug', $categorySlug)
                ->firstOrFail();
        }

        $news = News::query()
            ->with('category')
            ->where('status', 'published')
            ->when(
                $selectedCategory,
                fn ($query) => $query->where('category_id', $selectedCategory->id)
            )
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('news.index', compact('news', 'selectedCategory'));
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

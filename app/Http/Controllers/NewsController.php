<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(10);

        return view('news.index', compact('news'));
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

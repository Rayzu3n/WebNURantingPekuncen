<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::with(['category', 'author'])
            ->latest()
            ->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        $categories = NewsCategory::orderBy('name')->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:news,slug'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('news', 'public');
        }

        $validated['author_id'] = $request->user()->id;

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        } else {
            $validated['published_at'] = null;
        }

        News::create($validated);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News created successfully.');
    }

    public function edit(News $news): View
    {
        $categories = NewsCategory::orderBy('name')->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:news,slug,' . $news->id,
            ],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }

            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('news', 'public');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] ??= $news->published_at ?? now();
        } else {
            $validated['published_at'] = null;
        }

        $news->update($validated);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News updated successfully.');
    }

    public function destroy(News $news): RedirectResponse
    {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    public function index(): View
    {
        $categories = NewsCategory::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:news_categories,slug'],
        ]);

        $category = NewsCategory::create($validated);

        if (! $category->exists) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Category could not be created. Please try again.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(NewsCategory $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, NewsCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('news_categories', 'slug')->ignore($category->id),
            ],
        ]);

        if (! $category->update($validated)) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Category could not be updated. Please try again.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(NewsCategory $category): RedirectResponse
    {
        if ($category->news()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Category cannot be deleted because it is being used by existing news.');
        }

        if (! $category->delete()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Category could not be deleted. Please try again.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}

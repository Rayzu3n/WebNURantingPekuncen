<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;

test('homepage shows published stories and category shortcuts without exposing drafts', function () {
    $category = NewsCategory::factory()->create([
        'name' => 'Kegiatan',
        'slug' => 'kegiatan',
    ]);
    $author = User::factory()->create();

    $featuredNews = News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Featured Published Story',
        'slug' => 'featured-published-story',
        'status' => 'published',
        'published_at' => now()->subHour(),
        'thumbnail' => null,
    ]);

    News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Secondary Published Story',
        'slug' => 'secondary-published-story',
        'status' => 'published',
        'published_at' => now()->subHours(2),
    ]);

    News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Another Secondary Story',
        'slug' => 'another-secondary-story',
        'status' => 'published',
        'published_at' => now()->subHours(3),
    ]);

    $visualStory = News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Visual Published Story',
        'slug' => 'visual-published-story',
        'status' => 'published',
        'published_at' => now()->subHours(4),
        'thumbnail' => 'news/visual-story.jpg',
    ]);

    News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Another Visual Story',
        'slug' => 'another-visual-story',
        'status' => 'published',
        'published_at' => now()->subHours(5),
        'thumbnail' => 'news/another-visual-story.jpg',
    ]);

    $draft = News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Private Draft Story',
        'slug' => 'private-draft-story',
        'status' => 'draft',
        'published_at' => now()->addDay(),
    ]);

    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee($featuredNews->title)
        ->assertSee($visualStory->title)
        ->assertSee('Sorotan visual')
        ->assertSee(route('news.index', ['category' => $category->slug]))
        ->assertDontSee($draft->title);
});

test('news listing filters published articles by category', function () {
    $selectedCategory = NewsCategory::factory()->create([
        'name' => 'Kegiatan',
        'slug' => 'kegiatan',
    ]);
    $otherCategory = NewsCategory::factory()->create([
        'name' => 'Pendidikan',
        'slug' => 'pendidikan',
    ]);
    $author = User::factory()->create();

    $matchingNews = News::factory()->create([
        'category_id' => $selectedCategory->id,
        'author_id' => $author->id,
        'title' => 'Matching Category Story',
        'slug' => 'matching-category-story',
        'status' => 'published',
        'published_at' => now()->subHour(),
    ]);

    $otherNews = News::factory()->create([
        'category_id' => $otherCategory->id,
        'author_id' => $author->id,
        'title' => 'Other Category Story',
        'slug' => 'other-category-story',
        'status' => 'published',
        'published_at' => now()->subHours(2),
    ]);

    $draftNews = News::factory()->create([
        'category_id' => $selectedCategory->id,
        'author_id' => $author->id,
        'title' => 'Draft Category Story',
        'slug' => 'draft-category-story',
        'status' => 'draft',
        'published_at' => now()->addDay(),
    ]);

    $response = $this->get(route('news.index', [
        'category' => $selectedCategory->slug,
    ]));

    $response
        ->assertOk()
        ->assertSee($matchingNews->title)
        ->assertSee($selectedCategory->name)
        ->assertDontSee($otherNews->title)
        ->assertDontSee($draftNews->title);
});

test('news listing returns 404 for an unknown category filter', function () {
    $this->get(route('news.index', [
        'category' => 'category-that-does-not-exist',
    ]))->assertNotFound();
});

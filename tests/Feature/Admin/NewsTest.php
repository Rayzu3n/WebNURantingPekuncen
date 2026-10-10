<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

test('admin can delete news and its thumbnail', function () {
    $storage = Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create();

    $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
    $thumbnailPath = $thumbnail->store('news', 'public');

    $news = News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $admin->id,
        'thumbnail' => $thumbnailPath,
    ]);

    $storage->assertExists($thumbnailPath);

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.news.destroy', $news));

    $response
        ->assertRedirect(route('admin.news.index'))
        ->assertSessionHas('success', 'News deleted successfully.');

    $this->assertDatabaseMissing('news', [
        'id' => $news->id,
    ]);

    $storage->assertMissing($thumbnailPath);
});

test('admin can delete news without a thumbnail', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $news = News::factory()->create([
        'author_id' => $admin->id,
        'thumbnail' => null,
    ]);

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.news.destroy', $news));

    $response
        ->assertRedirect(route('admin.news.index'))
        ->assertSessionHas('success', 'News deleted successfully.');

    $this->assertDatabaseMissing('news', [
        'id' => $news->id,
    ]);
});

test('admin can replace news thumbnail and remove the old file', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create();

    $oldThumbnail = UploadedFile::fake()->image('old-thumbnail.jpg');
    $oldPath = $oldThumbnail->store('news', 'public');

    $news = News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $admin->id,
        'title' => 'Original News',
        'slug' => 'original-news',
        'status' => 'draft',
        'thumbnail' => $oldPath,
    ]);

    $newThumbnail = UploadedFile::fake()->image('new-thumbnail.jpg');

    $response = $this
        ->actingAs($admin)
        ->put(route('admin.news.update', $news), [
            'category_id' => $category->id,
            'title' => 'Updated News',
            'slug' => 'updated-news',
            'excerpt' => 'Updated excerpt',
            'content' => 'Updated content',
            'status' => 'draft',
            'thumbnail' => $newThumbnail,
        ]);

    $response
        ->assertRedirect(route('admin.news.index'))
        ->assertSessionHas('success', 'News updated successfully.');

    $news->refresh();

    expect($news->title)->toBe('Updated News')
        ->and($news->thumbnail)->not->toBe($oldPath);

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($news->thumbnail);
});

test('failed news update preserves the old thumbnail', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create();

    $oldPath = UploadedFile::fake()
        ->image('old-thumbnail.jpg')
        ->store('news', 'public');

    $news = News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $admin->id,
        'title' => 'Original News',
        'slug' => 'original-news',
        'status' => 'draft',
        'thumbnail' => $oldPath,
    ]);

    Event::listen(
        'eloquent.updating: '.News::class,
        fn (): bool => false
    );

    $response = $this
        ->actingAs($admin)
        ->from(route('admin.news.edit', $news))
        ->put(route('admin.news.update', $news), [
            'category_id' => $category->id,
            'title' => 'Updated News',
            'slug' => 'updated-news',
            'excerpt' => 'Updated excerpt',
            'content' => 'Updated content',
            'status' => 'draft',
            'thumbnail' => UploadedFile::fake()->image('replacement.jpg'),
        ]);

    $response
        ->assertRedirect(route('admin.news.edit', $news))
        ->assertSessionHasErrors('update');

    expect($news->fresh()->title)->toBe('Original News');

    Storage::disk('public')->assertExists($oldPath);
    expect(Storage::disk('public')->allFiles('news'))->toBe([$oldPath]);
});

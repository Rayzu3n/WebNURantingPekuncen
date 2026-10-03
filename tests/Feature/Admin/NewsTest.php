<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin can delete news and its thumbnail', function () {
    Storage::fake('public');

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

    Storage::disk('public')->assertExists($thumbnailPath);

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.news.destroy', $news));

    $response
        ->assertRedirect(route('admin.news.index'))
        ->assertSessionHas('success', 'News deleted successfully.');

    $this->assertDatabaseMissing('news', [
        'id' => $news->id,
    ]);

    Storage::disk('public')->assertMissing($thumbnailPath);
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

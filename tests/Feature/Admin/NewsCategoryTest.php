<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;

test('admin can delete an unused news category', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create();

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.categories.destroy', $category));

    $response
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('success', 'Category deleted successfully.');

    $this->assertDatabaseMissing('news_categories', [
        'id' => $category->id,
    ]);
});

test('admin cannot delete a news category that is being used', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create();

    News::factory()->create([
        'category_id' => $category->id,
        'author_id' => $admin->id,
    ]);

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.categories.destroy', $category));

    $response
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas(
            'error',
            'Category cannot be deleted because it is being used by existing news.'
        );

    $this->assertDatabaseHas('news_categories', [
        'id' => $category->id,
    ]);
});

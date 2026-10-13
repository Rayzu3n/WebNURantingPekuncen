<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Support\Facades\Event;

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

test('failed news category creation does not report success', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    Event::listen(
        'eloquent.creating: '.NewsCategory::class,
        fn (): bool => false,
    );

    $response = $this
        ->actingAs($admin)
        ->post(route('admin.categories.store'), [
            'name' => 'Canceled Category',
            'slug' => 'canceled-category',
        ]);

    $response
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('error', 'Category could not be created. Please try again.')
        ->assertSessionMissing('success');

    $this->assertDatabaseMissing('news_categories', [
        'slug' => 'canceled-category',
    ]);
});

test('failed news category update does not report success', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create([
        'name' => 'Original Category',
        'slug' => 'original-category',
    ]);

    Event::listen(
        'eloquent.updating: '.NewsCategory::class,
        fn (): bool => false,
    );

    $response = $this
        ->actingAs($admin)
        ->put(route('admin.categories.update', $category), [
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ]);

    $response
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('error', 'Category could not be updated. Please try again.')
        ->assertSessionMissing('success');

    $this->assertDatabaseHas('news_categories', [
        'id' => $category->id,
        'name' => 'Original Category',
        'slug' => 'original-category',
    ]);
});

test('failed news category deletion does not report success', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = NewsCategory::factory()->create();

    Event::listen(
        'eloquent.deleting: '.NewsCategory::class,
        fn (): bool => false,
    );

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.categories.destroy', $category));

    $response
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('error', 'Category could not be deleted. Please try again.')
        ->assertSessionMissing('success');

    $this->assertDatabaseHas('news_categories', [
        'id' => $category->id,
    ]);
});

<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account and member photo', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $photo = 'members/profile-photo.jpg';

    Storage::disk('public')->put($photo, 'photo content');

    Member::factory()->create([
        'user_id' => $user->id,
        'photo' => $photo,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
    $this->assertDatabaseMissing('members', [
        'user_id' => $user->id,
    ]);
    $this->assertFalse(Storage::disk('public')->exists($photo));
});

test('failed account deletion preserves the member photo and authenticated session', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $photo = 'members/profile-photo-preserved.jpg';

    Storage::disk('public')->put($photo, 'photo content');

    Member::factory()->create([
        'user_id' => $user->id,
        'photo' => $photo,
    ]);

    Event::listen(
        'eloquent.deleting: '.User::class,
        fn (): bool => false,
    );

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertRedirect('/profile')
        ->assertSessionHasErrorsIn('userDeletion', 'password');

    $this->assertAuthenticatedAs($user);
    $this->assertNotNull($user->fresh());
    $this->assertDatabaseHas('members', [
        'user_id' => $user->id,
        'photo' => $photo,
    ]);
    $this->assertTrue(Storage::disk('public')->exists($photo));
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('account deletion is blocked while the user is an author', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $category = NewsCategory::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
    ]);

    News::create([
        'category_id' => $category->id,
        'author_id' => $user->id,
        'title' => 'Test News',
        'slug' => 'test-news',
        'content' => 'Test content',
        'status' => 'draft',
    ]);

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

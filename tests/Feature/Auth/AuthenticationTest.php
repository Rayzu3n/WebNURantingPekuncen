<?php

use App\Models\Member;
use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('inactive members can not authenticate', function () {
    $user = User::factory()->create([
        'role' => 'member',
    ]);

    Member::create([
        'user_id' => $user->id,
        'member_number' => 'TEST-INACTIVE-001',
        'nik' => '9999999999999999',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2009-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Pekuncen',
        'status' => 'inactive',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertGuest();

    $response->assertSessionHasErrors('email');
});

test('active members can authenticate', function () {
    $user = User::factory()->create([
        'role' => 'member',
    ]);

    Member::factory()->for($user)->create([
        'status' => 'active',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);

    $response->assertRedirect(
        route('dashboard', absolute: false)
    );
});

test('members without a membership record cannot authenticate', function () {
    $user = User::factory()->create([
        'role' => 'member',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertGuest();

    $response->assertSessionHasErrors('email');
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('inactive members cannot authenticate', function () {
    $user = User::factory()->create([
        'role' => 'member',
    ]);

    Member::factory()->for($user)->create([
        'status' => 'inactive',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertGuest();

    $response->assertSessionHasErrors('email');
});

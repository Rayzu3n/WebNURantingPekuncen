<?php

use App\Models\User;

test('guests cannot access the admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('members cannot access the admin dashboard', function () {
    $member = User::factory()->create([
        'role' => 'member',
    ]);

    $this->actingAs($member)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('admins cannot access the member dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->get(route('member.dashboard'))
        ->assertForbidden();
});

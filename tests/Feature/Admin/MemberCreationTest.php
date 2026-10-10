<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('allows an admin to create a member with a profile photo', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post(
        route('admin.members.store'),
        [
            'name' => 'New Member',
            'email' => 'new-member@example.test',
            'password' => 'password123',
            'member_number' => 'NU-ADMIN-0001',
            'nik' => '1234567890123456',
            'birth_place' => 'Pekuncen',
            'birth_date' => '2000-01-01',
            'gender' => 'L',
            'phone' => '081234567890',
            'address' => 'Pekuncen, Indonesia',
            'status' => 'active',
            'photo' => UploadedFile::fake()->image('profile.jpg'),
        ],
    );

    $response->assertRedirect(route('admin.members.index'));

    $member = Member::query()
        ->where('member_number', 'NU-ADMIN-0001')
        ->firstOrFail();

    expect($member->photo)->not->toBeNull();

    expect(Storage::disk('public')->exists($member->photo))->toBeTrue();

    $this->assertDatabaseHas('users', [
        'id' => $member->user_id,
        'email' => 'new-member@example.test',
        'role' => 'member',
    ]);
});

it('rolls back member creation and removes the photo when creating the member record fails', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    Event::listen(
        'eloquent.creating: '.Member::class,
        fn (): bool => false,
    );

    $response = $this->actingAs($admin)->post(
        route('admin.members.store'),
        [
            'name' => 'Failed Member',
            'email' => 'failed-member@example.test',
            'password' => 'password123',
            'member_number' => 'NU-ADMIN-0002',
            'nik' => '6543210987654321',
            'birth_place' => 'Pekuncen',
            'birth_date' => '2000-01-01',
            'gender' => 'P',
            'phone' => '081234567890',
            'address' => 'Pekuncen, Indonesia',
            'status' => 'active',
            'photo' => UploadedFile::fake()->image('profile.jpg'),
        ],
    );

    $response->assertServerError();

    $this->assertDatabaseMissing('users', [
        'email' => 'failed-member@example.test',
    ]);

    $this->assertDatabaseMissing('members', [
        'member_number' => 'NU-ADMIN-0002',
    ]);

    expect(Storage::disk('public')->allFiles())->toBe([]);
});


<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('allows an admin to replace a member photo and deletes the old file', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $oldPhoto = 'members/old-photo.jpg';

    Storage::disk('public')->put($oldPhoto, 'old photo content');

    $member = Member::factory()->create([
        'photo' => $oldPhoto,
    ]);

    $newEmail = 'updated-member-'.$member->id.'@example.test';

    $response = $this->actingAs($admin)->put(
        route('admin.members.update', $member),
        [
            'name' => 'Updated Member',
            'email' => $newEmail,
            'member_number' => $member->member_number,
            'nik' => $member->nik,
            'birth_place' => $member->birth_place,
            'birth_date' => $member->birth_date->format('Y-m-d'),
            'gender' => $member->gender,
            'phone' => $member->phone,
            'address' => $member->address,
            'status' => $member->status,
            'photo' => UploadedFile::fake()->image('replacement.jpg'),
        ],
    );

    $response->assertRedirect(route('admin.members.index'));

    $member->refresh();

    expect($member->photo)->not->toBe($oldPhoto);

    $this->assertTrue(Storage::disk('public')->exists($member->photo));
    $this->assertFalse(Storage::disk('public')->exists($oldPhoto));

    $this->assertDatabaseHas('users', [
        'id' => $member->user_id,
        'name' => 'Updated Member',
        'email' => $newEmail,
    ]);
});

it('preserves the old photo and rolls back account changes when the member update fails', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $oldPhoto = 'members/old-photo.jpg';

    Storage::disk('public')->put($oldPhoto, 'old photo content');

    $member = Member::factory()->create([
        'photo' => $oldPhoto,
    ]);

    $originalName = $member->user->name;
    $originalEmail = $member->user->email;

    Event::listen(
        'eloquent.updating: '.Member::class,
        fn (): bool => false,
    );

    $response = $this->actingAs($admin)
        ->from(route('admin.members.edit', $member))
        ->put(route('admin.members.update', $member), [
            'name' => 'Should Not Be Saved',
            'email' => 'failed-update-'.$member->id.'@example.test',
            'member_number' => $member->member_number,
            'nik' => $member->nik,
            'birth_place' => $member->birth_place,
            'birth_date' => $member->birth_date->format('Y-m-d'),
            'gender' => $member->gender,
            'phone' => $member->phone,
            'address' => $member->address,
            'status' => $member->status,
            'photo' => UploadedFile::fake()->image('replacement.jpg'),
        ]);

    $response->assertRedirect(route('admin.members.edit', $member));
    $response->assertSessionHasErrors('update');

    $member->refresh();
    $member->load('user');

    expect($member->photo)->toBe($oldPhoto);
    expect($member->user->name)->toBe($originalName);
    expect($member->user->email)->toBe($originalEmail);

    $this->assertTrue(Storage::disk('public')->exists($oldPhoto));

    // The failed replacement should have been removed.
    expect(Storage::disk('public')->allFiles())->toBe([$oldPhoto]);
});

it('allows an admin to delete a member and remove the profile photo', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $photo = 'members/photo-to-delete.jpg';

    Storage::disk('public')->put($photo, 'photo content');

    $member = Member::factory()->create([
        'photo' => $photo,
    ]);

    $memberId = $member->id;
    $userId = $member->user_id;

    $response = $this->actingAs($admin)->delete(
        route('admin.members.destroy', $member),
    );

    $response->assertRedirect(route('admin.members.index'));

    $this->assertDatabaseMissing('members', [
        'id' => $memberId,
    ]);

    $this->assertDatabaseMissing('users', [
        'id' => $userId,
    ]);

    $this->assertFalse(Storage::disk('public')->exists($photo));
});

it('preserves member data and photo when account deletion fails', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $photo = 'members/photo-preserved.jpg';

    Storage::disk('public')->put($photo, 'photo content');

    $member = Member::factory()->create([
        'photo' => $photo,
    ]);

    $memberId = $member->id;
    $userId = $member->user_id;

    Event::listen(
        'eloquent.deleting: '.User::class,
        fn (): bool => false,
    );

    $response = $this->actingAs($admin)->delete(
        route('admin.members.destroy', $member),
    );

    $response->assertServerError();

    $this->assertDatabaseHas('members', [
        'id' => $memberId,
        'photo' => $photo,
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $userId,
    ]);

    $this->assertTrue(Storage::disk('public')->exists($photo));
});

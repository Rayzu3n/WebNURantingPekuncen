
<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

test('member can replace profile photo and remove the old file', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'role' => 'member',
    ]);

    $oldPath = UploadedFile::fake()
        ->image('old-photo.jpg')
        ->store('members', 'public');

    $member = Member::factory()->for($user)->create([
        'member_number' => 'NU-PHOTO-001',
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Pekuncen',
        'photo' => $oldPath,
    ]);

    $response = $this->actingAs($user)->patch(
        route('member.profile.update'),
        [
            'nik' => '1234567890123456',
            'birth_place' => 'Pekuncen',
            'birth_date' => '2000-01-01',
            'gender' => 'L',
            'phone' => '081234567890',
            'address' => 'Pekuncen',
            'photo' => UploadedFile::fake()->image('new-photo.jpg'),
        ]
    );

    $response
        ->assertRedirect(route('member.profile'))
        ->assertSessionHas(
            'success',
            'Member profile updated successfully.'
        );

    $updatedMember = $member->fresh();

    expect($updatedMember->photo)->not->toBe($oldPath);

    expect(Storage::disk('public')->exists($oldPath))->toBeFalse();
    expect(Storage::disk('public')->exists($updatedMember->photo))->toBeTrue();
});

test('failed member profile update preserves the old photo', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'role' => 'member',
    ]);

    $oldPath = UploadedFile::fake()
        ->image('old-photo.jpg')
        ->store('members', 'public');

    $member = Member::factory()->for($user)->create([
        'member_number' => 'NU-PHOTO-002',
        'nik' => '1234567890123457',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Pekuncen',
        'photo' => $oldPath,
    ]);

    Event::listen(
        'eloquent.updating: '.Member::class,
        fn (): bool => false
    );

    $response = $this->from(route('member.profile'))
        ->actingAs($user)
        ->patch(route('member.profile.update'), [
            'nik' => '1234567890123457',
            'birth_place' => 'Pekuncen',
            'birth_date' => '2000-01-01',
            'gender' => 'L',
            'phone' => '081234567890',
            'address' => 'Pekuncen',
            'photo' => UploadedFile::fake()->image('replacement.jpg'),
        ]);

    $response
        ->assertRedirect(route('member.profile'))
        ->assertSessionHasErrors('photo');

    expect($member->fresh()->photo)->toBe($oldPath);

    expect(Storage::disk('public')->exists($oldPath))->toBeTrue();

    expect(Storage::disk('public')->allFiles('members'))
        ->toBe([$oldPath]);
});

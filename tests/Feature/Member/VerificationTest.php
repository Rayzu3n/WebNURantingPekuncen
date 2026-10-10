<?php

use App\Models\Member;
use App\Models\User;

test('public verification only displays necessary member information', function () {
    $user = User::factory()->create([
        'role' => 'member',
    ]);

    $member = Member::factory()->for($user)->create([
        'member_number' => 'NU-VERIFY-001',
        'nik' => '1234567890123456',
        'birth_place' => 'Sensitive Birth Place',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Sensitive Home Address',
        'photo' => 'members/private.jpg',
        'status' => 'active',
    ]);

    $response = $this->get(
        route('member.verify', $member->member_number)
    );

    $response
        ->assertOk()
        ->assertSee($user->name)
        ->assertSee($member->member_number)
        ->assertSee('Active Member')
        ->assertDontSee($member->nik)
        ->assertDontSee($member->birth_place)
        ->assertDontSee($member->birth_date->format('d M Y'))
        ->assertDontSee($member->phone)
        ->assertDontSee($member->address)
        ->assertDontSee('private.jpg');
});

test('unknown member numbers return not found', function () {
    $this->get(route('member.verify', 'NU-NOT-FOUND'))
        ->assertNotFound();
});

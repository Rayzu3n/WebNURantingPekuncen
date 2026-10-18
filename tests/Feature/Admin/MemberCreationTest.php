<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows administrators only the minimum member directory fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $memberUser = User::factory()->create([
        'role' => 'member',
        'name' => 'Privacy Test Member',
        'email' => 'private-member@example.test',
    ]);

    Member::factory()->create([
        'user_id' => $memberUser->id,
        'member_number' => 'NU-PRIVACY-001',
        'nik' => '1234567890123456',
        'birth_place' => 'PRIVATE_BIRTH_PLACE',
        'birth_date' => '2001-02-03',
        'address' => 'PRIVATE_HOME_ADDRESS',
        'status' => 'active',
    ]);

    $this->actingAs($admin)
        ->get('/admin/members')
        ->assertOk()
        ->assertSee('Privacy Test Member')
        ->assertSee('NU-PRIVACY-001')
        ->assertSee('Aktif')
        ->assertDontSee('private-member@example.test')
        ->assertDontSee('1234567890123456')
        ->assertDontSee('PRIVATE_BIRTH_PLACE')
        ->assertDontSee('2001-02-03')
        ->assertDontSee('PRIVATE_HOME_ADDRESS');
});

it('does not expose member creation, edit, update, or delete endpoints to administrators', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $member = Member::factory()->create();

    $this->actingAs($admin)
        ->get('/admin/members/create')
        ->assertNotFound();

    $this->actingAs($admin)
        ->post('/admin/members', [])
        ->assertNotFound();

    $this->actingAs($admin)
        ->get('/admin/members/'.$member->id.'/edit')
        ->assertNotFound();

    $this->actingAs($admin)
        ->put('/admin/members/'.$member->id, [])
        ->assertNotFound();

    $this->actingAs($admin)
        ->delete('/admin/members/'.$member->id)
        ->assertNotFound();
});


it('hides approved applications from the admin review queue and detail route', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $applicant = User::factory()->create([
        'role' => 'member',
        'account_status' => 'active',
        'name' => 'Approved Privacy Applicant',
        'email' => 'approved-private@example.test',
    ]);

    $application = \\App\\Models\\MembershipApplication::create([
        'user_id' => $applicant->id,
        'registration_number' => 'REG-APPROVED-PRIVACY-001',
        'access_token_hash' => hash('sha256', 'private-token'),
        'nik' => '1234567890123456',
        'birth_place' => 'PRIVATE_BIRTH_PLACE',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'PRIVATE_HOME_ADDRESS',
        'status' => 'approved',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.membership-applications.index'))
        ->assertOk()
        ->assertDontSee('REG-APPROVED-PRIVACY-001')
        ->assertDontSee('approved-private@example.test')
        ->assertDontSee('PRIVATE_BIRTH_PLACE')
        ->assertDontSee('PRIVATE_HOME_ADDRESS');

    $this->actingAs($admin)
        ->get(route('admin.membership-applications.show', $application))
        ->assertNotFound();
});

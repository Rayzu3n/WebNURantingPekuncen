<?php

use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function validMembershipRegistration(array $overrides = []): array
{
    return array_merge([
        'name' => 'Test Applicant',
        'email' => 'applicant@example.test',
        'password' => 'StrongPassword123!',
        'password_confirmation' => 'StrongPassword123!',
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Pekuncen, Indonesia',
        'terms' => '1',
    ], $overrides);
}

test('registration requires a valid sixteen digit NIK', function () {
    $this->from(route('register'))
        ->post(route('register'), validMembershipRegistration(['nik' => '12345']))
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('nik');

    $this->assertDatabaseCount('users', 0);
    $this->assertDatabaseCount('membership_applications', 0);
});

test('registration creates a pending account and stores NIK encrypted', function () {
    $response = $this->post(route('register'), validMembershipRegistration());

    $response->assertRedirect(route('membership.pending'))
        ->assertSessionHas('registration_number')
        ->assertSessionHas('registration_token');

    $user = User::where('email', 'applicant@example.test')->firstOrFail();
    $application = MembershipApplication::where('user_id', $user->id)->firstOrFail();
    $storedNik = DB::table('membership_applications')->where('id', $application->id)->value('nik');

    expect($user->role)->toBe('member')
        ->and($user->account_status)->toBe('pending')
        ->and($application->status)->toBe('pending_review')
        ->and($application->nik)->toBe('1234567890123456')
        ->and($storedNik)->not->toBe('1234567890123456')
        ->and($storedNik)->not->toContain('1234567890123456')
        ->and(Member::count())->toBe(0);
});

test('pending members cannot access the member dashboard or card', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-20261017-TEST0001',
        'access_token_hash' => hash('sha256', 'secret-token'),
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $this->actingAs($user)
        ->get(route('member.dashboard'))
        ->assertRedirect(route('membership.pending'));

    $this->actingAs($user)
        ->get(route('member.card'))
        ->assertRedirect(route('membership.pending'));
});

test('admin approval creates a member and activates the account', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-20261017-TEST0002',
        'access_token_hash' => hash('sha256', 'secret-token'),
        'nik' => '6543210987654321',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2001-02-03',
        'gender' => 'P',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'approve',
            'admin_note' => 'Application verified.',
        ])
        ->assertRedirect(route('admin.membership-applications.index'));

    $user->refresh();
    $application->refresh();
    $member = Member::where('user_id', $user->id)->firstOrFail();

    expect($user->account_status)->toBe('active')
        ->and($application->status)->toBe('approved')
        ->and($member->nik)->toBe('6543210987654321')
        ->and(str_starts_with($member->member_number, 'NU-'))->toBeTrue();
});

test('tracking requires both the registration number and secret token', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-20261017-TRACK001',
        'access_token_hash' => hash('sha256', 'correct-secret-token'),
        'nik' => '9876543210987654',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2002-03-04',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $this->post(route('membership.track.store'), [
        'registration_number' => 'REG-20261017-TRACK001',
        'access_token' => 'wrong-token',
    ])->assertSessionHasErrors('tracking');

    $this->post(route('membership.track.store'), [
        'registration_number' => 'REG-20261017-TRACK001',
        'access_token' => 'correct-secret-token',
    ])->assertOk()
        ->assertViewIs('membership.tracking-result')
        ->assertViewHas('status', 'pending_review');
});

test('applicants can resubmit a returned application for review', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-20261017-REVISION1',
        'access_token_hash' => hash('sha256', 'secret-token'),
        'nik' => '1111222233334444',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Old address',
        'status' => 'needs_revision',
        'admin_note' => 'Please confirm your address.',
    ]);

    $this->actingAs($user)
        ->patch(route('membership.revise.update'), [
            'name' => 'Updated Applicant',
            'nik' => '1111222233334444',
            'birth_place' => 'Pekuncen',
            'birth_date' => '2000-01-01',
            'gender' => 'L',
            'address' => 'Updated address',
        ])
        ->assertRedirect(route('membership.pending'));

    $application->refresh();
    $user->refresh();

    expect($application->status)->toBe('pending_review')
        ->and($application->address)->toBe('Updated address')
        ->and($application->admin_note)->toBeNull()
        ->and($user->name)->toBe('Updated Applicant')
        ->and($user->account_status)->toBe('pending');
});

test('pending applicants can sign in and are redirected to application status', function () {
    $user = User::factory()->create([
        'name' => 'Pending Applicant',
        'email' => 'pending-login@example.test',
        'password' => 'StrongPassword123!',
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-20261018-LOGIN001',
        'access_token_hash' => hash('sha256', 'private-token'),
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $this->post('/login', [
        'email' => 'pending-login@example.test',
        'password' => 'StrongPassword123!',
    ])->assertRedirect(route('dashboard'));

    $this->get(route('dashboard'))
        ->assertRedirect(route('membership.pending'));
});

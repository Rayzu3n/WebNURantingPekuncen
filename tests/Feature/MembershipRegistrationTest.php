<?php

use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        ->assertSessionHasErrors('nik')
        ->assertSessionMissing('_old_input.nik');

    $this->assertDatabaseCount('users', 0);
    $this->assertDatabaseCount('membership_applications', 0);
});



test('duplicate registration does not flash the NIK into session old input', function () {
    Member::factory()->create([
        'nik' => '1234567890123456',
    ]);

    $this->from(route('register'))
        ->post(route('register'), validMembershipRegistration())
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('nik')
        ->assertSessionMissing('_old_input.nik')
        ->assertSessionMissing('_old_input.nik_fingerprint');

    $this->assertDatabaseCount('membership_applications', 0);
});

test('applicant photos are private until approval and preview is admin-only', function () {
    Storage::fake('membership-private');
    Storage::fake('public');

    $this->post(route('register'), validMembershipRegistration([
        'photo' => UploadedFile::fake()->image('applicant.png'),
    ]))->assertRedirect(route('membership.pending'));

    $applicant = User::where('email', 'applicant@example.test')->firstOrFail();
    $application = MembershipApplication::where('user_id', $applicant->id)->firstOrFail();

    expect($application->photo)->toStartWith('membership-applications/');

    Storage::disk('membership-private')->assertExists($application->photo);
    Storage::disk('public')->assertMissing($application->photo);

    $this->actingAs($applicant)
        ->get(route('admin.membership-applications.photo', $application))
        ->assertForbidden();

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('admin.membership-applications.photo', $application))
        ->assertOk()
        ->assertHeader('x-content-type-options', 'nosniff');
});


test('approval promotes an applicant photo to public member storage and deletes the private copy', function () {
    Storage::fake('membership-private');
    Storage::fake('public');

    $photoPath = UploadedFile::fake()->image('applicant.png')
        ->store('membership-applications', 'membership-private');

    $applicant = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $applicant->id,
        'registration_number' => 'REG-PRIVATE-PHOTO-001',
        'access_token_hash' => hash('sha256', 'private-photo-token'),
        'nik' => '4321098765432109',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'photo' => $photoPath,
        'status' => 'pending_review',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'approve',
            'admin_note' => 'Identity verified.',
        ])
        ->assertRedirect(route('admin.membership-applications.index'));

    $member = Member::where('user_id', $applicant->id)->firstOrFail();

    expect($member->photo)->toStartWith('members/');

    Storage::disk('public')->assertExists($member->photo);
    Storage::disk('membership-private')->assertMissing($photoPath);
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


test('pending page displays the current application status from the database', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-PENDING-PAGE-001',
        'access_token_hash' => hash('sha256', 'private-token'),
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $this->actingAs($user)
        ->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Pending Review')
        ->assertSee('Track application')
        ->assertDontSee('Revise application');
});

test('pending page shows administrator revision notes and a revise action', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-REVISION-PAGE-001',
        'access_token_hash' => hash('sha256', 'private-token'),
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'needs_revision',
        'admin_note' => 'Please upload a clearer identity photo.',
    ]);

    $this->actingAs($user)
        ->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Your application needs revision')
        ->assertSee('Please upload a clearer identity photo.')
        ->assertSee('Revise application')
        ->assertSee(route('membership.revise'))
        ->assertDontSee('Track application');
});


test('rejected applicants can view the decision while member features stay restricted', function () {
    $user = User::factory()->create([
        'role' => 'member',
        'account_status' => 'suspended',
    ]);

    MembershipApplication::create([
        'user_id' => $user->id,
        'registration_number' => 'REG-REJECTED-PAGE-001',
        'access_token_hash' => hash('sha256', 'private-token'),
        'nik' => '1234567890123456',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'rejected',
        'admin_note' => 'Please contact the administrator for further information.',
    ]);

    $this->actingAs($user)
        ->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Application rejected')
        ->assertSee('Please contact the administrator for further information.')
        ->assertDontSee('Revise application')
        ->assertDontSee('Track application');

    $this->actingAs($user)
        ->get(route('member.dashboard'))
        ->assertForbidden();

    $this->post(route('logout'))
        ->assertRedirect('/');

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->get(route('dashboard'))
        ->assertRedirect(route('membership.pending'));

    $this->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Application rejected')
        ->assertSee('Please contact the administrator for further information.');
});


test('admin rejection suspends the applicant without creating a member record', function () {
    $applicant = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $applicant->id,
        'registration_number' => 'REG-REJECT-WORKFLOW-001',
        'access_token_hash' => hash('sha256', 'reject-workflow-token'),
        'nik' => '5555666677778888',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'reject',
            'admin_note' => 'The submitted details could not be verified.',
        ])
        ->assertRedirect(route('admin.membership-applications.index'));

    $application->refresh();
    $applicant->refresh();

    expect($application->status)->toBe('rejected')
        ->and($application->admin_note)->toBe('The submitted details could not be verified.')
        ->and($applicant->account_status)->toBe('suspended')
        ->and(Member::where('user_id', $applicant->id)->exists())->toBeFalse();
});


test('admin request revision updates the database status and displays it to the applicant', function () {
    $applicant = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $applicant->id,
        'registration_number' => 'REG-ADMIN-REVISION-001',
        'access_token_hash' => hash('sha256', 'revision-token'),
        'nik' => '6666777788889999',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'needs_revision',
            'admin_note' => 'Please upload a clearer identity photo.',
        ])
        ->assertRedirect(route('admin.membership-applications.index'));

    $application->refresh();

    expect($application->status)->toBe('needs_revision')
        ->and($application->admin_note)->toBe('Please upload a clearer identity photo.')
        ->and($applicant->fresh()->account_status)->toBe('pending');

    $this->actingAs($applicant)
        ->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Needs Revision')
        ->assertSee('Please upload a clearer identity photo.')
        ->assertSee(route('membership.revise'));
});

test('admin must provide a note when requesting an application revision', function () {
    $applicant = User::factory()->create([
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $applicant->id,
        'registration_number' => 'REG-ADMIN-REVISION-NOTE-001',
        'access_token_hash' => hash('sha256', 'revision-note-token'),
        'nik' => '7777888899990000',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'address' => 'Pekuncen, Indonesia',
        'status' => 'pending_review',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->from(route('admin.membership-applications.show', $application))
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'needs_revision',
            'admin_note' => '',
        ])
        ->assertRedirect(route('admin.membership-applications.show', $application))
        ->assertSessionHasErrors('admin_note');

    expect($application->fresh()->status)->toBe('pending_review');
});


test('full membership workflow from revision request through approval grants member access', function () {
    $applicant = User::factory()->create([
        'name' => 'Revision Applicant',
        'role' => 'member',
        'account_status' => 'pending',
    ]);

    $application = MembershipApplication::create([
        'user_id' => $applicant->id,
        'registration_number' => 'REG-FULL-WORKFLOW-001',
        'access_token_hash' => hash('sha256', 'full-workflow-token'),
        'nik' => '8888999900001111',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Old address',
        'status' => 'pending_review',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    // Admin requests a revision and provides an actionable note.
    $this->actingAs($admin)
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'needs_revision',
            'admin_note' => 'Please confirm your current address.',
        ])
        ->assertRedirect(route('admin.membership-applications.index'));

    $application->refresh();

    expect($application->status)->toBe('needs_revision')
        ->and($application->admin_note)->toBe('Please confirm your current address.');

    // Applicant sees the live status and opens the existing revision form.
    $this->actingAs($applicant)
        ->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Needs Revision')
        ->assertSee('Please confirm your current address.')
        ->assertSee(route('membership.revise'));

    $this->get(route('membership.revise'))
        ->assertOk()
        ->assertViewIs('membership.revise');

    // Applicant corrects the data and resubmits it.
    $this->patch(route('membership.revise.update'), [
        'name' => 'Revision Applicant Updated',
        'nik' => '8888999900001111',
        'birth_place' => 'Pekuncen',
        'birth_date' => '2000-01-01',
        'gender' => 'L',
        'phone' => '081234567890',
        'address' => 'Updated address',
    ])->assertRedirect(route('membership.pending'));

    $application->refresh();
    $applicant->refresh();

    expect($application->status)->toBe('pending_review')
        ->and($application->admin_note)->toBeNull()
        ->and($application->reviewed_by)->toBeNull()
        ->and($application->reviewed_at)->toBeNull()
        ->and($application->address)->toBe('Updated address')
        ->and($applicant->name)->toBe('Revision Applicant Updated')
        ->and($applicant->account_status)->toBe('pending')
        ->and(Member::where('user_id', $applicant->id)->exists())->toBeFalse();

    $this->get(route('membership.pending'))
        ->assertOk()
        ->assertSee('Pending Review')
        ->assertDontSee('Please confirm your current address.');

    // Admin approves the corrected application.
    $this->actingAs($admin)
        ->post(route('admin.membership-applications.decide', $application), [
            'decision' => 'approve',
            'admin_note' => 'Verified after revision.',
        ])
        ->assertRedirect(route('admin.membership-applications.index'));

    $application->refresh();
    $applicant->refresh();
    $member = Member::where('user_id', $applicant->id)->firstOrFail();

    expect($application->status)->toBe('approved')
        ->and($application->admin_note)->toBe('Verified after revision.')
        ->and($applicant->account_status)->toBe('active')
        ->and($member->status)->toBe('active')
        ->and($member->nik)->toBe('8888999900001111')
        ->and(str_starts_with($member->member_number, 'NU-'))->toBeTrue()
        ->and(Member::where('user_id', $applicant->id)->count())->toBe(1);

    // The approved applicant can now use member features.
    $this->actingAs($applicant)
        ->get(route('dashboard'))
        ->assertRedirect(route('member.dashboard'));

    $this->get(route('member.dashboard'))->assertOk();
    $this->get(route('member.card'))->assertOk();
});

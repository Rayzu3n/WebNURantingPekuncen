<?php

use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists only applications that still require an admin decision', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $fixtures = [
        ['REG-QUEUE-PENDING-001', 'pending_review', 'pending', '1000000000000001'],
        ['REG-QUEUE-REVISION-001', 'needs_revision', 'pending', '1000000000000002'],
        ['REG-QUEUE-REJECTED-001', 'rejected', 'suspended', '1000000000000003'],
        ['REG-QUEUE-APPROVED-001', 'approved', 'active', '1000000000000004'],
    ];

    foreach ($fixtures as [$registrationNumber, $status, $accountStatus, $nik]) {
        $applicant = User::factory()->create([
            'role' => 'member',
            'account_status' => $accountStatus,
        ]);

        MembershipApplication::create([
            'user_id' => $applicant->id,
            'registration_number' => $registrationNumber,
            'access_token_hash' => hash('sha256', $registrationNumber),
            'nik' => $nik,
            'birth_place' => 'Pekuncen',
            'birth_date' => '2000-01-01',
            'gender' => 'L',
            'address' => 'Pekuncen, Indonesia',
            'status' => $status,
        ]);
    }

    $this->actingAs($admin)
        ->get(route('admin.membership-applications.index'))
        ->assertOk()
        ->assertSee('REG-QUEUE-PENDING-001')
        ->assertSee('REG-QUEUE-REVISION-001')
        ->assertDontSee('REG-QUEUE-REJECTED-001')
        ->assertDontSee('REG-QUEUE-APPROVED-001');
});

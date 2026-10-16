<?php

use App\Models\OrganizationProfile;
use App\Models\User;

test('public can view organization profile and only filled sections appear', function () {
    OrganizationProfile::create([
        'name' => 'NU Ranting Pekuncen',
        'tagline' => 'Ruang kontribusi warga.',
        'history' => 'Profil sejarah resmi.',
        'vision' => 'Menjadi organisasi yang bermanfaat.',
        'mission' => "Melayani warga\nMengembangkan kegiatan",
        'structure' => "Ketua\nSekretaris",
        'programs' => 'Kegiatan sosial',
        'contact_email' => 'info@example.com',
    ]);

    $this->get(route('about'))
        ->assertOk()
        ->assertSeeText('NU Ranting Pekuncen')
        ->assertSeeText('Profil sejarah resmi.')
        ->assertSeeText('Menjadi organisasi yang bermanfaat.')
        ->assertSeeText('Struktur organisasi')
        ->assertSeeText('Kegiatan sosial')
        ->assertSee('mailto:info@example.com');
});

test('public profile handles an unconfigured organization profile', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSeeText('NU Ranting Pekuncen')
        ->assertSeeText('Profil organisasi sedang disiapkan.');
});

test('guest cannot manage organization profile', function () {
    $this->get(route('admin.organization-profile.edit'))
        ->assertRedirect(route('login'));
});

test('admin can update organization profile', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('admin.organization-profile.edit'))
        ->assertOk()
        ->assertSeeText('Tentang Kami');

    $this->actingAs($admin)
        ->patch(route('admin.organization-profile.update'), [
            'name' => 'NU Ranting Pekuncen',
            'tagline' => 'Dekat dengan warga.',
            'history' => 'Sejarah yang telah diverifikasi.',
            'vision' => 'Bermanfaat untuk warga.',
            'mission' => "Melayani\nBerkolaborasi",
            'structure' => "Ketua\nSekretaris",
            'programs' => 'Program sosial',
            'address' => 'Pekuncen',
            'contact_email' => 'contact@example.com',
            'contact_phone' => '+628123456789',
            'website_url' => 'https://example.com',
            'facebook_url' => '',
            'instagram_url' => '',
        ])
        ->assertRedirect(route('admin.organization-profile.edit'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('organization_profiles', [
        'name' => 'NU Ranting Pekuncen',
        'tagline' => 'Dekat dengan warga.',
        'contact_email' => 'contact@example.com',
    ]);
});

test('member cannot manage organization profile', function () {
    $member = User::factory()->create(['role' => 'member']);

    $this->actingAs($member)
        ->get(route('admin.organization-profile.edit'))
        ->assertForbidden();
});

test('organization profile validates public contact fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->from(route('admin.organization-profile.edit'))
        ->patch(route('admin.organization-profile.update'), [
            'name' => '',
            'contact_email' => 'not-an-email',
            'website_url' => 'javascript:alert(1)',
        ])
        ->assertRedirect(route('admin.organization-profile.edit'))
        ->assertSessionHasErrors(['name', 'contact_email', 'website_url']);

    expect(OrganizationProfile::count())->toBe(0);
});

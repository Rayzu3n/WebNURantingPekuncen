<?php

use App\Models\Banom;
use App\Models\User;

test('public directory only shows active Banom profiles and listed officers', function () {
    $active = Banom::create([
        'name' => 'GP Ansor Ranting Pekuncen',
        'slug' => 'gp-ansor-ranting-pekuncen',
        'category' => 'Badan Otonom Kepemudaan',
        'title' => 'Gerakan Pemuda Ansor',
        'description' => 'Profil organisasi yang telah dikonfirmasi.',
        'is_active' => true,
        'sort_order' => 1,
    ]);
    $active->members()->create([
        'position' => 'Ketua',
        'name' => 'Nama Pengurus Uji',
        'sort_order' => 0,
    ]);

    Banom::create([
        'name' => 'Banom Tidak Tampil',
        'slug' => 'banom-tidak-tampil',
        'category' => 'Badan Otonom',
        'description' => 'Profil internal yang disembunyikan.',
        'is_active' => false,
        'sort_order' => 2,
    ]);

    $this->get(route('banoms.index'))
        ->assertOk()
        ->assertSeeText('GP Ansor Ranting Pekuncen')
        ->assertSeeText('Nama Pengurus Uji')
        ->assertSeeText('Badan Otonom Kepemudaan')
        ->assertDontSeeText('Banom Tidak Tampil')
        ->assertDontSeeText('Profil internal yang disembunyikan.');
});

test('public Banom directory handles an empty dataset', function () {
    $this->get(route('banoms.index'))
        ->assertOk()
        ->assertSeeText('Data Banom sedang disiapkan');
});

test('admin can create, update, and delete a Banom with officers', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.banoms.store'), [
            'name' => 'Fatayat NU Ranting Pekuncen',
            'category' => 'Perempuan dan keluarga',
            'title' => 'Fatayat NU',
            'description' => 'Profil organisasi untuk pengujian.',
            'term' => '2025–2028',
            'sort_order' => 1,
            'is_active' => '1',
            'members' => [
                ['position' => 'Ketua', 'name' => 'Ketua Uji'],
                ['position' => 'Sekretaris', 'name' => 'Sekretaris Uji'],
            ],
        ])
        ->assertRedirect(route('admin.banoms.index'))
        ->assertSessionHas('success', 'Data Banom berhasil ditambahkan.');

    $banom = Banom::query()
        ->with('members')
        ->where('slug', 'fatayat-nu-ranting-pekuncen')
        ->firstOrFail();

    expect($banom->members)->toHaveCount(2);

    $this->actingAs($admin)
        ->put(route('admin.banoms.update', $banom), [
            'name' => 'Fatayat NU Ranting Pekuncen',
            'category' => 'Perempuan dan keluarga',
            'title' => 'Fatayat NU Ranting Pekuncen',
            'description' => 'Profil organisasi yang diperbarui.',
            'sort_order' => 2,
            'is_active' => '1',
            'members' => [
                ['position' => 'Ketua', 'name' => 'Ketua Baru'],
            ],
        ])
        ->assertRedirect(route('admin.banoms.index'))
        ->assertSessionHas('success', 'Data Banom berhasil diperbarui.');

    $this->assertDatabaseHas('banoms', [
        'id' => $banom->id,
        'title' => 'Fatayat NU Ranting Pekuncen',
        'description' => 'Profil organisasi yang diperbarui.',
        'sort_order' => 2,
    ]);
    $this->assertDatabaseHas('banom_members', [
        'banom_id' => $banom->id,
        'position' => 'Ketua',
        'name' => 'Ketua Baru',
    ]);
    $this->assertDatabaseMissing('banom_members', [
        'banom_id' => $banom->id,
        'name' => 'Sekretaris Uji',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.banoms.destroy', $banom))
        ->assertRedirect(route('admin.banoms.index'))
        ->assertSessionHas('success', 'Data Banom berhasil dihapus.');

    $this->assertDatabaseMissing('banoms', ['id' => $banom->id]);
    $this->assertDatabaseMissing('banom_members', ['banom_id' => $banom->id]);
});

test('guest and member cannot access the Banom management area', function () {
    $this->get(route('admin.banoms.index'))
        ->assertRedirect(route('login'));

    $member = User::factory()->create(['role' => 'member']);

    $this->actingAs($member)
        ->get(route('admin.banoms.index'))
        ->assertForbidden();
});

test('Banom management validates required organization fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->from(route('admin.banoms.create'))
        ->post(route('admin.banoms.store'), [
            'name' => '',
            'category' => '',
            'description' => '',
        ])
        ->assertRedirect(route('admin.banoms.create'))
        ->assertSessionHasErrors(['name', 'category', 'description']);

    $this->assertDatabaseCount('banoms', 0);
});

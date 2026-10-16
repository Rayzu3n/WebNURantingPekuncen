<?php

use App\Models\Event;
use App\Models\User;

test('public agenda shows published upcoming events and excludes drafts', function () {
    $published = Event::create([
        'title' => 'Pengajian Bulanan',
        'slug' => 'pengajian-bulanan',
        'category' => 'Pengajian',
        'description' => 'Deskripsi kegiatan.',
        'starts_at' => now()->addDays(3),
        'status' => 'published',
        'published_at' => now()->subMinute(),
    ]);

    Event::create([
        'title' => 'Agenda Internal',
        'slug' => 'agenda-internal',
        'description' => 'Draft tidak untuk publik.',
        'starts_at' => now()->addDays(5),
        'status' => 'draft',
    ]);

    $this->get(route('events.index'))
        ->assertOk()
        ->assertSeeText($published->title)
        ->assertDontSeeText('Agenda Internal');
});

test('public can read published event details but not a draft', function () {
    $published = Event::create([
        'title' => 'Kerja Bakti',
        'slug' => 'kerja-bakti',
        'description' => 'Warga berkumpul bersama.',
        'starts_at' => now()->addDay(),
        'status' => 'published',
    ]);

    $draft = Event::create([
        'title' => 'Rapat Internal',
        'slug' => 'rapat-internal',
        'description' => 'Draft internal.',
        'starts_at' => now()->addDays(2),
        'status' => 'draft',
    ]);

    $this->get(route('events.show', $published->slug))
        ->assertOk()
        ->assertSeeText($published->title)
        ->assertSeeText('Warga berkumpul bersama.');

    $this->get(route('events.show', $draft->slug))->assertNotFound();
});

test('admin can create an event and keep it in draft', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post(route('admin.events.store'), [
        'title' => 'Rapat Ranting',
        'slug' => 'rapat-ranting',
        'category' => 'Organisasi',
        'excerpt' => 'Koordinasi pengurus.',
        'description' => 'Pembahasan program kerja.',
        'location' => 'Sekretariat Ranting',
        'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
        'status' => 'draft',
    ]);

    $response->assertRedirect(route('admin.events.index'))
        ->assertSessionHas('success', 'Kegiatan berhasil dibuat.');

    $this->assertDatabaseHas('events', [
        'slug' => 'rapat-ranting',
        'status' => 'draft',
        'published_at' => null,
    ]);

    $this->get(route('events.show', 'rapat-ranting'))->assertNotFound();
});

test('guest cannot manage events', function () {
    $this->get(route('admin.events.index'))->assertRedirect(route('login'));
});

test('admin can update and delete an event', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $event = Event::create([
        'author_id' => $admin->id,
        'title' => 'Nama Lama',
        'slug' => 'nama-lama',
        'description' => 'Deskripsi lama.',
        'starts_at' => now()->addDays(4),
        'status' => 'draft',
    ]);

    $this->actingAs($admin)
        ->put(route('admin.events.update', $event), [
            'title' => 'Nama Baru',
            'slug' => 'nama-baru',
            'category' => 'Sosial',
            'description' => 'Deskripsi baru.',
            'starts_at' => now()->addDays(6)->format('Y-m-d H:i:s'),
            'status' => 'published',
        ])
        ->assertRedirect(route('admin.events.index'))
        ->assertSessionHas('success', 'Kegiatan berhasil diperbarui.');

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'slug' => 'nama-baru',
        'status' => 'published',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.events.destroy', $event->fresh()))
        ->assertRedirect(route('admin.events.index'))
        ->assertSessionHas('success', 'Kegiatan berhasil dihapus.');

    $this->assertDatabaseMissing('events', ['id' => $event->id]);
});

<?php

use App\Models\ContactMessage;
use App\Models\User;

test('visitor can submit a contact message', function () {
    $this->get(route('contact.index'))->assertOk();

    $this->post(route('contact.store'), [
        'name' => 'Ayu Warga',
        'email' => 'ayu@example.com',
        'subject' => 'Informasi kegiatan',
        'message' => 'Saya ingin mengetahui jadwal kegiatan berikutnya.',
        'website' => '',
    ])
        ->assertRedirect(route('contact.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Ayu Warga',
        'email' => 'ayu@example.com',
        'subject' => 'Informasi kegiatan',
        'status' => 'new',
    ]);
});

test('contact form validates required fields and email format', function () {
    $this->from(route('contact.index'))
        ->post(route('contact.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => '',
            'website' => '',
        ])
        ->assertRedirect(route('contact.index'))
        ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

    expect(ContactMessage::count())->toBe(0);
});

test('honeypot submissions are acknowledged without being stored', function () {
    $this->post(route('contact.store'), [
        'name' => 'Automated Sender',
        'email' => 'bot@example.com',
        'subject' => 'Spam',
        'message' => 'Automated message',
        'website' => 'https://example.com',
    ])
        ->assertRedirect(route('contact.index'))
        ->assertSessionHas('success');

    expect(ContactMessage::count())->toBe(0);
});

test('guest cannot access the admin contact inbox', function () {
    $this->get(route('admin.messages.index'))
        ->assertRedirect(route('login'));
});

test('admin can read update and delete contact messages', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $message = ContactMessage::create([
        'name' => 'Warga Pekuncen',
        'email' => 'warga@example.com',
        'subject' => 'Saran portal',
        'message' => 'Mohon tambahkan jadwal kegiatan.',
        'status' => 'new',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.messages.show', $message))
        ->assertOk()
        ->assertSeeText('Saran portal')
        ->assertSeeText('Mohon tambahkan jadwal kegiatan.');

    $this->assertDatabaseHas('contact_messages', [
        'id' => $message->id,
        'status' => 'read',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.messages.update', $message), ['status' => 'replied'])
        ->assertRedirect(route('admin.messages.show', $message))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'id' => $message->id,
        'status' => 'replied',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.messages.destroy', $message))
        ->assertRedirect(route('admin.messages.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
});

test('member cannot access the admin contact inbox', function () {
    $member = User::factory()->create(['role' => 'member']);

    $this->actingAs($member)
        ->get(route('admin.messages.index'))
        ->assertForbidden();
});

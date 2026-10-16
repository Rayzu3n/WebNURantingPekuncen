<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'status' => ['nullable', 'in:new,read,replied,archived'],
        ]);

        $status = $validated['status'] ?? null;

        $messages = ContactMessage::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'unreadCount' => ContactMessage::unread()->count(),
            'currentStatus' => $status,
        ]);
    }

    public function show(ContactMessage $message): View
    {
        if ($message->status === 'new') {
            $message->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,read,replied,archived'],
        ]);

        $attributes = ['status' => $validated['status']];

        if ($validated['status'] === 'new') {
            $attributes['read_at'] = null;
        } elseif (! $message->read_at) {
            $attributes['read_at'] = now();
        }

        $message->update($attributes);

        return redirect()
            ->route('admin.messages.show', $message)
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact.index');
    }

    public function store(Request $request): RedirectResponse
    {
        // Simple honeypot field: bots often fill every field, while real users never see it.
        if ($request->filled('website')) {
            return redirect()
                ->route('contact.index')
                ->with('success', 'Pesan berhasil dikirim. Terima kasih telah menghubungi kami.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Pesan berhasil dikirim. Terima kasih telah menghubungi kami.');
    }
}

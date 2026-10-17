<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->with('author')
            ->latest('starts_at')
            ->paginate(12);

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'event' => new Event([
                'starts_at' => now()->addWeek()->startOfHour(),
                'status' => 'draft',
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEvent($request);
        $coverImage = null;

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('events', 'public');

            if ($coverImage === false) {
                return back()->withInput()->withErrors([
                    'cover_image' => 'Gambar kegiatan gagal disimpan. Silakan coba lagi.',
                ]);
            }

            $validated['cover_image'] = $coverImage;
        }

        $validated['author_id'] = $request->user()->id;
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        try {
            Event::create($validated);
        } catch (\Throwable $exception) {
            if ($coverImage) {
                Storage::disk('public')->delete($coverImage);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $this->validateEvent($request, $event);
        $oldCoverImage = $event->cover_image;
        $newCoverImage = null;

        if ($request->hasFile('cover_image')) {
            $newCoverImage = $request->file('cover_image')->store('events', 'public');

            if ($newCoverImage === false) {
                return back()->withInput()->withErrors([
                    'cover_image' => 'Gambar kegiatan gagal disimpan. Silakan coba lagi.',
                ]);
            }

            $validated['cover_image'] = $newCoverImage;
        }

        $validated['published_at'] = $validated['status'] === 'published'
            ? ($event->published_at ?? now())
            : null;

        try {
            $updated = $event->update($validated);
        } catch (\Throwable $exception) {
            if ($newCoverImage) {
                Storage::disk('public')->delete($newCoverImage);
            }

            throw $exception;
        }

        if (! $updated) {
            if ($newCoverImage) {
                Storage::disk('public')->delete($newCoverImage);
            }

            return back()->withInput()->withErrors([
                'update' => 'Kegiatan gagal diperbarui. Silakan coba lagi.',
            ]);
        }

        if ($newCoverImage && $oldCoverImage) {
            Storage::disk('public')->delete($oldCoverImage);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $coverImage = $event->cover_image;

        if (! $event->delete()) {
            return redirect()
                ->route('admin.events.index')
                ->with('error', 'Kegiatan gagal dihapus. Silakan coba lagi.');
        }

        if ($coverImage) {
            Storage::disk('public')->delete($coverImage);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateEvent(Request $request, ?Event $event = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'unique:events,slug'.($event ? ','.$event->id : ''),
            ],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
    }
}

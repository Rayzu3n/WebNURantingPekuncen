<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $published = Event::query()
            ->published()
            ->when($category, fn ($query) => $query->where('category', $category));

        $upcomingEvents = (clone $published)
            ->upcomingOrOngoing()
            ->orderBy('starts_at')
            ->paginate(6, ['*'], 'upcoming_page')
            ->withQueryString();

        $archivedEvents = (clone $published)
            ->archivedByDate()
            ->orderByDesc('starts_at')
            ->paginate(6, ['*'], 'archive_page')
            ->withQueryString();

        $categories = Event::query()
            ->published()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('events.index', compact(
            'upcomingEvents',
            'archivedEvents',
            'categories',
            'category'
        ));
    }

    public function show(string $slug): View
    {
        $event = Event::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedEvents = Event::query()
            ->published()
            ->whereKeyNot($event->id)
            ->where(function ($query) use ($event) {
                if ($event->category) {
                    $query->where('category', $event->category);
                } else {
                    $query->where('starts_at', '>=', now());
                }
            })
            ->orderBy('starts_at')
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Municipality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display the Events and Announcements management page.
     */
    public function index(): View
    {
        $events = Event::with('municipality')
            ->orderBy('event_date', 'desc')
            ->get();

        $announcements = Announcement::orderBy('published_at', 'desc')
            ->get();

        $municipalities = Municipality::orderBy('name')->get();

        return view('super-admin.events', compact('events', 'announcements', 'municipalities'));
    }

    /**
     * Store a newly created event.
     */
    public function storeEvent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'event_date'      => ['required', 'date'],
            'location'        => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'municipality_id' => ['nullable', 'exists:municipalities,id'],
            'image_url'       => ['nullable', 'string', 'max:500'],
        ]);

        $validated['municipality_id'] = $validated['municipality_id'] ?? 1; // Default to Gubat

        Event::create($validated);

        return back()->with('success', "Event '{$validated['title']}' created successfully.");
    }

    /**
     * Update an existing event.
     */
    public function updateEvent(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'event_date'      => ['required', 'date'],
            'location'        => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'municipality_id' => ['nullable', 'exists:municipalities,id'],
            'image_url'       => ['nullable', 'string', 'max:500'],
        ]);

        $validated['municipality_id'] = $validated['municipality_id'] ?? $event->municipality_id ?? 1;

        $event->update($validated);

        return back()->with('success', "Event '{$event->title}' updated successfully.");
    }

    /**
     * Delete an event.
     */
    public function destroyEvent(Event $event): RedirectResponse
    {
        $title = $event->title;
        $event->delete();

        return back()->with('success', "Event '{$title}' has been deleted.");
    }

    /**
     * Store a newly created announcement.
     */
    public function storeAnnouncement(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'category'     => ['required', 'string', 'max:100'],
            'content'      => ['required', 'string', 'max:2000'],
            'published_at' => ['nullable', 'date'],
            'image_url'    => ['nullable', 'string', 'max:500'],
        ]);

        $validated['published_at'] = $validated['published_at'] ? \Carbon\Carbon::parse($validated['published_at']) : now();

        Announcement::create($validated);

        return back()->with('success', "Announcement '{$validated['title']}' published successfully.");
    }

    /**
     * Update an existing announcement.
     */
    public function updateAnnouncement(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'category'     => ['required', 'string', 'max:100'],
            'content'      => ['required', 'string', 'max:2000'],
            'published_at' => ['nullable', 'date'],
            'image_url'    => ['nullable', 'string', 'max:500'],
        ]);

        $validated['published_at'] = $validated['published_at'] ? \Carbon\Carbon::parse($validated['published_at']) : $announcement->published_at;

        $announcement->update($validated);

        return back()->with('success', "Announcement '{$announcement->title}' updated successfully.");
    }

    /**
     * Delete an announcement.
     */
    public function destroyAnnouncement(Announcement $announcement): RedirectResponse
    {
        $title = $announcement->title;
        $announcement->delete();

        return back()->with('success', "Announcement '{$title}' has been deleted.");
    }
}

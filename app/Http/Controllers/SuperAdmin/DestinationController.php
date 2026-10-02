<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    /**
     * Display the LGU Admin Destinations page.
     */
    public function index(): View
    {
        $destinations = Destination::with('municipality')
            ->orderByDesc('featured')
            ->orderBy('name')
            ->paginate(20);

        return view('super-admin.destinations', compact('destinations'));
    }

    /**
     * Update the specified destination.
     */
    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'category'       => ['required', 'string', 'max:100'],
            'description'    => ['nullable', 'string', 'max:2000'],
            'image_url'      => ['nullable', 'string', 'max:500'],
            'google_map_url' => ['nullable', 'url', 'max:500'],
            'featured'       => ['nullable'],
        ]);

        $destination->update([
            'name'           => $validated['name'],
            'category'       => $validated['category'],
            'description'    => $validated['description'] ?? null,
            'image_url'      => $validated['image_url'] ?? null,
            'google_map_url' => $validated['google_map_url'] ?? null,
            'featured'       => $request->has('featured'),
        ]);

        return back()->with('success', "Destination '{$destination->name}' updated successfully.");
    }

    /**
     * Toggle the featured status of the specified destination.
     */
    public function toggleFeatured(Destination $destination): RedirectResponse
    {
        $destination->update([
            'featured' => !$destination->featured,
        ]);

        $status = $destination->featured ? 'marked as Featured' : 'reverted to Standard';

        return back()->with('success', "Destination '{$destination->name}' has been {$status}.");
    }
}

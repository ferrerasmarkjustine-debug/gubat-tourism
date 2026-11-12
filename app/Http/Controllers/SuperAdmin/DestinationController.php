<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Barangay;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    use HandlesImageUpload;

    /**
     * Display the LGU Admin Destinations page.
     */
    public function index(): View
    {
        $destinations = Destination::with(['municipality', 'barangay'])
            ->orderByDesc('is_spotlight')
            ->orderByDesc('featured')
            ->orderBy('name')
            ->paginate(20);

        $spotlightDestinations = Destination::where('is_spotlight', true)
            ->with(['municipality', 'barangay'])
            ->get();

        $trashedDestinations = Destination::onlyTrashed()
            ->with(['municipality', 'barangay'])
            ->orderByDesc('deleted_at')
            ->get();

        $barangays = Barangay::orderBy('name')->get();

        return view('super-admin.destinations', compact('destinations', 'spotlightDestinations', 'trashedDestinations', 'barangays'));
    }

    /**
     * Store a newly created destination.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'barangay_id'      => ['nullable', 'exists:barangays,id'],
            'category'         => ['required', 'string', 'max:100'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'image'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'        => ['nullable', 'string', 'max:500'],
            'gallery_images'   => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'google_map_url'   => ['nullable', 'url', 'max:500'],
            'featured'         => ['nullable'],
            'is_spotlight'     => ['nullable'],
        ]);

        $finalImageUrl = $this->handleImageUpload($request, 'destinations')
            ?: 'images/destinations/rizal_beach.jpg';

        $galleryImages = $this->handleMultipleImagesUpload($request, 'destinations', [], 'gallery_images', 'retained_gallery_images', 10);

        $isSpotlight = false;
        if ($request->has('is_spotlight')) {
            $currentSpotlightsCount = Destination::where('is_spotlight', true)->count();
            if ($currentSpotlightsCount < 2) {
                $isSpotlight = true;
            }
        }

        $destination = Destination::create([
            'municipality_id' => 1, // Default to Gubat
            'barangay_id'     => $validated['barangay_id'] ?? null,
            'name'            => $validated['name'],
            'category'        => $validated['category'],
            'description'     => $validated['description'] ?? null,
            'image_url'       => $finalImageUrl,
            'gallery_images'  => !empty($galleryImages) ? $galleryImages : null,
            'rating'          => 5.0,
            'reviews_count'   => 0,
            'google_map_url'  => $validated['google_map_url'] ?? null,
            'featured'        => $request->has('featured'),
            'is_spotlight'    => $isSpotlight,
        ]);

        return back()->with('success', "New destination '{$destination->name}' has been added successfully!");
    }

    /**
     * Update the specified destination.
     */
    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'name'                    => ['required', 'string', 'max:255'],
            'barangay_id'             => ['nullable', 'exists:barangays,id'],
            'category'                => ['required', 'string', 'max:100'],
            'description'             => ['nullable', 'string', 'max:2000'],
            'image'                   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'               => ['nullable', 'string', 'max:500'],
            'gallery_images'          => ['nullable', 'array', 'max:10'],
            'gallery_images.*'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'retained_gallery_images' => ['nullable', 'array'],
            'google_map_url'          => ['nullable', 'url', 'max:500'],
            'featured'                => ['nullable'],
            'is_spotlight'            => ['nullable'],
        ]);

        $finalImageUrl = $this->handleImageUpload($request, 'destinations', $destination->image_url)
            ?? $destination->image_url;

        $existingGallery = is_array($destination->gallery_images) ? $destination->gallery_images : [];
        $galleryImages = $this->handleMultipleImagesUpload($request, 'destinations', $existingGallery, 'gallery_images', 'retained_gallery_images', 10);

        $isSpotlight = $destination->is_spotlight;
        if ($request->has('is_spotlight')) {
            $otherSpotlightsCount = Destination::where('is_spotlight', true)
                ->where('id', '!=', $destination->id)
                ->count();
            $isSpotlight = ($otherSpotlightsCount < 2);
        } else {
            $isSpotlight = false;
        }

        $destination->update([
            'barangay_id'    => $validated['barangay_id'] ?? null,
            'name'           => $validated['name'],
            'category'       => $validated['category'],
            'description'    => $validated['description'] ?? null,
            'image_url'      => $finalImageUrl,
            'gallery_images' => !empty($galleryImages) ? $galleryImages : null,
            'google_map_url' => $validated['google_map_url'] ?? null,
            'featured'       => $request->has('featured'),
            'is_spotlight'   => $isSpotlight,
        ]);

        return back()->with('success', "Destination '{$destination->name}' updated successfully.");
    }

    /**
     * Toggle the featured status of the specified destination.
     */
    public function toggleFeatured(Request $request, Destination $destination)
    {
        $destination->update([
            'featured' => !$destination->featured,
        ]);

        $status = $destination->featured ? 'marked as Featured' : 'reverted to Standard';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'featured' => $destination->featured,
                'message'  => "Destination '{$destination->name}' has been {$status}.",
            ]);
        }

        return back()->with('success', "Destination '{$destination->name}' has been {$status}.");
    }

    /**
     * Toggle the spotlight status of the specified destination (max 2 spotlights).
     */
    public function toggleSpotlight(Request $request, Destination $destination)
    {
        $newSpotlightState = !$destination->is_spotlight;

        if ($newSpotlightState) {
            $currentCount = Destination::where('is_spotlight', true)
                ->where('id', '!=', $destination->id)
                ->count();

            if ($currentCount >= 2) {
                $activeSpotlights = Destination::where('is_spotlight', true)->pluck('name')->join(' and ');
                $errorMsg = "Maximum of 2 Signature Spotlights allowed. Currently active: {$activeSpotlights}. Please unpin one first before pinning '{$destination->name}'.";

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                    ], 422);
                }

                return back()->with('error', $errorMsg);
            }
        }

        $destination->update([
            'is_spotlight' => $newSpotlightState,
        ]);

        $statusMsg = $newSpotlightState
            ? "Destination '{$destination->name}' is now pinned to Signature Spotlights!"
            : "Destination '{$destination->name}' has been unpinned from Signature Spotlights.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'is_spotlight' => $newSpotlightState,
                'message'      => $statusMsg,
            ]);
        }

        return back()->with('success', $statusMsg);
    }

    /**
     * Soft delete the specified destination (move to Recently Deleted).
     */
    public function destroy(Destination $destination): RedirectResponse
    {
        $name = $destination->name;
        $destination->delete();

        return back()->with('success', "Destination '{$name}' has been moved to Recently Deleted.");
    }

    /**
     * Restore the specified soft-deleted destination.
     */
    public function restore(int $id): RedirectResponse
    {
        $destination = Destination::onlyTrashed()->findOrFail($id);
        $name = $destination->name;
        $destination->restore();

        return back()->with('success', "Destination '{$name}' has been successfully restored!");
    }

    /**
     * Permanently remove the specified destination from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $destination = Destination::onlyTrashed()->findOrFail($id);
        $name = $destination->name;
        $destination->forceDelete();

        return back()->with('success', "Destination '{$name}' has been permanently deleted from the database.");
    }
}

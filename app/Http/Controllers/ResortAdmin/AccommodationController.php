<?php

namespace App\Http\Controllers\ResortAdmin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Amenity;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccommodationController extends Controller
{
    use HandlesImageUpload;
    /**
     * Display a listing of accommodations for this resort.
     */
    public function index(): View
    {
        $user = auth()->user();
        $resort = $user->resort;

        $accommodations = $resort
            ? Accommodation::where('resort_id', $resort->id)->with('amenities')->latest()->paginate(15)
            : collect();

        return view('resort-admin.accommodations.index', compact('user', 'resort', 'accommodations'));
    }

    /**
     * Show the form for creating a new accommodation request.
     */
    public function create(): View|RedirectResponse
    {
        $user = auth()->user();
        $resort = $user->resort;

        if (!$resort) {
            return redirect()->route('resort.dashboard')->with('error', 'Your account is not linked to any resort yet. Please contact the LGU Administrator.');
        }

        $amenities = Amenity::orderBy('name')->get();

        return view('resort-admin.accommodations.create', compact('user', 'resort', 'amenities'));
    }

    /**
     * Store a newly created accommodation with 'pending' status for LGU review.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $resort = $user->resort;

        if (!$resort) {
            return redirect()->route('resort.dashboard')->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'type'            => ['required', 'string', 'in:room,cottage,villa,dorm'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'max_guests'      => ['required', 'integer', 'min:1', 'max:50'],
            'total_units'     => ['required', 'integer', 'min:1', 'max:100'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'image'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'       => ['nullable', 'url', 'max:500'],
            'amenities'       => ['nullable', 'array'],
            'amenities.*'     => ['exists:amenities,id'],
        ]);

        $finalImageUrl = $this->handleImageUpload($request, 'accommodations')
            ?: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80';

        $accommodation = Accommodation::create([
            'resort_id'        => $resort->id,
            'name'             => $validated['name'],
            'type'             => $validated['type'],
            'price_per_night'  => $validated['price_per_night'],
            'max_guests'       => $validated['max_guests'],
            'total_units'      => $validated['total_units'],
            'description'      => $validated['description'] ?? null,
            'image_url'        => $finalImageUrl,
            'status'           => 'pending', // Pending LGU Tourism Office Approval
            'rejection_reason' => null,
        ]);

        if (!empty($validated['amenities'])) {
            $accommodation->amenities()->sync($validated['amenities']);
        }

        return redirect()->route('resort.accommodations.index')->with(
            'success',
            "Accommodation '{$accommodation->name}' has been submitted! It is now pending review and approval by the LGU Tourism Office."
        );
    }

    /**
     * Show the form for editing an accommodation.
     */
    public function edit(Accommodation $accommodation): View|RedirectResponse
    {
        $user = auth()->user();
        $resort = $user->resort;

        if (!$resort || $accommodation->resort_id !== $resort->id) {
            abort(403, 'Unauthorized. You can only edit accommodations belonging to your assigned resort.');
        }

        $amenities = Amenity::orderBy('name')->get();
        $selectedAmenities = $accommodation->amenities()->pluck('amenities.id')->toArray();

        return view('resort-admin.accommodations.edit', compact('user', 'resort', 'accommodation', 'amenities', 'selectedAmenities'));
    }

    /**
     * Update the specified accommodation.
     */
    public function update(Request $request, Accommodation $accommodation): RedirectResponse
    {
        $user = auth()->user();
        $resort = $user->resort;

        if (!$resort || $accommodation->resort_id !== $resort->id) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'type'            => ['required', 'string', 'in:room,cottage,villa,dorm'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'max_guests'      => ['required', 'integer', 'min:1', 'max:50'],
            'total_units'     => ['required', 'integer', 'min:1', 'max:100'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'image'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'       => ['nullable', 'url', 'max:500'],
            'amenities'       => ['nullable', 'array'],
            'amenities.*'     => ['exists:amenities,id'],
        ]);

        $finalImageUrl = $this->handleImageUpload($request, 'accommodations', $accommodation->image_url)
            ?: $accommodation->image_url;

        $accommodation->update([
            'name'            => $validated['name'],
            'type'            => $validated['type'],
            'price_per_night' => $validated['price_per_night'],
            'max_guests'      => $validated['max_guests'],
            'total_units'     => $validated['total_units'],
            'description'     => $validated['description'] ?? null,
            'image_url'       => $finalImageUrl,
        ]);

        $accommodation->amenities()->sync($validated['amenities'] ?? []);

        return redirect()->route('resort.accommodations.index')->with(
            'success',
            "Accommodation '{$accommodation->name}' has been updated successfully!"
        );
    }
}

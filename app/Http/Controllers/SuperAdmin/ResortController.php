<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\Barangay;
use App\Models\User;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResortController extends Controller
{
    use HandlesImageUpload;

    /**
     * Display the LGU Admin Resorts page.
     */
    public function index(): View
    {
        $resorts = Resort::with(['barangay', 'accommodations', 'admins'])
            ->orderBy('name')
            ->paginate(20);
        $barangays = Barangay::orderBy('name')->get();
        $unassignedAdmins = User::where('role', 'resort_admin')
            ->orderBy('name')
            ->get();

        return view('super-admin.resorts', compact('resorts', 'barangays', 'unassignedAdmins'));
    }

    /**
     * Show form to create a new resort.
     */
    public function create(): View
    {
        $barangays = Barangay::orderBy('name')->get();
        $unassignedAdmins = User::where('role', 'resort_admin')
            ->whereNull('resort_id')
            ->orderBy('name')
            ->get();

        return view('super-admin.resorts-create', compact('barangays', 'unassignedAdmins'));
    }

    /**
     * Store a newly created resort in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'barangay_id'      => ['required', 'exists:barangays,id'],
            'category'         => ['required', 'string', 'in:luxury,eco,homestay,budget'],
            'address'          => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'image'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'        => ['nullable', 'url', 'max:500'],
            'gallery_images'   => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'google_map_url'   => ['nullable', 'url', 'max:500'],
            'is_lgu_approved'  => ['nullable', 'boolean'],
            'admin_user_id'    => ['nullable', 'exists:users,id'],
        ]);

        $finalImageUrl = $this->handleImageUpload($request, 'resorts')
            ?: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80';

        $galleryImages = $this->handleMultipleImagesUpload($request, 'resorts', [], 'gallery_images', 'retained_gallery_images', 10);

        $resort = Resort::create([
            'name'            => $validated['name'],
            'barangay_id'     => $validated['barangay_id'],
            'category'        => $validated['category'],
            'address'         => $validated['address'] ?? null,
            'description'     => $validated['description'] ?? null,
            'image_url'       => $finalImageUrl,
            'gallery_images'  => !empty($galleryImages) ? $galleryImages : null,
            'google_map_url'  => $validated['google_map_url'] ?? null,
            'is_lgu_approved' => $request->boolean('is_lgu_approved', true),
            'rating'          => 5.0,
            'reviews_count'   => 0,
            'featured'        => false,
        ]);

        // If an admin user was selected, assign them to this new resort
        if (!empty($validated['admin_user_id'])) {
            User::where('id', $validated['admin_user_id'])->update(['resort_id' => $resort->id]);
        }

        return redirect()->route('admin.resorts')->with('success', "Resort '{$resort->name}' has been successfully created!");
    }

    /**
     * Update the specified resort in storage.
     */
    public function update(Request $request, Resort $resort): RedirectResponse
    {
        $validated = $request->validate([
            'name'                    => ['required', 'string', 'max:255'],
            'barangay_id'             => ['required', 'exists:barangays,id'],
            'category'                => ['required', 'string', 'in:luxury,eco,homestay,budget'],
            'address'                 => ['nullable', 'string', 'max:255'],
            'description'             => ['nullable', 'string', 'max:2000'],
            'image'                   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'               => ['nullable', 'url', 'max:500'],
            'gallery_images'          => ['nullable', 'array', 'max:10'],
            'gallery_images.*'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'retained_gallery_images' => ['nullable', 'array'],
            'google_map_url'          => ['nullable', 'url', 'max:500'],
            'is_lgu_approved'         => ['nullable', 'boolean'],
            'featured'                => ['nullable', 'boolean'],
            'admin_user_id'           => ['nullable', 'exists:users,id'],
        ]);

        $finalImageUrl = $this->handleImageUpload($request, 'resorts', $resort->image_url) ?: $resort->image_url;

        $existingGallery = is_array($resort->gallery_images) ? $resort->gallery_images : [];
        $galleryImages = $this->handleMultipleImagesUpload($request, 'resorts', $existingGallery, 'gallery_images', 'retained_gallery_images', 10);

        $resort->update([
            'name'            => $validated['name'],
            'barangay_id'     => $validated['barangay_id'],
            'category'        => $validated['category'],
            'address'         => $validated['address'] ?? null,
            'description'     => $validated['description'] ?? null,
            'image_url'       => $finalImageUrl,
            'gallery_images'  => !empty($galleryImages) ? $galleryImages : null,
            'google_map_url'  => $validated['google_map_url'] ?? null,
            'is_lgu_approved' => $request->boolean('is_lgu_approved'),
            'featured'        => $request->boolean('featured'),
        ]);

        if (array_key_exists('admin_user_id', $validated)) {
            if (!empty($validated['admin_user_id'])) {
                User::where('id', $validated['admin_user_id'])->update(['resort_id' => $resort->id]);
            }
        }

        return redirect()->route('admin.resorts')->with('success', "Resort '{$resort->name}' has been successfully updated!");
    }

    /**
     * Delete the specified resort from storage.
     */
    public function destroy(Resort $resort): RedirectResponse
    {
        $name = $resort->name;
        User::where('resort_id', $resort->id)->update(['resort_id' => null]);
        $resort->delete();

        return redirect()->route('admin.resorts')->with('success', "Resort '{$name}' has been deleted.");
    }
}

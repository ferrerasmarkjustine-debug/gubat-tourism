<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Craft;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CraftController extends Controller
{
    use HandlesImageUpload;

    /**
     * Category mapping definitions.
     */
    protected array $categories = [
        'abaca' => [
            'name' => 'Abaca Weaving',
            'badge_color' => '#8D6E63',
        ],
        'pottery' => [
            'name' => 'Clay Pottery',
            'badge_color' => '#d97706',
        ],
        'culinary' => [
            'name' => 'Native Delicacies',
            'badge_color' => '#198754',
        ],
        'souvenirs' => [
            'name' => 'Eco-Wood & Souvenirs',
            'badge_color' => '#0284c7',
        ],
    ];

    /**
     * Display the Crafts management page in Super Admin.
     */
    public function index(): View
    {
        $crafts = Craft::orderBy('id', 'desc')->get();
        $categories = $this->categories;

        return view('super-admin.crafts', compact('crafts', 'categories'));
    }

    /**
     * Store a newly created craft.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'category_slug'    => ['required', 'string', 'in:abaca,pottery,culinary,souvenirs'],
            'description'      => ['required', 'string', 'max:2000'],
            'highlight'        => ['nullable', 'string', 'max:255'],
            'products'         => ['nullable', 'string', 'max:1000'],
            'address'          => ['nullable', 'string', 'max:255'],
            'barangay'         => ['nullable', 'string', 'max:100'],
            'google_map_url'   => ['nullable', 'url', 'max:500'],
            'contact'          => ['nullable', 'string', 'max:100'],
            'is_featured'      => ['nullable'],
            'image'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'        => ['nullable', 'url', 'max:500'],
            'gallery_images'   => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $categoryConfig = $this->categories[$validated['category_slug']] ?? [
            'name' => ucfirst($validated['category_slug']),
            'badge_color' => '#8D6E63',
        ];

        // Process products list into array
        $productsArray = [];
        if (!empty($validated['products'])) {
            $productsArray = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['products']))));
        }

        $finalImageUrl = $this->handleImageUpload($request, 'crafts', null, 'image', 'image_url');
        $galleryImages = $this->handleMultipleImagesUpload($request, 'crafts', [], 'gallery_images', 'retained_gallery_images', 10);

        Craft::create([
            'name'           => $validated['name'],
            'category_slug'  => $validated['category_slug'],
            'category_name'  => $categoryConfig['name'],
            'badge_color'    => $categoryConfig['badge_color'],
            'description'    => $validated['description'],
            'highlight'      => $validated['highlight'] ?? null,
            'products'       => $productsArray,
            'image_url'      => $finalImageUrl,
            'gallery_images' => !empty($galleryImages) ? $galleryImages : null,
            'address'        => $validated['address'] ?? null,
            'barangay'       => $validated['barangay'] ?? null,
            'google_map_url' => $validated['google_map_url'] ?? null,
            'contact'        => $validated['contact'] ?? null,
            'is_featured'    => $request->has('is_featured'),
        ]);

        return back()->with('success', "Craft entry '{$validated['name']}' created successfully.");
    }

    /**
     * Update an existing craft.
     */
    public function update(Request $request, Craft $craft): RedirectResponse
    {
        $validated = $request->validate([
            'name'                    => ['required', 'string', 'max:255'],
            'category_slug'           => ['required', 'string', 'in:abaca,pottery,culinary,souvenirs'],
            'description'             => ['required', 'string', 'max:2000'],
            'highlight'               => ['nullable', 'string', 'max:255'],
            'products'                => ['nullable', 'string', 'max:1000'],
            'address'                 => ['nullable', 'string', 'max:255'],
            'barangay'                => ['nullable', 'string', 'max:100'],
            'google_map_url'          => ['nullable', 'url', 'max:500'],
            'contact'                 => ['nullable', 'string', 'max:100'],
            'is_featured'             => ['nullable'],
            'image'                   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url'               => ['nullable', 'url', 'max:500'],
            'gallery_images'          => ['nullable', 'array', 'max:10'],
            'gallery_images.*'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'retained_gallery_images' => ['nullable', 'array'],
        ]);

        $categoryConfig = $this->categories[$validated['category_slug']] ?? [
            'name' => ucfirst($validated['category_slug']),
            'badge_color' => '#8D6E63',
        ];

        // Process products list into array
        $productsArray = [];
        if (!empty($validated['products'])) {
            $productsArray = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['products']))));
        }

        $finalImageUrl = $this->handleImageUpload($request, 'crafts', $craft->image_url, 'image', 'image_url') ?? $craft->image_url;

        $existingGallery = is_array($craft->gallery_images) ? $craft->gallery_images : [];
        $galleryImages = $this->handleMultipleImagesUpload($request, 'crafts', $existingGallery, 'gallery_images', 'retained_gallery_images', 10);

        $craft->update([
            'name'           => $validated['name'],
            'category_slug'  => $validated['category_slug'],
            'category_name'  => $categoryConfig['name'],
            'badge_color'    => $categoryConfig['badge_color'],
            'description'    => $validated['description'],
            'highlight'      => $validated['highlight'] ?? null,
            'products'       => $productsArray,
            'image_url'      => $finalImageUrl,
            'gallery_images' => !empty($galleryImages) ? $galleryImages : null,
            'address'        => $validated['address'] ?? null,
            'barangay'       => $validated['barangay'] ?? null,
            'google_map_url' => $validated['google_map_url'] ?? null,
            'contact'        => $validated['contact'] ?? null,
            'is_featured'    => $request->has('is_featured'),
        ]);

        return back()->with('success', "Craft entry '{$craft->name}' updated successfully.");
    }

    /**
     * Delete a craft.
     */
    public function destroy(Craft $craft): RedirectResponse
    {
        $name = $craft->name;

        // Clean up uploaded image if applicable
        if ($craft->image_url && Str::startsWith($craft->image_url, 'images/crafts/')) {
            $imagePath = public_path($craft->image_url);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $craft->delete();

        return back()->with('success', "Craft entry '{$name}' has been deleted.");
    }

    /**
     * Toggle featured status on homepage.
     */
    public function toggleFeatured(Craft $craft): RedirectResponse
    {
        $craft->is_featured = !$craft->is_featured;
        $craft->save();

        $status = $craft->is_featured ? 'featured on homepage' : 'removed from homepage';
        return back()->with('success', "'{$craft->name}' is now {$status}.");
    }
}

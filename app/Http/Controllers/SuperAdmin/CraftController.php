<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Craft;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CraftController extends Controller
{
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
            'name'           => ['required', 'string', 'max:255'],
            'category_slug'  => ['required', 'string', 'in:abaca,pottery,culinary,souvenirs'],
            'description'    => ['required', 'string', 'max:2000'],
            'highlight'      => ['nullable', 'string', 'max:255'],
            'products'       => ['nullable', 'string', 'max:1000'],
            'address'        => ['nullable', 'string', 'max:255'],
            'barangay'       => ['nullable', 'string', 'max:100'],
            'google_map_url' => ['nullable', 'url', 'max:500'],
            'contact'        => ['nullable', 'string', 'max:100'],
            'is_featured'    => ['nullable'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'image_url'      => ['nullable', 'url', 'max:500'],
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

        // Process image upload or URL
        $finalImageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $filename = 'craft_' . time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $destinationPath = public_path('images/crafts');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $imageFile->move($destinationPath, $filename);
            $finalImageUrl = 'images/crafts/' . $filename;
        }

        Craft::create([
            'name'           => $validated['name'],
            'category_slug'  => $validated['category_slug'],
            'category_name'  => $categoryConfig['name'],
            'badge_color'    => $categoryConfig['badge_color'],
            'description'    => $validated['description'],
            'highlight'      => $validated['highlight'] ?? null,
            'products'       => $productsArray,
            'image_url'      => $finalImageUrl,
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
            'name'           => ['required', 'string', 'max:255'],
            'category_slug'  => ['required', 'string', 'in:abaca,pottery,culinary,souvenirs'],
            'description'    => ['required', 'string', 'max:2000'],
            'highlight'      => ['nullable', 'string', 'max:255'],
            'products'       => ['nullable', 'string', 'max:1000'],
            'address'        => ['nullable', 'string', 'max:255'],
            'barangay'       => ['nullable', 'string', 'max:100'],
            'google_map_url' => ['nullable', 'url', 'max:500'],
            'contact'        => ['nullable', 'string', 'max:100'],
            'is_featured'    => ['nullable'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'image_url'      => ['nullable', 'url', 'max:500'],
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

        // Process image upload
        $finalImageUrl = $craft->image_url;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $filename = 'craft_' . time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $destinationPath = public_path('images/crafts');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $imageFile->move($destinationPath, $filename);

            // Clean up old local image if it exists in images/crafts
            if ($craft->image_url && Str::startsWith($craft->image_url, 'images/crafts/')) {
                $oldPath = public_path($craft->image_url);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $finalImageUrl = 'images/crafts/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $finalImageUrl = $validated['image_url'];
        }

        $craft->update([
            'name'           => $validated['name'],
            'category_slug'  => $validated['category_slug'],
            'category_name'  => $categoryConfig['name'],
            'badge_color'    => $categoryConfig['badge_color'],
            'description'    => $validated['description'],
            'highlight'      => $validated['highlight'] ?? null,
            'products'       => $productsArray,
            'image_url'      => $finalImageUrl,
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

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResortController extends Controller
{
    /**
     * Display the LGU Admin Resorts page.
     */
    public function index(): View
    {
        $resorts = Resort::with(['barangay', 'accommodations', 'admins'])
            ->orderBy('name')
            ->paginate(20);

        return view('super-admin.resorts', compact('resorts'));
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
            'name'            => ['required', 'string', 'max:255'],
            'barangay_id'     => ['required', 'exists:barangays,id'],
            'category'        => ['required', 'string', 'in:luxury,eco,homestay,budget'],
            'address'         => ['nullable', 'string', 'max:255'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'image_url'       => ['nullable', 'url', 'max:500'],
            'google_map_url'  => ['nullable', 'url', 'max:500'],
            'is_lgu_approved' => ['nullable', 'boolean'],
            'admin_user_id'   => ['nullable', 'exists:users,id'],
        ]);

        $resort = Resort::create([
            'name'            => $validated['name'],
            'barangay_id'     => $validated['barangay_id'],
            'category'        => $validated['category'],
            'address'         => $validated['address'] ?? null,
            'description'     => $validated['description'] ?? null,
            'image_url'       => $validated['image_url'] ?: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80',
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
}

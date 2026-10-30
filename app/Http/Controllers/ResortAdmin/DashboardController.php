<?php

namespace App\Http\Controllers\ResortAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Resort Admin Dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Load only the assigned resort and its relationships
        $resort = $user->resort()
            ->with(['barangay', 'accommodations'])
            ->first();

        $totalAccommodations = $resort ? $resort->accommodations()->count() : 0;
        $totalBookings        = $resort ? $resort->bookings()->count() : 0;

        $totalUnits = $resort ? (int) $resort->accommodations()->sum('total_units') : 0;

        $today = now()->toDateString();
        $occupiedUnitsToday = $resort
            ? (int) $resort->bookings()
                ->where('bookings.status', 'confirmed')
                ->where('bookings.check_in', '<=', $today)
                ->where('bookings.check_out', '>', $today)
                ->sum('bookings.rooms_booked')
            : 0;

        $availableUnitsToday = max(0, $totalUnits - $occupiedUnitsToday);

        $fullyBookedRooms = $resort
            ? $resort->accommodations()->get()->filter(fn($a) => $a->available_units === 0)
            : collect();

        return view('resort-admin.dashboard', compact(
            'user',
            'resort',
            'totalAccommodations',
            'totalBookings',
            'totalUnits',
            'occupiedUnitsToday',
            'availableUnitsToday',
            'fullyBookedRooms'
        ));
    }

    /**
     * Update the logged in resort admin's cellphone number.
     */
    public function updatePhone(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'max:25', 'regex:/^((\+63)|0)?\s?9\d{2}[\s\-]?\d{3}[\s\-]?\d{4}$/'],
        ], [
            'phone_number.required' => 'Please provide your cellphone number.',
            'phone_number.regex' => 'Please enter a valid Philippine cellphone number (e.g. 0917 123 4567 or +63 917 123 4567).',
        ]);

        $user = $request->user();
        $user->phone_number = trim($validated['phone_number']);
        $user->save();

        return back()->with('success', 'Your cellphone number has been saved successfully!');
    }
}

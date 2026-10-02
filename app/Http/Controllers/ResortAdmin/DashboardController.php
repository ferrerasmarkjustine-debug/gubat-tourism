<?php

namespace App\Http\Controllers\ResortAdmin;

use App\Http\Controllers\Controller;
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
                ->where('status', 'confirmed')
                ->where('check_in', '<=', $today)
                ->where('check_out', '>', $today)
                ->sum('rooms_booked')
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
}

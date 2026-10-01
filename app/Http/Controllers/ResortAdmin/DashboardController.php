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
        $totalBookings = $resort ? $resort->bookings()->count() : 0;

        return view('resort-admin.dashboard', compact(
            'user',
            'resort',
            'totalAccommodations',
            'totalBookings'
        ));
    }
}

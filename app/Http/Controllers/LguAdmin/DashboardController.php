<?php

namespace App\Http\Controllers\LguAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\User;
use App\Models\Destination;
use App\Models\Booking;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the LGU Admin Dashboard.
     */
    public function index(): View
    {
        $totalResorts = Resort::count();
        $totalResortAdmins = User::where('role', 'resort_admin')->count();
        $activeResortAdmins = User::where('role', 'resort_admin')->where('is_active', true)->count();
        $inactiveResortAdmins = $totalResortAdmins - $activeResortAdmins;
        $totalDestinations = Destination::count();
        $totalReservations = Booking::count();

        $recentAdmins = User::where('role', 'resort_admin')
            ->with('resort')
            ->latest()
            ->take(5)
            ->get();

        $resorts = Resort::with(['barangay', 'admins'])->latest()->take(5)->get();

        return view('super-admin.dashboard', compact(
            'totalResorts',
            'totalResortAdmins',
            'activeResortAdmins',
            'inactiveResortAdmins',
            'totalDestinations',
            'totalReservations',
            'recentAdmins',
            'resorts'
        ));
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the LGU Super Admin Dashboard.
     */
    public function index(): View
    {
        $totalResorts = Resort::count();
        $totalResortAdmins = User::where('role', 'resort_admin')->count();
        $activeResortAdmins = User::where('role', 'resort_admin')->where('is_active', true)->count();
        $inactiveResortAdmins = $totalResortAdmins - $activeResortAdmins;

        $recentAdmins = User::where('role', 'resort_admin')
            ->with('resort')
            ->latest()
            ->take(5)
            ->get();

        $resortsWithoutAdmin = Resort::doesntHave('admins')->count();

        return view('super-admin.dashboard', compact(
            'totalResorts',
            'totalResortAdmins',
            'activeResortAdmins',
            'inactiveResortAdmins',
            'recentAdmins',
            'resortsWithoutAdmin'
        ));
    }
}

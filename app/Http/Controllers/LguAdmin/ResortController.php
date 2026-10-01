<?php

namespace App\Http\Controllers\LguAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use Illuminate\View\View;

class ResortController extends Controller
{
    /**
     * Display a listing of resorts in the LGU Admin portal.
     */
    public function index(): View
    {
        $resorts = Resort::with(['barangay', 'admins', 'accommodations'])
            ->orderBy('name')
            ->get();

        return view('super-admin.resorts', compact('resorts'));
    }
}

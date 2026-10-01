<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
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
}

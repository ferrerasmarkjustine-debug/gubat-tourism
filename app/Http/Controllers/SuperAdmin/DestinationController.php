<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\View\View;

class DestinationController extends Controller
{
    /**
     * Display the LGU Admin Destinations page.
     */
    public function index(): View
    {
        $destinations = Destination::with('municipality')
            ->orderByDesc('featured')
            ->orderBy('name')
            ->paginate(20);

        return view('super-admin.destinations', compact('destinations'));
    }
}

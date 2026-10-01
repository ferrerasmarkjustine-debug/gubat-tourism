<?php

namespace App\Http\Controllers\LguAdmin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\View\View;

class DestinationController extends Controller
{
    /**
     * Display a listing of destinations in the LGU Admin portal.
     */
    public function index(): View
    {
        $destinations = Destination::with('municipality')->orderBy('name')->get();

        return view('super-admin.destinations', compact('destinations'));
    }
}

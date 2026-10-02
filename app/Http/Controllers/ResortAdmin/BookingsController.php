<?php

namespace App\Http\Controllers\ResortAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingsController extends Controller
{
    /**
     * Display bookings for the resort admin's assigned resort only.
     */
    public function index(Request $request): View
    {
        $user  = $request->user();
        $resort = $user->resort()->with('accommodations')->first();

        // Fetch bookings only for this resort's accommodations
        $bookings = collect();
        if ($resort) {
            $accommodationIds = $resort->accommodations->pluck('id');

            $bookings = Booking::with(['accommodation'])
                ->whereIn('accommodation_id', $accommodationIds)
                ->latest()
                ->paginate(20);
        }

        return view('resort-admin.bookings', compact('resort', 'bookings'));
    }
}

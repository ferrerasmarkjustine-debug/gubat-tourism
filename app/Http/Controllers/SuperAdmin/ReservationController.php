<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display the LGU Admin Reservations overview page.
     */
    public function index(): View
    {
        $bookings = Booking::with(['accommodation.resort'])
            ->latest()
            ->paginate(20);

        return view('super-admin.reservations', compact('bookings'));
    }
}

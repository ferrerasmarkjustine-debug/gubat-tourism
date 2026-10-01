<?php

namespace App\Http\Controllers\LguAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations in the LGU Admin portal.
     */
    public function index(): View
    {
        $bookings = Booking::with(['accommodation.resort'])->latest()->paginate(15);

        return view('super-admin.reservations', compact('bookings'));
    }
}

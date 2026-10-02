<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the booking confirmation form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $accommodationId = $request->input('accommodation_id');
        $resortId        = $request->input('resort_id');

        $accommodation = null;

        if ($accommodationId) {
            $accommodation = Accommodation::with('resort')->find($accommodationId);
        } elseif ($resortId) {
            $resort = \App\Models\Resort::with('accommodations')->find($resortId);
            if ($resort) {
                $accommodation = $resort->accommodations()->first();
                if (!$accommodation) {
                    $accommodation = Accommodation::create([
                        'resort_id'       => $resort->id,
                        'name'            => 'Standard Room',
                        'type'            => 'room',
                        'price_per_night' => 1500.00,
                        'max_guests'      => 2,
                        'total_units'     => 5,
                        'description'     => 'Standard accommodation at ' . $resort->name,
                    ]);
                    $accommodation->load('resort');
                }
            }
        }

        // If neither or not found, fall back to first available accommodation
        if (!$accommodation) {
            $accommodation = Accommodation::with('resort')->first();
        }

        if (!$accommodation) {
            return redirect()->route('search')->with('error', 'No accommodations available.');
        }

        $checkIn    = $request->input('check_in');
        $checkOut   = $request->input('check_out');
        $rooms      = max(1, (int) $request->input('rooms', 1));
        $adults     = max(1, (int) $request->input('adults', 2));
        $children   = max(0, (int) $request->input('children', 0));

        // Calculate nights and total
        $nights = 1;
        $totalPrice = $accommodation->price_per_night * $rooms;
        if ($checkIn && $checkOut) {
            try {
                $start = Carbon::parse($checkIn);
                $end   = Carbon::parse($checkOut);
                if ($end->greaterThan($start)) {
                    $nights = $start->diffInDays($end);
                }
            } catch (\Exception $e) {}
        }
        $totalPrice = $accommodation->price_per_night * $rooms * $nights;

        return view('resorts.booking', compact(
            'accommodation', 'checkIn', 'checkOut', 'rooms', 'adults', 'children', 'nights', 'totalPrice'
        ));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request): RedirectResponse
    {
        // Handle flexible/unspecified dates gracefully
        if (!$request->filled('check_in')) {
            $request->merge(['check_in' => now()->toDateString()]);
        }
        if (!$request->filled('check_out')) {
            $checkInDate = Carbon::parse($request->input('check_in'));
            $request->merge(['check_out' => $checkInDate->copy()->addDay()->toDateString()]);
        }

        $validated = $request->validate([
            'accommodation_id' => ['required', 'exists:accommodations,id'],
            'guest_name'       => ['required', 'string', 'max:255'],
            'guest_email'      => ['required', 'email', 'max:255'],
            'guest_phone'      => ['required', 'string', 'max:50'],
            'check_in'         => ['required', 'date'],
            'check_out'        => ['required', 'date', 'after:check_in'],
            'rooms_booked'     => ['required', 'integer', 'min:1', 'max:20'],
            'guests_count'     => ['required', 'integer', 'min:1'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ]);

        $accommodation = Accommodation::findOrFail($validated['accommodation_id']);
        $roomsRequested = (int) $validated['rooms_booked'];

        // Live Overbooking Protection Check
        $bookedCount = $accommodation->getBookedUnitsCount($validated['check_in'], $validated['check_out']);
        $availableUnits = max(0, $accommodation->total_units - $bookedCount);

        if ($roomsRequested > $availableUnits) {
            return back()->withInput()->withErrors([
                'rooms_booked' => $availableUnits > 0
                    ? "Only {$availableUnits} unit(s) of '{$accommodation->name}' are remaining for the selected dates. Please adjust your room count."
                    : "Sorry, '{$accommodation->name}' is fully booked for the selected dates. Please choose different dates or select another room."
            ]);
        }

        $booking = Booking::create([
            'accommodation_id' => $validated['accommodation_id'],
            'guest_name'       => $validated['guest_name'],
            'guest_email'      => $validated['guest_email'],
            'guest_phone'      => $validated['guest_phone'] ?? null,
            'check_in'         => $validated['check_in'],
            'check_out'        => $validated['check_out'],
            'rooms_booked'     => $validated['rooms_booked'],
            'guests_count'     => $validated['guests_count'],
            'special_requests' => $validated['special_requests'] ?? null,
            'status'           => 'confirmed',
        ]);

        return redirect()->route('booking.success', $booking->id);
    }

    /**
     * Show booking success/confirmation page.
     */
    public function success(Booking $booking): View
    {
        $booking->load('accommodation.resort');
        return view('resorts.booking-success', compact('booking'));
    }
}

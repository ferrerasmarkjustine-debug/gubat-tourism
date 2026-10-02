<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Resort;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    /**
     * Display search results.
     */
    public function index(Request $request): View
    {
        // 1. Inputs validation & defaults
        $municipality = $request->input('municipality', 'Gubat');
        $barangay = $request->input('barangay');
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $adults = intval($request->input('adults', 2));
        $children = intval($request->input('children', 0));
        $roomsRequested = intval($request->input('rooms', 1));

        // Backward compatibility if only guests was sent
        if ($request->has('guests') && !$request->has('adults')) {
            $adults = max(1, intval($request->input('guests', 2)));
        }

        $childAges = $request->input('child_ages', []);
        if (!is_array($childAges)) {
            $childAges = [];
        }
        
        $minBudget = floatval($request->input('min_budget', 0));
        $maxBudget = floatval($request->input('max_budget', 20000));
        $category = $request->input('category');
        $type = $request->input('type');
        $selectedAmenities = $request->input('amenities', []);

        $totalGuests = $adults + $children;
        if ($totalGuests < 1) $totalGuests = 1;
        if ($roomsRequested < 1) $roomsRequested = 1;

        // 2. Query accommodations (only LGU approved)
        $query = Accommodation::approved()
            ->with(['resort.barangay.municipality', 'amenities']);

        // Filter by Resort Location: Municipality
        if ($municipality) {
            $query->whereHas('resort.barangay.municipality', function ($q) use ($municipality) {
                $q->where('name', $municipality);
            });
        }

        // Filter by Resort Location: Barangay
        if ($barangay) {
            $query->whereHas('resort.barangay', function ($q) use ($barangay) {
                $q->where('name', $barangay);
            });
        }

        // Filter by Resort Category
        if ($category) {
            $query->whereHas('resort', function ($q) use ($category) {
                $q->where('category', $category);
            });
        }

        // Filter by Accommodation Type
        if ($type) {
            $query->where('type', $type);
        }

        // Filter by total units inventory (must have at least the requested number of rooms)
        $query->where('total_units', '>=', $roomsRequested);

        // Filter by Budget Range
        $query->whereBetween('price_per_night', [$minBudget, $maxBudget]);

        // Filter by Guest Capacity: max_guests per unit * rooms requested >= total guests
        $query->where(function ($q) use ($totalGuests, $roomsRequested) {
            $q->whereRaw('max_guests * ? >= ?', [$roomsRequested, $totalGuests]);
        });

        // Filter by Amenities (must match all selected)
        if (!empty($selectedAmenities)) {
            foreach ($selectedAmenities as $amenityName) {
                $query->whereHas('amenities', function ($q) use ($amenityName) {
                    $q->where('name', $amenityName);
                });
            }
        }

        // Fetch matches
        $accommodations = $query->get();

        // 3. Date Availability filter
        if ($checkIn && $checkOut) {
            try {
                $start = Carbon::parse($checkIn);
                $end = Carbon::parse($checkOut);

                if ($start->isValid() && $end->isValid() && $end->greaterThan($start)) {
                    $accommodations = $accommodations->filter(function ($accommodation) use ($start, $end, $roomsRequested) {
                        // Calculate total rooms booked overlapping this check-in/out range
                        $bookedRoomsCount = $accommodation->bookings()
                            ->where('status', 'confirmed')
                            ->where('check_in', '<', $end->toDateString())
                            ->where('check_out', '>', $start->toDateString())
                            ->sum('rooms_booked');

                        $availableUnits = $accommodation->total_units - $bookedRoomsCount;
                        if ($availableUnits < 0) $availableUnits = 0;

                        // Save available units as a dynamic property for output
                        $accommodation->available_units = $availableUnits;

                        // If available units are less than requested, filter out
                        return $availableUnits >= $roomsRequested;
                    });
                } else {
                    // Invalid date range, set default units
                    $accommodations->each(function ($acc) {
                        $acc->available_units = $acc->total_units;
                    });
                }
            } catch (\Exception $e) {
                // Ignore parse errors, set default units
                $accommodations->each(function ($acc) {
                    $acc->available_units = $acc->total_units;
                });
            }
        } else {
            // No date range requested, set default units
            $accommodations->each(function ($acc) {
                $acc->available_units = $acc->total_units;
            });
        }

        // Get all amenities for search filters sidebar
        $allAmenities = Amenity::all();

        return view('search.index', compact(
            'accommodations',
            'allAmenities',
            'municipality',
            'barangay',
            'checkIn',
            'checkOut',
            'adults',
            'children',
            'roomsRequested',
            'minBudget',
            'maxBudget',
            'category',
            'type',
            'selectedAmenities',
            'childAges'
        ));
    }
}

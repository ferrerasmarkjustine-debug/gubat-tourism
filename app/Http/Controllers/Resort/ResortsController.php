<?php

namespace App\Http\Controllers\Resort;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use Illuminate\View\View;
use Exception;

class ResortsController extends Controller
{
    /**
     * Display the full Resorts & Accommodations page.
     */
    public function index(): View
    {
        try {
            $resorts = Resort::with(['barangay', 'accommodations.amenities'])->get();

            if ($resorts->isEmpty()) {
                $resorts = $this->getFallbackResorts();
            }
        } catch (Exception $e) {
            $resorts = $this->getFallbackResorts();
        }

        return view('resorts.index', compact('resorts'));
    }

    private function getFallbackResorts()
    {
        return collect([
            (object)[
                'id'            => 1,
                'name'          => 'Gubat Bay Beach Resort',
                'description'   => 'Premium beach view rooms with swimming pool, seafood dining, and sunset lounge decks.',
                'rating'        => 4.9,
                'reviews_count' => 95,
                'category'      => 'luxury',
                'image_url'     => 'images/resorts/gubat_bay_beach_resort.jpg',
                'address'       => 'Pinontingan, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Bay+Beach+Resort+Sorsogon',
                'barangay'      => (object)['name' => 'Pinontingan'],
                'accommodations' => collect([
                    (object)['price_per_night' => 2500, 'max_guests' => 4, 'total_units' => 5,
                        'amenities' => collect([
                            (object)['name' => 'Free WiFi',      'icon_class' => 'bi-wifi'],
                            (object)['name' => 'Swimming Pool',  'icon_class' => 'bi-water'],
                            (object)['name' => 'Beachfront',     'icon_class' => 'bi-tsunami'],
                            (object)['name' => 'Restaurant',     'icon_class' => 'bi-egg-fried'],
                            (object)['name' => 'Free Parking',   'icon_class' => 'bi-p-circle'],
                        ])
                    ]
                ]),
            ],
            (object)[
                'id'            => 2,
                'name'          => 'Surfside Cottages & Homestay',
                'description'   => 'Authentic native nipa cottages next to the surf camp. Authentic island experience with ocean breezes.',
                'rating'        => 4.6,
                'reviews_count' => 112,
                'category'      => 'eco',
                'image_url'     => 'images/resorts/surfside_cottages.jpg',
                'address'       => 'Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'barangay'      => (object)['name' => 'Rizal'],
                'accommodations' => collect([
                    (object)['price_per_night' => 1200, 'max_guests' => 6, 'total_units' => 5,
                        'amenities' => collect([
                            (object)['name' => 'Free WiFi',      'icon_class' => 'bi-wifi'],
                            (object)['name' => 'Pet Friendly',   'icon_class' => 'bi-heart-pulse'],
                            (object)['name' => 'Kitchen',        'icon_class' => 'bi-fire'],
                            (object)['name' => 'Beachfront',     'icon_class' => 'bi-tsunami'],
                        ])
                    ]
                ]),
            ],
            (object)[
                'id'            => 3,
                'name'          => 'Pacific Breeze Eco Lodge',
                'description'   => 'Modern concrete-native fusion villas with private balconies facing the beach. Powered by solar.',
                'rating'        => 4.8,
                'reviews_count' => 45,
                'category'      => 'eco',
                'image_url'     => 'images/resorts/pacific_breeze_lodge.jpg',
                'address'       => 'Rizal Beach, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon',
                'barangay'      => (object)['name' => 'Rizal'],
                'accommodations' => collect([
                    (object)['price_per_night' => 3200, 'max_guests' => 3, 'total_units' => 7,
                        'amenities' => collect([
                            (object)['name' => 'Free WiFi',      'icon_class' => 'bi-wifi'],
                            (object)['name' => 'Air Conditioning','icon_class' => 'bi-wind'],
                            (object)['name' => 'Beachfront',     'icon_class' => 'bi-tsunami'],
                            (object)['name' => 'Hot Shower',     'icon_class' => 'bi-thermometer-half'],
                        ])
                    ]
                ]),
            ],
            (object)[
                'id'            => 4,
                'name'          => 'Buenavista Surf Cabin',
                'description'   => 'Cozy budget-friendly cabins perfect for solo travelers, backpackers and surf enthusiasts.',
                'rating'        => 4.5,
                'reviews_count' => 32,
                'category'      => 'budget',
                'image_url'     => 'images/resorts/buenavista_surf_cabin.jpg',
                'address'       => 'Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'barangay'      => (object)['name' => 'Rizal'],
                'accommodations' => collect([
                    (object)['price_per_night' => 600, 'max_guests' => 1, 'total_units' => 20,
                        'amenities' => collect([
                            (object)['name' => 'Free WiFi',      'icon_class' => 'bi-wifi'],
                            (object)['name' => 'Free Parking',   'icon_class' => 'bi-p-circle'],
                        ])
                    ]
                ]),
            ],
            (object)[
                'id'            => 5,
                'name'          => 'Sorsogon Sunset Villa',
                'description'   => 'An entire private villa featuring a fully equipped kitchen, private garden, and family-friendly amenities.',
                'rating'        => 4.7,
                'reviews_count' => 18,
                'category'      => 'homestay',
                'image_url'     => 'images/resorts/sorsogon_sunset_villa.jpg',
                'address'       => 'Ariman, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Ariman+Gubat+Sorsogon',
                'barangay'      => (object)['name' => 'Ariman'],
                'accommodations' => collect([
                    (object)['price_per_night' => 8500, 'max_guests' => 8, 'total_units' => 2,
                        'amenities' => collect([
                            (object)['name' => 'Free WiFi',      'icon_class' => 'bi-wifi'],
                            (object)['name' => 'Air Conditioning','icon_class' => 'bi-wind'],
                            (object)['name' => 'Kitchen',        'icon_class' => 'bi-fire'],
                            (object)['name' => 'Family Friendly','icon_class' => 'bi-people'],
                            (object)['name' => 'Pet Friendly',   'icon_class' => 'bi-heart-pulse'],
                        ])
                    ]
                ]),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Barangay;
use App\Models\Resort;
use App\Models\Amenity;
use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Testimonial;
use App\Models\WeatherTip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Users
        User::firstOrCreate(
            ['email' => 'admin@gubat.gov.ph'],
            [
                'name' => 'LGU Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'tourist',
                'is_active' => true,
            ]
        );

        // 2. Seed Province
        $province = Province::create(['name' => 'Sorsogon']);

        // 3. Seed Municipalities
        $municipalities = [
            'Gubat' => 1,
            'Bulusan' => 2,
            'Donsol' => 3,
            'Pilar' => 4,
            'Castilla' => 5,
            'Barcelona' => 6,
            'Irosin' => 7,
            'Bulan' => 8,
            'Matnog' => 9,
            'Juban' => 10,
            'Prieto Diaz' => 11,
            'Santa Magdalena' => 12,
            'Sorsogon City' => 13
        ];

        $municipalityModels = [];
        foreach ($municipalities as $name => $id) {
            $municipalityModels[$name] = Municipality::create([
                'id' => $id,
                'province_id' => $province->id,
                'name' => $name
            ]);
        }

        // 4. Seed Barangays (Gubat)
        $gubatBarangays = [
            'Rizal' => 1,
            'Pinontingan' => 2,
            'Panganiban' => 3,
            'Cota-na-daco' => 4,
            'Ariman' => 5,
            'Bulacao' => 6,
            'Tigkiw' => 7,
            'Paco' => 8
        ];

        $barangayModels = [];
        foreach ($gubatBarangays as $name => $id) {
            $barangayModels[$name] = Barangay::create([
                'id' => $id,
                'municipality_id' => 1, // Gubat
                'name' => $name
            ]);
        }

        // Bulusan Barangays
        Barangay::create(['id' => 9, 'municipality_id' => 2, 'name' => 'Dancalan']);
        Barangay::create(['id' => 10, 'municipality_id' => 2, 'name' => 'San Roque']);
        
        // Barcelona Barangays
        Barangay::create(['id' => 11, 'municipality_id' => 6, 'name' => 'Poblacion']);
        Barangay::create(['id' => 12, 'municipality_id' => 6, 'name' => 'Macalaya']);

        // 5. Seed Amenities
        $amenitiesData = [
            ['name' => 'Free WiFi', 'icon_class' => 'bi-wifi'],
            ['name' => 'Air Conditioning', 'icon_class' => 'bi-wind'],
            ['name' => 'Swimming Pool', 'icon_class' => 'bi-water'],
            ['name' => 'Beachfront', 'icon_class' => 'bi-tsunami'],
            ['name' => 'Pet Friendly', 'icon_class' => 'bi-heart-pulse'],
            ['name' => 'Free Parking', 'icon_class' => 'bi-p-circle'],
            ['name' => 'Restaurant', 'icon_class' => 'bi-egg-fried'],
            ['name' => 'Kitchen', 'icon_class' => 'bi-fire'],
            ['name' => 'Family Friendly', 'icon_class' => 'bi-people'],
            ['name' => 'Hot Shower', 'icon_class' => 'bi-thermometer-half'],
        ];

        $amenityModels = [];
        foreach ($amenitiesData as $amenity) {
            $amenityModels[$amenity['name']] = Amenity::create($amenity);
        }

        // 6. Seed Resorts in Gubat
        $resortsData = [
            [
                'id' => 1,
                'barangay_id' => 2, // Pinontingan
                'name' => 'Gubat Bay Beach Resort',
                'description' => 'Premium beach view rooms with swimming pool, seafood dining, and sunset lounge decks.',
                'address' => 'Pinontingan, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Bay+Beach+Resort+Sorsogon',
                'rating' => 4.90,
                'reviews_count' => 95,
                'category' => 'luxury',
                'image_url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80',
                'is_lgu_approved' => true,
                'featured' => true,
            ],
            [
                'id' => 2,
                'barangay_id' => 1, // Rizal
                'name' => 'Surfside Cottages & Homestay',
                'description' => 'Authentic native nipa cottages next to the surf camp. Authentic island experience with ocean breezes.',
                'address' => 'Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'rating' => 4.60,
                'reviews_count' => 112,
                'category' => 'eco',
                'image_url' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=600&q=80',
                'is_lgu_approved' => true,
                'featured' => true,
            ],
            [
                'id' => 3,
                'barangay_id' => 1, // Rizal
                'name' => 'Pacific Breeze Eco Lodge',
                'description' => 'Modern concrete-native fusion villas with private balconies facing the beach. Powered by solar.',
                'address' => 'Rizal Beach, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon',
                'rating' => 4.80,
                'reviews_count' => 45,
                'category' => 'eco',
                'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=600&q=80',
                'is_lgu_approved' => true,
                'featured' => true,
            ],
            [
                'id' => 4,
                'barangay_id' => 1, // Rizal
                'name' => 'Buenavista Surf Cabin',
                'description' => 'Cozy budget-friendly cabins perfect for solo travelers, backpackers and surf enthusiasts.',
                'address' => 'Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'rating' => 4.50,
                'reviews_count' => 32,
                'category' => 'budget',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
                'is_lgu_approved' => true,
                'featured' => false,
            ],
            [
                'id' => 5,
                'barangay_id' => 5, // Ariman
                'name' => 'Sorsogon Sunset Villa',
                'description' => 'An entire private villa featuring a fully equipped kitchen, private garden, and family-friendly amenities.',
                'address' => 'Ariman, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Ariman+Gubat+Sorsogon',
                'rating' => 4.70,
                'reviews_count' => 18,
                'category' => 'homestay',
                'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80',
                'is_lgu_approved' => true,
                'featured' => false,
            ]
        ];

        foreach ($resortsData as $resort) {
            Resort::create($resort);
        }

        // 7. Seed Accommodations (Rooms/Cottages/Units)
        $accommodationsData = [
            // Gubat Bay Beach Resort (ID: 1)
            [
                'id' => 1,
                'resort_id' => 1,
                'name' => 'Deluxe Ocean Suite',
                'type' => 'room',
                'price_per_night' => 3500.00,
                'max_guests' => 4,
                'total_units' => 5,
                'description' => 'Luxurious suite with ocean-facing balcony, premium bedding, and private hot shower.',
                'image_url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Air Conditioning', 'Swimming Pool', 'Free Parking', 'Restaurant', 'Hot Shower', 'Beachfront']
            ],
            [
                'id' => 2,
                'resort_id' => 1,
                'name' => 'Standard Twin Room',
                'type' => 'room',
                'price_per_night' => 2500.00,
                'max_guests' => 2,
                'total_units' => 10,
                'description' => 'Comfortable air-conditioned twin room with side garden view.',
                'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Air Conditioning', 'Swimming Pool', 'Free Parking', 'Restaurant']
            ],

            // Surfside Cottages & Homestay (ID: 2)
            [
                'id' => 3,
                'resort_id' => 2,
                'name' => 'Family Nipa Cottage',
                'type' => 'cottage',
                'price_per_night' => 1800.00,
                'max_guests' => 6,
                'total_units' => 5,
                'description' => 'Traditional fan-cooled cottage with high ceiling, beachfront patio and hammocks.',
                'image_url' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Pet Friendly', 'Free Parking', 'Kitchen', 'Family Friendly', 'Beachfront']
            ],
            [
                'id' => 4,
                'resort_id' => 2,
                'name' => 'Couple\'s Surf Cabin',
                'type' => 'cottage',
                'price_per_night' => 1200.00,
                'max_guests' => 2,
                'total_units' => 8,
                'description' => 'Compact native cottage perfect for couples, surfers, and solo travelers.',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Pet Friendly', 'Free Parking', 'Beachfront']
            ],

            // Pacific Breeze Eco Lodge (ID: 3)
            [
                'id' => 5,
                'resort_id' => 3,
                'name' => 'Eco Solar Villa',
                'type' => 'villa',
                'price_per_night' => 4500.00,
                'max_guests' => 4,
                'total_units' => 3,
                'description' => 'Solar-powered villa with kitchen, AC, and private balcony overlooking Rizal Beach.',
                'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Air Conditioning', 'Free Parking', 'Kitchen', 'Family Friendly', 'Hot Shower', 'Beachfront']
            ],
            [
                'id' => 6,
                'resort_id' => 3,
                'name' => 'Ocean View Loft',
                'type' => 'villa',
                'price_per_night' => 3200.00,
                'max_guests' => 3,
                'total_units' => 4,
                'description' => 'Cozy loft overlooking Rizal Beach surfing area, with high-speed WiFi and work setup.',
                'image_url' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Air Conditioning', 'Free Parking', 'Beachfront', 'Hot Shower']
            ],

            // Buenavista Surf Cabin (ID: 4)
            [
                'id' => 7,
                'resort_id' => 4,
                'name' => 'Dormitory Bed',
                'type' => 'dorm',
                'price_per_night' => 600.00,
                'max_guests' => 1,
                'total_units' => 20,
                'description' => 'Single bed in a shared 10-bed air-conditioned dorm room, perfect for backpackers.',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Air Conditioning', 'Free Parking']
            ],

            // Sorsogon Sunset Villa (ID: 5)
            [
                'id' => 8,
                'resort_id' => 5,
                'name' => 'Entire Countryside Villa',
                'type' => 'villa',
                'price_per_night' => 8500.00,
                'max_guests' => 8,
                'total_units' => 2,
                'description' => 'Perfect for families. Complete kitchen, private garden, parking, pet friendly, hot water.',
                'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80',
                'amenities' => ['Free WiFi', 'Air Conditioning', 'Free Parking', 'Kitchen', 'Family Friendly', 'Pet Friendly', 'Hot Shower']
            ]
        ];

        foreach ($accommodationsData as $accData) {
            $amenities = $accData['amenities'];
            unset($accData['amenities']);
            
            $accommodation = Accommodation::create($accData);
            
            // Link amenities
            foreach ($amenities as $amenityName) {
                if (isset($amenityModels[$amenityName])) {
                    $accommodation->amenities()->attach($amenityModels[$amenityName]->id);
                }
            }
        }

        // 8. Seed Bookings (to test availability filters)
        // Family Nipa Cottage (ID: 3) has 5 total units.
        // Let's book 3 units from July 10, 2026 to July 13, 2026 (Leaving 2 available units).
        Booking::create([
            'accommodation_id' => 3,
            'check_in' => '2026-07-10',
            'check_out' => '2026-07-13',
            'rooms_booked' => 3,
            'guests_count' => 6,
            'status' => 'confirmed'
        ]);

        // Let's book all 5 units of Family Nipa Cottage (ID: 3) from July 14, 2026 to July 18, 2026 (Leaving 0 units).
        Booking::create([
            'accommodation_id' => 3,
            'check_in' => '2026-07-14',
            'check_out' => '2026-07-18',
            'rooms_booked' => 5,
            'guests_count' => 12,
            'status' => 'confirmed'
        ]);

        // 9. Seed Tourist Destinations / Attractions
        $destinations = [
            [
                'municipality_id' => 1, // Gubat
                'name' => 'Lola Sayong Surf Camp',
                'description' => 'A community-run surfing paradise with cottages, boards, and certified instructors. Excellent for beginners and advanced surfers alike.',
                'category' => 'Surf Haven',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.70,
                'reviews_count' => 240,
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'municipality_id' => 1, // Gubat
                'name' => 'Rizal Beach',
                'description' => 'A wide, scenic sandy beach stretching along the Pacific Ocean, famous for picnic cottages, beach volleyball, and surfing.',
                'category' => 'Public Beach',
                'image_url' => 'https://images.unsplash.com/photo-1473186578172-c141e6798cf4?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.30,
                'reviews_count' => 180,
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'municipality_id' => 6, // Barcelona
                'name' => 'Barcelona Old Church',
                'description' => 'Built in 1874 by the Franciscans, this stone church features coral walls constructed using egg whites as a binding mortar.',
                'category' => 'Heritage Landmark',
                'image_url' => 'https://images.unsplash.com/photo-1590073844006-33379778ae09?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.90,
                'reviews_count' => 320,
                'google_map_url' => 'https://maps.google.com/?q=Barcelona+Church+Sorsogon',
                'featured' => true,
            ],
            [
                'municipality_id' => 1, // Gubat (Poblacion)
                'name' => 'St. Anthony of Padua Parish',
                'description' => 'Serving as the center of faith in Gubat since the early 1900s, this historic church features traditional Sorsoganon architectural elements.',
                'category' => 'Century-Old Church',
                'image_url' => 'https://images.unsplash.com/photo-1548625361-155deee223cb?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.80,
                'reviews_count' => 142,
                'google_map_url' => 'https://maps.google.com/?q=St+Anthony+of+Padua+Parish+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'municipality_id' => 1, // Gubat (Bulacao)
                'name' => 'Bulacao Abaca Weaving Association',
                'description' => 'Witness local artisans transform raw abaca fibers into world-class hand-woven mats, slippers, bags, and native tapestries.',
                'category' => 'Livelihood Center',
                'image_url' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.60,
                'reviews_count' => 54,
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Sorsogon+Abaca+Weavers',
                'featured' => false,
            ],
            [
                'municipality_id' => 1, // Gubat (Bentuco)
                'name' => 'Bentuco Clay Crafts',
                'description' => 'Learn traditional Bicol clay kneading and pottery wheels. Purchase terracotta cooking pots, planters, and customized garden brick decorations.',
                'category' => 'Traditional Pottery',
                'image_url' => 'https://images.unsplash.com/photo-1565192647048-f997ded879f0?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.50,
                'reviews_count' => 28,
                'google_map_url' => 'https://maps.google.com/?q=Bentuco+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'municipality_id' => 1, // Gubat (Poblacion)
                'name' => 'Gubat Heritage Ancestral Houses',
                'description' => 'Explore preserved Bahay na Bato structures featuring capiz shell windows, hardwood pillars, and Spanish era stone foundations.',
                'category' => 'Historical Heritage',
                'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.40,
                'reviews_count' => 38,
                'google_map_url' => 'https://maps.google.com/?q=Poblacion+Gubat+Sorsogon',
                'featured' => false,
            ]
        ];

        foreach ($destinations as $dest) {
            Destination::create($dest);
        }

        // 10. Seed Upcoming Events
        $events = [
            [
                'municipality_id' => 13, // Sorsogon City
                'title' => 'Kasanggayahan Festival',
                'description' => 'The premier province-wide festival of Sorsogon celebrating its foundation. Enjoy street dancing, local exhibitions, and agricultural fairs.',
                'event_date' => '2026-10-15',
                'location' => 'Sorsogon City Center',
                'image_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'municipality_id' => 1, // Gubat
                'title' => 'Gubat Surf Nationals',
                'description' => 'Witness the country\'s top surfers take on the wild Pacific swells of Rizal Beach. Includes live music, beach workshops, and local food stalls.',
                'event_date' => '2026-09-10',
                'location' => 'Rizal Beach Surfing Hub',
                'image_url' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'municipality_id' => 1, // Gubat
                'title' => 'St. Anthony Town Fiesta',
                'description' => 'Experience traditional Catholic religious processions, culinary heritage feasts, and vibrant local cultural dramas in the heart of Gubat.',
                'event_date' => '2026-06-13',
                'location' => 'Town Proper, Gubat',
                'image_url' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=600&q=80'
            ]
        ];

        foreach ($events as $evt) {
            Event::create($evt);
        }

        // 11. Seed LGU Announcements
        $announcements = [
            [
                'title' => 'LGU Launches Eco-Tourism Green Guidelines',
                'content' => 'The Municipal Government of Gubat has introduced new green certification guidelines for beachfront operators. This policy mandates solar energy alternatives, strict plastic bans, and responsible waste management protocols.',
                'category' => 'Eco Guidelines',
                'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80',
                'published_at' => Carbon::now()->subDays(2)
            ],
            [
                'title' => 'Kasanggayahan Surf Festival Registration Open',
                'content' => 'Registration is now officially open for the local Gubat division heats. Interested contestants can file their applications online or visit the Municipal Tourism Office in Gubat Municipal Hall.',
                'category' => 'Tourism Event',
                'image_url' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=600&q=80',
                'published_at' => Carbon::now()->subDays(5)
            ],
            [
                'title' => 'Rizal Beach Rehabilitation & Clean-up Drive',
                'content' => 'Join Gubat LGU and local surf associations this Saturday for the monthly beach clean-up and dune planting drive. Refreshments and planting kits will be provided for all volunteers.',
                'category' => 'Environment',
                'image_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=600&q=80',
                'published_at' => Carbon::now()->subDays(8)
            ]
        ];

        foreach ($announcements as $ann) {
            Announcement::create($ann);
        }

        // 12. Seed Testimonials
        $testimonials = [
            [
                'visitor_name' => 'Sarah Jenkins',
                'visitor_role' => 'Surfer & Blogger, Australia',
                'content' => 'Lola Sayong is absolutely incredible! The surfing instructors were very patient with me as a beginner. The reservation system was seamless and check-in with the QR Code was fast.',
                'rating' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80'
            ],
            [
                'visitor_name' => 'Mark Cruz',
                'visitor_role' => 'Family Traveler, Manila',
                'content' => 'Booking our family cottage at Gubat Bay Beach Resort was the highlight of our summer. Safe environment, beautiful swimming pool, and LGU-approved operations made us feel secure.',
                'rating' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80'
            ],
            [
                'visitor_name' => 'Elena Rostova',
                'visitor_role' => 'Solo Backpacker, Poland',
                'content' => 'The local heritage houses and Bulacao weaving center are hidden gems! Getting to see real-life crafts in Gubat while staying in an eco-lodge was a magical cultural experience.',
                'rating' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&h=150&q=80'
            ]
        ];

        foreach ($testimonials as $tst) {
            Testimonial::create($tst);
        }

        // 13. Seed Weather & Travel Tips
        $tips = [
            [
                'title' => 'Sun & Surf Advisory',
                'content' => 'Gubat is an active surfing hub facing the open Pacific. The prime surfing season spans from October to March, but moderate swells are available year-round. Check local tide calendars before entering deep breaks.',
                'icon_class' => 'bi-tsunami'
            ],
            [
                'title' => 'Local Weather Planning',
                'content' => 'Sorsogon exhibits a tropical climate with rainfall distributed throughout the year. Typhoons occasionally pass between September and December. Always verify warning advisories with Gubat LGU DRRMO alerts.',
                'icon_class' => 'bi-cloud-sun'
            ],
            [
                'title' => 'Getting Around Gubat',
                'content' => 'Standard tricycle fares operate on fixed regulatory bounds inside the town center. If you are traveling to beachfront areas like Rizal or Pinontingan, agree on a price beforehand or hire verified tourist tricycles.',
                'icon_class' => 'bi-bicycle'
            ]
        ];

        foreach ($tips as $tip) {
            WeatherTip::create($tip);
        }
    }
}

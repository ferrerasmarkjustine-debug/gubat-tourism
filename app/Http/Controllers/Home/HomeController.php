<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Resort;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Testimonial;
use App\Models\WeatherTip;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Exception;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        try {
            $featuredDestinations = Destination::where('featured', true)->with('municipality')->get();
            $featuredResorts = Resort::where('featured', true)->with('barangay')->get();
            $heritageSpots = Destination::where('featured', false)->with('municipality')->get();
            $events = Event::orderBy('event_date', 'asc')->with('municipality')->get();
            $announcements = Announcement::orderBy('published_at', 'desc')->take(3)->get();
            $testimonials = Testimonial::all();
            $weatherTips = WeatherTip::all();

            // If empty, fall back to static data to ensure robust operation
            if ($featuredDestinations->isEmpty()) {
                $featuredDestinations = $this->getFallbackDestinations();
            }
            if ($featuredResorts->isEmpty()) {
                $featuredResorts = $this->getFallbackResorts();
            }
            if ($heritageSpots->isEmpty()) {
                $heritageSpots = $this->getFallbackHeritage();
            }
            if ($events->isEmpty()) {
                $events = $this->getFallbackEvents();
            }
            if ($announcements->isEmpty()) {
                $announcements = $this->getFallbackAnnouncements();
            }
            if ($testimonials->isEmpty()) {
                $testimonials = $this->getFallbackTestimonials();
            }
            if ($weatherTips->isEmpty()) {
                $weatherTips = $this->getFallbackWeatherTips();
            }

        } catch (Exception $e) {
            // Severe fallback to prevent site failure
            $featuredDestinations = $this->getFallbackDestinations();
            $featuredResorts = $this->getFallbackResorts();
            $heritageSpots = $this->getFallbackHeritage();
            $events = $this->getFallbackEvents();
            $announcements = $this->getFallbackAnnouncements();
            $testimonials = $this->getFallbackTestimonials();
            $weatherTips = $this->getFallbackWeatherTips();
        }

        return view('home.index', compact(
            'featuredDestinations',
            'featuredResorts',
            'heritageSpots',
            'events',
            'announcements',
            'testimonials',
            'weatherTips'
        ));
    }

    private function getFallbackDestinations()
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'Lola Sayong Surf Camp',
                'description' => 'A community-run surfing paradise with cottages, boards, and certified instructors. Excellent for beginners and advanced surfers alike.',
                'category' => 'Surf Haven',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.7,
                'reviews_count' => 240,
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon',
                'municipality' => (object)['name' => 'Gubat'],
                'barangay' => (object)['name' => 'Rizal']
            ],
            (object)[
                'id' => 2,
                'name' => 'Rizal Beach',
                'description' => 'A wide, scenic sandy beach stretching along the Pacific Ocean, famous for picnic cottages, beach volleyball, and surfing.',
                'category' => 'Public Beach',
                'image_url' => 'https://images.unsplash.com/photo-1473186578172-c141e6798cf4?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.3,
                'reviews_count' => 180,
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'municipality' => (object)['name' => 'Gubat'],
                'barangay' => (object)['name' => 'Rizal']
            ],
            (object)[
                'id' => 3,
                'name' => 'Barcelona Old Church',
                'description' => 'Built in 1874 by the Franciscans, this stone church features coral walls constructed using egg whites as a binding mortar.',
                'category' => 'Heritage Landmark',
                'image_url' => 'https://images.unsplash.com/photo-1590073844006-33379778ae09?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.9,
                'reviews_count' => 320,
                'google_map_url' => 'https://maps.google.com/?q=Barcelona+Church+Sorsogon',
                'municipality' => (object)['name' => 'Barcelona'],
                'barangay' => (object)['name' => 'Poblacion']
            ]
        ]);
    }

    private function getFallbackResorts()
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'Gubat Bay Beach Resort',
                'description' => 'Premium beach view rooms with swimming pool, seafood dining, and sunset lounge decks.',
                'rating' => 4.9,
                'reviews_count' => 95,
                'category' => 'luxury',
                'image_url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80',
                'address' => 'Pinontingan, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Bay+Beach+Resort+Sorsogon',
                'barangay' => (object)['name' => 'Pinontingan'],
                'accommodations' => collect([
                    (object)['price_per_night' => 2500, 'max_guests' => 4]
                ])
            ],
            (object)[
                'id' => 2,
                'name' => 'Surfside Cottages & Homestay',
                'description' => 'Authentic native nipa cottages next to the surf camp. Authentic island experience with ocean breezes.',
                'rating' => 4.6,
                'reviews_count' => 112,
                'category' => 'eco',
                'image_url' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=600&q=80',
                'address' => 'Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'barangay' => (object)['name' => 'Rizal'],
                'accommodations' => collect([
                    (object)['price_per_night' => 1200, 'max_guests' => 6]
                ])
            ],
            (object)[
                'id' => 3,
                'name' => 'Pacific Breeze Eco Lodge',
                'description' => 'Modern concrete-native fusion villas with private balconies facing the beach. Powered by solar.',
                'rating' => 4.8,
                'reviews_count' => 45,
                'category' => 'eco',
                'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=600&q=80',
                'address' => 'Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon',
                'barangay' => (object)['name' => 'Rizal'],
                'accommodations' => collect([
                    (object)['price_per_night' => 3200, 'max_guests' => 3]
                ])
            ]
        ]);
    }

    private function getFallbackHeritage()
    {
        return collect([
            (object)[
                'id' => 4,
                'name' => 'St. Anthony of Padua Parish',
                'description' => 'Serving as the center of faith in Gubat since the early 1900s, this historic church features traditional Sorsoganon architectural elements.',
                'category' => 'Century-Old Church',
                'image_url' => 'https://images.unsplash.com/photo-1548625361-155deee223cb?auto=format&fit=crop&w=600&q=80',
                'google_map_url' => 'https://maps.google.com/?q=St+Anthony+of+Padua+Parish+Gubat+Sorsogon',
                'municipality' => (object)['name' => 'Gubat'],
                'barangay' => (object)['name' => 'Cota-na-daco'],
                'barangay_name' => 'Cota-na-daco'
            ],
            (object)[
                'id' => 5,
                'name' => 'Bulacao Abaca Weaving Association',
                'description' => 'Witness local artisans transform raw abaca fibers into world-class hand-woven mats, slippers, bags, and native tapestries.',
                'category' => 'Livelihood Center',
                'image_url' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=600&q=80',
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Sorsogon+Abaca+Weavers',
                'municipality' => (object)['name' => 'Gubat'],
                'barangay' => (object)['name' => 'Bulacao'],
                'barangay_name' => 'Bulacao'
            ],
            (object)[
                'id' => 6,
                'name' => 'Bentuco Clay Crafts',
                'description' => 'Learn traditional Bicol clay kneading and pottery wheels. Purchase terracotta cooking pots, planters, and customized garden brick decorations.',
                'category' => 'Traditional Pottery',
                'image_url' => 'https://images.unsplash.com/photo-1565192647048-f997ded879f0?auto=format&fit=crop&w=600&q=80',
                'google_map_url' => 'https://maps.google.com/?q=Bentuco+Gubat+Sorsogon',
                'municipality' => (object)['name' => 'Gubat'],
                'barangay' => (object)['name' => 'Bentuco'],
                'barangay_name' => 'Bentuco'
            ],
            (object)[
                'id' => 7,
                'name' => 'Gubat Heritage Ancestral Houses',
                'description' => 'Explore preserved Bahay na Bato structures featuring capiz shell windows, hardwood pillars, and Spanish era stone foundations.',
                'category' => 'Historical Heritage',
                'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80',
                'google_map_url' => 'https://maps.google.com/?q=Poblacion+Gubat+Sorsogon',
                'municipality' => (object)['name' => 'Gubat'],
                'barangay' => (object)['name' => 'Poblacion'],
                'barangay_name' => 'Poblacion'
            ]
        ]);
    }

    private function getFallbackEvents()
    {
        return collect([
            (object)[
                'title' => 'Kasanggayahan Festival',
                'description' => 'The premier province-wide festival of Sorsogon celebrating its foundation. Enjoy street dancing, local exhibitions, and agricultural fairs.',
                'event_date' => Carbon::create(2026, 10, 15),
                'location' => 'Sorsogon City Center',
                'image_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=600&q=80'
            ],
            (object)[
                'title' => 'Gubat Surf Nationals',
                'description' => 'Witness the country\'s top surfers take on the wild Pacific swells of Rizal Beach. Includes live music, beach workshops, and local food stalls.',
                'event_date' => Carbon::create(2026, 9, 10),
                'location' => 'Rizal Beach Surfing Hub',
                'image_url' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=600&q=80'
            ],
            (object)[
                'title' => 'St. Anthony Town Fiesta',
                'description' => 'Experience traditional Catholic religious processions, culinary heritage feasts, and vibrant local cultural dramas in the heart of Gubat.',
                'event_date' => Carbon::create(2026, 6, 13),
                'location' => 'Town Proper, Gubat',
                'image_url' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=600&q=80'
            ]
        ]);
    }

    private function getFallbackAnnouncements()
    {
        return collect([
            (object)[
                'title' => 'LGU Launches Eco-Tourism Green Guidelines',
                'content' => 'The Municipal Government of Gubat has introduced new green certification guidelines for beachfront operators. This policy mandates solar energy alternatives, strict plastic bans, and responsible waste management protocols.',
                'category' => 'Eco Guidelines',
                'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80',
                'published_at' => Carbon::now()->subDays(2)
            ],
            (object)[
                'title' => 'Kasanggayahan Surf Festival Registration Open',
                'content' => 'Registration is now officially open for the local Gubat division heats. Interested contestants can file their applications online or visit the Municipal Tourism Office in Gubat Municipal Hall.',
                'category' => 'Tourism Event',
                'image_url' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=600&q=80',
                'published_at' => Carbon::now()->subDays(5)
            ],
            (object)[
                'title' => 'Rizal Beach Rehabilitation & Clean-up Drive',
                'content' => 'Join Gubat LGU and local surf associations this Saturday for the monthly beach clean-up and dune planting drive. Refreshments and planting kits will be provided for all volunteers.',
                'category' => 'Environment',
                'image_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=600&q=80',
                'published_at' => Carbon::now()->subDays(8)
            ]
        ]);
    }

    private function getFallbackTestimonials()
    {
        return collect([
            (object)[
                'visitor_name' => 'Sarah Jenkins',
                'visitor_role' => 'Surfer & Blogger, Australia',
                'content' => 'Lola Sayong is absolutely incredible! The surfing instructors were very patient with me as a beginner. The reservation system was seamless and check-in with the QR Code was fast.',
                'rating' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80'
            ],
            (object)[
                'visitor_name' => 'Mark Cruz',
                'visitor_role' => 'Family Traveler, Manila',
                'content' => 'Booking our family cottage at Gubat Bay Beach Resort was the highlight of our summer. Safe environment, beautiful swimming pool, and LGU-approved operations made us feel secure.',
                'rating' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80'
            ],
            (object)[
                'visitor_name' => 'Elena Rostova',
                'visitor_role' => 'Solo Backpacker, Poland',
                'content' => 'The local heritage houses and Bulacao weaving center are hidden gems! Getting to see real-life crafts in Gubat while staying in an eco-lodge was a magical cultural experience.',
                'rating' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&h=150&q=80'
            ]
        ]);
    }

    private function getFallbackWeatherTips()
    {
        return collect([
            (object)[
                'title' => 'Sun & Surf Advisory',
                'content' => 'Gubat is an active surfing hub facing the open Pacific. The prime surfing season spans from October to March, but moderate swells are available year-round. Check local tide calendars before entering deep breaks.',
                'icon_class' => 'bi-tsunami'
            ],
            (object)[
                'title' => 'Local Weather Planning',
                'content' => 'Sorsogon exhibits a tropical climate with rainfall distributed throughout the year. Typhoons occasionally pass between September and December. Always verify warning advisories with Gubat LGU DRRMO alerts.',
                'icon_class' => 'bi-cloud-sun'
            ],
            (object)[
                'title' => 'Getting Around Gubat',
                'content' => 'Standard tricycle fares operate on fixed regulatory bounds inside the town center. If you are traveling to beachfront areas like Rizal or Pinontingan, agree on a price beforehand or hire verified tourist tricycles.',
                'icon_class' => 'bi-bicycle'
            ]
        ]);
    }
}

<?php

namespace App\Http\Controllers\Destination;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\View\View;
use Exception;

class DestinationsController extends Controller
{
    /**
     * Display the full Destinations & Attractions page.
     */
    public function index(): View
    {
        try {
            $featuredDestinations = Destination::where('featured', true)->with('municipality')->get();
            $heritageSpots        = Destination::where('featured', false)->with('municipality')->get();

            if ($featuredDestinations->isEmpty()) {
                $featuredDestinations = $this->getFallbackDestinations();
            }
            if ($heritageSpots->isEmpty()) {
                $heritageSpots = $this->getFallbackHeritage();
            }
        } catch (Exception $e) {
            $featuredDestinations = $this->getFallbackDestinations();
            $heritageSpots        = $this->getFallbackHeritage();
        }

        return view('destinations.index', compact('featuredDestinations', 'heritageSpots'));
    }

    private function getFallbackDestinations()
    {
        return collect([
            (object)[
                'id'            => 1,
                'name'          => 'Lola Sayong Surf Camp',
                'description'   => 'A community-run surfing paradise with cottages, boards, and certified instructors. Excellent for beginners and advanced surfers alike.',
                'category'      => 'Surf Haven',
                'image_url'     => 'images/destinations/lola_sayong_surf_camp.jpg',
                'rating'        => 4.7,
                'reviews_count' => 240,
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon',
                'municipality'  => (object)['name' => 'Gubat'],
                'barangay'      => (object)['name' => 'Rizal'],
            ],
            (object)[
                'id'            => 2,
                'name'          => 'Rizal Beach',
                'description'   => 'A wide, scenic sandy beach stretching along the Pacific Ocean, famous for picnic cottages, beach volleyball, and surfing.',
                'category'      => 'Public Beach',
                'image_url'     => 'images/destinations/rizal_beach.jpg',
                'rating'        => 4.3,
                'reviews_count' => 180,
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'municipality'  => (object)['name' => 'Gubat'],
                'barangay'      => (object)['name' => 'Rizal'],
            ],
            (object)[
                'id'            => 3,
                'name'          => 'Barcelona Old Church',
                'description'   => 'Built in 1874 by the Franciscans, this stone church features coral walls constructed using egg whites as a binding mortar.',
                'category'      => 'Heritage Landmark',
                'image_url'     => 'images/destinations/barcelona_old_church.jpg',
                'rating'        => 4.9,
                'reviews_count' => 320,
                'google_map_url' => 'https://maps.google.com/?q=Barcelona+Church+Sorsogon',
                'municipality'  => (object)['name' => 'Barcelona'],
                'barangay'      => (object)['name' => 'Poblacion'],
            ],
        ]);
    }

    private function getFallbackHeritage()
    {
        return collect([
            (object)[
                'id'            => 4,
                'name'          => 'St. Anthony of Padua Parish',
                'description'   => 'Serving as the center of faith in Gubat since the early 1900s, this historic church features traditional Sorsoganon architectural elements.',
                'category'      => 'Century-Old Church',
                'image_url'     => 'images/destinations/st_anthony_parish.jpg',
                'google_map_url' => 'https://maps.google.com/?q=St+Anthony+of+Padua+Parish+Gubat+Sorsogon',
                'municipality'  => (object)['name' => 'Gubat'],
                'barangay'      => (object)['name' => 'Cota-na-daco'],
                'barangay_name' => 'Cota-na-daco'
            ],
            (object)[
                'id'            => 5,
                'name'          => 'Bulacao Abaca Weaving Association',
                'description'   => 'Witness local artisans transform raw abaca fibers into world-class hand-woven mats, slippers, bags, and native tapestries.',
                'category'      => 'Livelihood Center',
                'image_url'     => 'images/destinations/bulacao_abaca_weaving.jpg',
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Sorsogon+Abaca+Weavers',
                'municipality'  => (object)['name' => 'Gubat'],
                'barangay'      => (object)['name' => 'Bulacao'],
                'barangay_name' => 'Bulacao'
            ],
            (object)[
                'id'            => 6,
                'name'          => 'Bentuco Clay Crafts',
                'description'   => 'Learn traditional Bicol clay kneading and pottery wheels. Purchase terracotta cooking pots, planters, and customized garden brick decorations.',
                'category'      => 'Traditional Pottery',
                'image_url'     => 'images/destinations/bentuco_clay_crafts.jpg',
                'google_map_url' => 'https://maps.google.com/?q=Bentuco+Gubat+Sorsogon',
                'municipality'  => (object)['name' => 'Gubat'],
                'barangay'      => (object)['name' => 'Bentuco'],
                'barangay_name' => 'Bentuco'
            ],
            (object)[
                'id'            => 7,
                'name'          => 'Gubat Heritage Ancestral Houses',
                'description'   => 'Explore preserved Bahay na Bato structures featuring capiz shell windows, hardwood pillars, and Spanish era stone foundations.',
                'category'      => 'Historical Heritage',
                'image_url'     => 'images/destinations/gubat_heritage_houses.jpg',
                'google_map_url' => 'https://maps.google.com/?q=Poblacion+Gubat+Sorsogon',
                'municipality'  => (object)['name' => 'Gubat'],
                'barangay'      => (object)['name' => 'Poblacion'],
                'barangay_name' => 'Poblacion'
            ],
        ]);
    }
}

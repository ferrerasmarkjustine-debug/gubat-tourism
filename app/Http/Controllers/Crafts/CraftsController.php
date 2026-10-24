<?php

namespace App\Http\Controllers\Crafts;

use App\Http\Controllers\Controller;
use App\Models\Craft;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Exception;

class CraftsController extends Controller
{
    /**
     * Display the full Livelihood & Crafts page.
     */
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category', 'all');

        try {
            $query = Craft::query();
            if ($selectedCategory && $selectedCategory !== 'all') {
                $query->where('category_slug', strtolower($selectedCategory));
            }
            $crafts = $query->orderBy('id', 'desc')->get();

            // If database table is empty, fall back to default collection
            if ($crafts->isEmpty() && Craft::count() === 0) {
                $allCrafts = $this->getCraftsData();
                if ($selectedCategory && $selectedCategory !== 'all') {
                    $crafts = $allCrafts->filter(function ($item) use ($selectedCategory) {
                        return strtolower($item->category_slug) === strtolower($selectedCategory);
                    });
                } else {
                    $crafts = $allCrafts;
                }
            }
        } catch (Exception $e) {
            $allCrafts = $this->getCraftsData();
            if ($selectedCategory && $selectedCategory !== 'all') {
                $crafts = $allCrafts->filter(function ($item) use ($selectedCategory) {
                    return strtolower($item->category_slug) === strtolower($selectedCategory);
                });
            } else {
                $crafts = $allCrafts;
            }
        }

        $categories = [
            'all' => 'All Crafts & Livelihood',
            'abaca' => 'Abaca Weaving',
            'pottery' => 'Clay Pottery',
            'culinary' => 'Native Delicacies',
            'souvenirs' => 'Eco-Wood & Souvenirs'
        ];

        return view('crafts.index', compact('crafts', 'categories', 'selectedCategory'));
    }

    private function getCraftsData()
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'Bulacao Abaca Weaving Association',
                'category_slug' => 'abaca',
                'category_name' => 'Abaca Weaving',
                'description' => 'A proud community cooperative of master women weavers turning resilient Manila hemp fibers into world-renowned decorative placemats, native slippers, eco-bags, and intricate sinamay tapestries.',
                'highlight' => '100% Sustainable & Handcrafted',
                'products' => ['Abaca Beach Bags', 'Handwoven Table Runners', 'Native Slippers', 'Sinamay Fabrics'],
                'image_url' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=600&q=80',
                'address' => 'Brgy. Bulacao, Gubat, Sorsogon',
                'barangay' => 'Bulacao',
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Sorsogon+Abaca+Weavers',
                'contact' => '+63 917 555 4231',
                'badge_color' => '#8D6E63'
            ],
            (object)[
                'id' => 2,
                'name' => 'Bentuco Traditional Clay Crafts & Pottery',
                'category_slug' => 'pottery',
                'category_name' => 'Clay Pottery',
                'description' => 'Generations-old terracotta pottery artisans utilizing traditional manual pottery wheels and local clay pits. Famous for durable clay cooking pots (palayok), gardening planters, and custom landscape brick art.',
                'highlight' => 'Ancient Bicol Kneading Heritage',
                'products' => ['Palayok (Clay Cooking Pots)', 'Ornate Garden Planters', 'Terracotta Charcoal Stoves', 'Decorative Brick Accents'],
                'image_url' => 'https://images.unsplash.com/photo-1565192647048-f997ded879f0?auto=format&fit=crop&w=600&q=80',
                'address' => 'Brgy. Bentuco, Gubat, Sorsogon',
                'barangay' => 'Bentuco',
                'google_map_url' => 'https://maps.google.com/?q=Bentuco+Gubat+Sorsogon',
                'contact' => '+63 928 444 8912',
                'badge_color' => '#d97706'
            ],
            (object)[
                'id' => 3,
                'name' => 'Gubat Pili & Coconut Confectionery Artisans',
                'category_slug' => 'culinary',
                'category_name' => 'Native Delicacies',
                'description' => 'Homegrown cooperative specializing in hand-roasted Sorsogon pili nuts, crispy honey-glazed pili, melt-in-your-mouth mazapan, sweet molido, and pure organic coconut blossom sugar syrup.',
                'highlight' => 'Authentic Local Farm Flavors',
                'products' => ['Crispy Glazed Pili', 'Mazapan de Pili', 'Molido', 'Coco-Sugar Treats'],
                'image_url' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?auto=format&fit=crop&w=600&q=80',
                'address' => 'Poblacion, Gubat, Sorsogon',
                'barangay' => 'Poblacion',
                'google_map_url' => 'https://maps.google.com/?q=Poblacion+Gubat+Sorsogon',
                'contact' => '+63 919 333 1289',
                'badge_color' => '#198754'
            ],
            (object)[
                'id' => 4,
                'name' => 'Rizal Coastal Driftwood & Bamboo Crafts',
                'category_slug' => 'souvenirs',
                'category_name' => 'Eco-Wood & Souvenirs',
                'description' => 'Local coastal artisans and surf sculptors who repurpose reclaimed driftwood and local bamboo into hand-carved miniature surfboards, coastal wall hangings, wind chimes, and natural souvenirs.',
                'highlight' => 'Ocean Recycled Artistry',
                'products' => ['Driftwood Surf Sculptures', 'Bamboo Wind Chimes', 'Shell Keychains', 'Coastal Keepsakes'],
                'image_url' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=600&q=80',
                'address' => 'Rizal Beach Surfing Strip, Gubat, Sorsogon',
                'barangay' => 'Rizal',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'contact' => '+63 945 777 6210',
                'badge_color' => '#0284c7'
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\Barangay;
use App\Models\Resort;
use App\Models\Amenity;
use App\Models\Accommodation;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class GubatDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds for Gubat Tourist Spots Directory using extracted docx images.
     */
    public function run(): void
    {
        $gubat = Municipality::firstOrCreate(
            ['name' => 'Gubat'],
            ['province_id' => 1]
        );

        // 1. Ensure all relevant Gubat Barangays exist
        $barangayNames = [
            'Rizal',
            'Pinontingan',
            'Panganiban',
            'Cota-na-daco',
            'Ariman',
            'Bulacao',
            'Tigkiw',
            'Paco',
            'Buenavista',
            'Bagacay',
            'Cogon',
            'Cogon-San Ignacio',
            'Nazareno',
            'Villareal',
            'Luna-Candol',
            'Poblacion',
        ];

        $barangays = [];
        foreach ($barangayNames as $bName) {
            $barangays[$bName] = Barangay::firstOrCreate(
                ['municipality_id' => $gubat->id, 'name' => $bName]
            );
        }

        // 2. Ensure standard amenities exist
        $amenityData = [
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

        $amenities = [];
        foreach ($amenityData as $am) {
            $amenities[$am['name']] = Amenity::firstOrCreate(
                ['name' => $am['name']],
                ['icon_class' => $am['icon_class']]
            );
        }

        // 3. Seed / Update Destinations from the Directory with actual docx extracted photos
        $destinations = [
            [
                'name' => 'Buenavista Tourism Hub and Beach',
                'description' => 'Gateway with a palm-lined baywalk promenade, local food stalls, and fine cream-to-powdery sand along the Pacific coast. Savor fresh coastal seafood like alimango and kuracha (spanner crab), alongside traditional Bicolano delicacies such as hinagom and timitim.',
                'category' => 'Public Beach & Promenade',
                'image_url' => 'images/destinations/buenavista_tourism_hub.jpg',
                'rating' => 4.85,
                'reviews_count' => 310,
                'google_map_url' => 'https://maps.google.com/?q=Buenavista+Beach+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'Lola Sayong Eco-Surfarm',
                'description' => 'Founded in 2014 on a historic coconut estate, this community-led eco-surf camp champions sustainable surf tourism, beginner coaching, and youth empowerment through its inspiring "No School, No Surf" scholarship program alongside circular organic farming.',
                'category' => 'Surf Haven & Eco-Farm',
                'image_url' => 'images/destinations/lola_sayong_eco_surfarm.jpg',
                'rating' => 4.90,
                'reviews_count' => 420,
                'google_map_url' => 'https://maps.google.com/?q=Lola+Sayong+Eco+Surfarm+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'Agoho Forest Reserve',
                'description' => 'A towering "coastal cathedral" of native agoho pine trees reaching up to 20 meters tall. Set directly along the shoreline with gentle waves, picnic cottages, footbridges, and scenic hanging bridges where forest meets the sea.',
                'category' => 'Nature & Forest Reserve',
                'image_url' => 'images/destinations/agoho_forest_reserve.jpg',
                'rating' => 4.80,
                'reviews_count' => 195,
                'google_map_url' => 'https://maps.google.com/?q=Agoho+Forest+Ariman+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'Tulay sa Tibo',
                'description' => 'A picturesque mangrove and estuary footbridge pathway connecting local coastal settlements. Celebrated by photographers and nature lovers for bird watching, scenic waterscape views, and relaxing strolls.',
                'category' => 'Ecotourism & Boardwalk',
                'image_url' => 'images/destinations/tulay_sa_tibo.jpg',
                'rating' => 4.70,
                'reviews_count' => 125,
                'google_map_url' => 'https://maps.google.com/?q=Tulay+sa+Tibo+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'Liyang Cave & Spring',
                'description' => 'A mystical limestone cavern featuring striking turquoise spring waters and cherished folklore (kuwentong-bayan). Featured on Kapuso Mo, Jessica Soho (KMJS), it stands as a protected natural wonder of local legend.',
                'category' => 'Mystic Cave & Spring',
                'image_url' => 'images/destinations/liyang_cave.jpg',
                'rating' => 4.65,
                'reviews_count' => 160,
                'google_map_url' => 'https://maps.google.com/?q=Liyang+Cave+Nazareno+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Avelina\'s Farm',
                'description' => 'A serene countryside farm retreat along the Gubat–Prieto Diaz Road in Barangay Cogon. Experience unhurried provincial living, tilapia fishponds, day camping, and authentic farm-to-table dining surrounded by lush tropical greenery.',
                'category' => 'Agri-Tourism & Retreat',
                'image_url' => 'images/destinations/avelinas_farm.jpg',
                'rating' => 4.75,
                'reviews_count' => 92,
                'google_map_url' => 'https://maps.google.com/?q=Avelinas+Farm+Cogon+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Gubat Municipal Park',
                'description' => 'The vibrant civic heart and central recreational square of Gubat Poblacion. Shaded by heritage trees, with monuments, picnic benches, and festive spaces for community celebrations and cultural gatherings.',
                'category' => 'Town Park & Landmark',
                'image_url' => 'images/destinations/gubat_municipal_park.jpg',
                'rating' => 4.50,
                'reviews_count' => 140,
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Municipal+Park+Poblacion+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Gubat Boulevard',
                'description' => 'A scenic waterfront seawall promenade in Barangay Panganiban. The premier spot for catching panoramic Pacific horizons, cool evening breezes, seaside photography, and experiencing laid-back local life.',
                'category' => 'Waterfront Promenade',
                'image_url' => 'images/destinations/gubat_boulevard.jpg',
                'rating' => 4.60,
                'reviews_count' => 175,
                'google_map_url' => 'https://maps.google.com/?q=Gubat+Boulevard+Panganiban+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Angel Surf',
                'description' => 'A dedicated wave-riding haven in Purok 2, Buenavista. Famous for consistent Pacific swells, friendly surf coaching, and pristine beach views, offering an exhilarating challenge for extreme sports enthusiasts.',
                'category' => 'Surf Break',
                'image_url' => 'images/destinations/angel_surf.jpg',
                'rating' => 4.70,
                'reviews_count' => 85,
                'google_map_url' => 'https://maps.google.com/?q=Angel+Surf+Buenavista+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Kendi\'s Beach Garden',
                'description' => 'A peaceful coastal garden sanctuary along the Gubat–Barcelona Road in Buenavista. Features landscaped tropical flora, seaside gazebos, and fresh ocean vistas suited for tranquil family get-togethers.',
                'category' => 'Beach Garden & Leisure',
                'image_url' => 'images/destinations/kendis_beach_garden.jpg',
                'rating' => 4.55,
                'reviews_count' => 64,
                'google_map_url' => 'https://maps.google.com/?q=Kendis+Beach+Garden+Buenavista+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Rizal Beach',
                'description' => 'A wide, scenic sandy beach stretching along the Pacific Ocean, famous for picnic cottages, beach volleyball, and surfing. Rich in local heritage from its 19th-century origins as historic Malobago.',
                'category' => 'Public Beach',
                'image_url' => 'images/destinations/rizal_beach.jpg',
                'rating' => 4.70,
                'reviews_count' => 280,
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'St. Anthony of Padua Parish Church',
                'description' => 'Established by Franciscan missionaries in 1731, this historic parish stands as the spiritual cradle of Gubat. Preserves watchtower defense history against Moro raids, 1814 Mayon eruption relocation, and one of Bicol\'s oldest rectory buildings.',
                'category' => 'Century-Old Church',
                'image_url' => 'images/destinations/st_anthony_parish.jpg',
                'rating' => 4.90,
                'reviews_count' => 220,
                'google_map_url' => 'https://maps.google.com/?q=St+Anthony+of+Padua+Parish+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'St. Augustine Parish Church',
                'description' => 'Rooted in the Augustinian missions of 1569 under Fray Alonso Jimenez. Dedicated in 2014 in Barangay Cogon–San Ignacio, this parish serves 15 chapels across eastern Gubat and stands as a thriving pillar of faith and community welfare.',
                'category' => 'Historic Parish',
                'image_url' => 'images/destinations/st_augustine_parish.jpg',
                'rating' => 4.80,
                'reviews_count' => 110,
                'google_map_url' => 'https://maps.google.com/?q=St+Augustine+Parish+Cogon+Gubat+Sorsogon',
                'featured' => false,
            ],
            [
                'name' => 'Villareal Grotto & Hilltop Shrine',
                'description' => 'A cherished hillside pilgrimage sanctuary built in 1989 with 80 to 200 steps ascending to a peaceful grotto. Re-inaugurated in 2025 with blooming Roselle gardens, it serves as an official station of the Camino de Gracia faith walk.',
                'category' => 'Pilgrimage & Viewpoint',
                'image_url' => 'images/destinations/villareal_grotto.jpg',
                'rating' => 4.85,
                'reviews_count' => 150,
                'google_map_url' => 'https://maps.google.com/?q=Villareal+Grotto+Gubat+Sorsogon',
                'featured' => true,
            ],
            [
                'name' => 'Christ the King Shrine',
                'description' => 'A revered Christian monument in Gubat manifesting the profound religious devotion of the townspeople. A central prayer milestone included in regional spiritual trails and heritage itineraries.',
                'category' => 'Religious Landmark',
                'image_url' => 'images/destinations/christ_the_king.jpg',
                'rating' => 4.70,
                'reviews_count' => 88,
                'google_map_url' => 'https://maps.google.com/?q=Christ+the+King+Gubat+Sorsogon',
                'featured' => false,
            ],
        ];

        foreach ($destinations as $d) {
            Destination::updateOrCreate(
                ['name' => $d['name'], 'municipality_id' => $gubat->id],
                $d
            );
        }

        // 4. Seed / Update Real Beach Resorts & Hotels with actual docx extracted photos
        $resorts = [
            [
                'name' => 'Rizal Beach Resort Hotel',
                'barangay' => 'Rizal',
                'description' => 'Iconic beachfront hotel along a sweeping cove facing the San Bernardino Strait. Features spacious guest rooms, apartelle suites, a swimming pool, dining restaurant, function halls, and beachfront day cottages.',
                'address' => 'Barangay Rizal, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Rizal+Beach+Resort+Hotel+Gubat+Sorsogon',
                'rating' => 4.80,
                'reviews_count' => 185,
                'category' => 'luxury',
                'image_url' => 'images/resorts/rizal_beach_resort_hotel.jpg',
                'is_lgu_approved' => true,
                'featured' => true,
                'accommodations' => [
                    [
                        'name' => 'Family Apartelle Suite',
                        'type' => 'villa',
                        'price_per_night' => 3800.00,
                        'max_guests' => 6,
                        'total_units' => 6,
                        'description' => 'Spacious multi-bedroom apartelle with full living area, air conditioning, hot shower, and private oceanview terrace.',
                        'image_url' => 'images/accommodations/rizal_apartelle_suite.jpg',
                        'amenities' => ['Free WiFi', 'Air Conditioning', 'Swimming Pool', 'Beachfront', 'Hot Shower', 'Free Parking']
                    ],
                    [
                        'name' => 'Deluxe Ocean View Room',
                        'type' => 'room',
                        'price_per_night' => 2400.00,
                        'max_guests' => 3,
                        'total_units' => 12,
                        'description' => 'Air-conditioned double room with direct view of the Pacific waves, cable TV, and private bath.',
                        'image_url' => 'images/accommodations/rizal_ocean_room.jpg',
                        'amenities' => ['Free WiFi', 'Air Conditioning', 'Swimming Pool', 'Beachfront', 'Hot Shower', 'Restaurant']
                    ],
                    [
                        'name' => 'Beachside Day Picnic Cottage',
                        'type' => 'cottage',
                        'price_per_night' => 800.00,
                        'max_guests' => 10,
                        'total_units' => 20,
                        'description' => 'Covered wooden beach cottage right by the sand, perfect for day outings, picnics, and family gatherings.',
                        'image_url' => 'images/destinations/rizal_beach.jpg',
                        'amenities' => ['Beachfront', 'Family Friendly', 'Free Parking']
                    ]
                ]
            ],
            [
                'name' => 'Sea-Clusion Beach Resort',
                'barangay' => 'Bagacay',
                'description' => 'A rustic coastal sanctuary with native bamboo and nipa A-frame cottages set among coconut palms and stone walkways. Features fan and AC cabins, access to swimming pool areas, and budget-friendly day and overnight stays.',
                'address' => 'Purok 0, Bagacay, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Sea-Clusion+Beach+Resort+Bagacay+Gubat+Sorsogon',
                'rating' => 4.75,
                'reviews_count' => 96,
                'category' => 'eco',
                'image_url' => 'images/resorts/sea_clusion_beach_resort.jpg',
                'is_lgu_approved' => true,
                'featured' => true,
                'accommodations' => [
                    [
                        'name' => 'Deluxe A-Frame AC Cabin',
                        'type' => 'cottage',
                        'price_per_night' => 2200.00,
                        'max_guests' => 4,
                        'total_units' => 5,
                        'description' => 'Charming bamboo A-frame cabin with air conditioning, queen bed, balcony, and swimming pool access.',
                        'image_url' => 'images/accommodations/sea_clusion_a_frame.jpg',
                        'amenities' => ['Free WiFi', 'Air Conditioning', 'Swimming Pool', 'Beachfront', 'Pet Friendly']
                    ],
                    [
                        'name' => 'Native Fan Bamboo Hut',
                        'type' => 'cottage',
                        'price_per_night' => 1100.00,
                        'max_guests' => 2,
                        'total_units' => 8,
                        'description' => 'Cozy budget eco-hut with cool sea breeze ventilation, private hammock, and garden courtyard.',
                        'image_url' => 'images/accommodations/sea_clusion_bamboo_hut.jpg',
                        'amenities' => ['Free WiFi', 'Pet Friendly', 'Free Parking', 'Beachfront']
                    ]
                ]
            ],
            [
                'name' => 'Pipa de Playa',
                'barangay' => 'Buenavista',
                'description' => 'A premier beachfront restobar where casual elegance meets the rhythm of the ocean. Blends organic bamboo architecture, rattan furniture, and warm string lights for enchanting golden-hour sunsets and coastal dinners.',
                'address' => 'Buenavista Shoreline, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Pipa+de+Playa+Buenavista+Gubat+Sorsogon',
                'rating' => 4.90,
                'reviews_count' => 165,
                'category' => 'luxury',
                'image_url' => 'images/resorts/pipa_de_playa.jpg',
                'is_lgu_approved' => true,
                'featured' => true,
                'accommodations' => [
                    [
                        'name' => 'Sunset Shoreline Dining Pavilion',
                        'type' => 'cottage',
                        'price_per_night' => 1500.00,
                        'max_guests' => 8,
                        'total_units' => 6,
                        'description' => 'Open-air private lounge gazebo right on the sand with dedicated waitstaff service, sunset cocktails, and seaside ambiance.',
                        'image_url' => 'images/accommodations/pipa_sunset_pavilion.jpg',
                        'amenities' => ['Free WiFi', 'Restaurant', 'Beachfront', 'Free Parking']
                    ]
                ]
            ],
            [
                'name' => 'Casa Adelai',
                'barangay' => 'Buenavista',
                'description' => 'A cozy private oceanfront A-frame cabin combining rustic tropical charm with modern living. Features direct beach frontage, panoramic Pacific sunrise views, a fully equipped kitchen, and a pet-friendly atmosphere.',
                'address' => 'Purok Uno, Buenavista, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Casa+Adelai+Buenavista+Gubat+Sorsogon',
                'rating' => 4.85,
                'reviews_count' => 54,
                'category' => 'homestay',
                'image_url' => 'images/resorts/casa_adelai.jpg',
                'is_lgu_approved' => true,
                'featured' => true,
                'accommodations' => [
                    [
                        'name' => 'Entire Oceanfront A-Frame House',
                        'type' => 'villa',
                        'price_per_night' => 4200.00,
                        'max_guests' => 6,
                        'total_units' => 2,
                        'description' => 'Complete oceanfront cabin with master loft, full kitchen, private patio, outdoor shower, and direct beach access.',
                        'image_url' => 'images/accommodations/casa_adelai_interior.jpg',
                        'amenities' => ['Free WiFi', 'Air Conditioning', 'Kitchen', 'Pet Friendly', 'Beachfront', 'Hot Shower', 'Free Parking']
                    ]
                ]
            ],
            [
                'name' => 'Coco-Pili Farm Resort',
                'barangay' => 'Bagacay',
                'description' => 'A vibrant agri-relaxation and family getaway opened in 2026. Known for its refreshing swimming pools, private picnic cabanas, lush coconut and pili tree groves, and lively community pool events.',
                'address' => 'Purok 1, Bagacay Junction, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Coco-Pili+Farm+Resort+Bagacay+Gubat+Sorsogon',
                'rating' => 4.80,
                'reviews_count' => 78,
                'category' => 'eco',
                'image_url' => 'images/resorts/coco_pili_farm_resort.jpg',
                'is_lgu_approved' => true,
                'featured' => true,
                'accommodations' => [
                    [
                        'name' => 'Poolside Family Villa',
                        'type' => 'villa',
                        'price_per_night' => 2900.00,
                        'max_guests' => 6,
                        'total_units' => 4,
                        'description' => 'Modern air-conditioned villa stepping out onto the sparkling resort pool, surrounded by pili trees.',
                        'image_url' => 'images/accommodations/coco_pili_villa.jpg',
                        'amenities' => ['Free WiFi', 'Air Conditioning', 'Swimming Pool', 'Family Friendly', 'Free Parking']
                    ],
                    [
                        'name' => 'Agri-Day Cabana with Pool Access',
                        'type' => 'cottage',
                        'price_per_night' => 1200.00,
                        'max_guests' => 8,
                        'total_units' => 10,
                        'description' => 'Shaded native cabana with pool wristbands for day visitors, grilling station, and open lawn access.',
                        'image_url' => 'images/resorts/coco_pili_farm_resort.jpg',
                        'amenities' => ['Swimming Pool', 'Family Friendly', 'Free Parking']
                    ]
                ]
            ],
            [
                'name' => 'Baia Nest Nature Hotel',
                'barangay' => 'Buenavista',
                'description' => 'A boutique design hotel harmonizing natural woods with a captivating waterfall feature. Tailored for travelers seeking tranquility, scenic greenery, and restful moments away from daily hustle.',
                'address' => 'Buenavista, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=Baia+Nest+Buenavista+Gubat+Sorsogon',
                'rating' => 4.82,
                'reviews_count' => 46,
                'category' => 'eco',
                'image_url' => 'images/resorts/baia_nest.jpg',
                'is_lgu_approved' => true,
                'featured' => true,
                'accommodations' => [
                    [
                        'name' => 'Waterfall View Nature Suite',
                        'type' => 'room',
                        'price_per_night' => 3600.00,
                        'max_guests' => 3,
                        'total_units' => 6,
                        'description' => 'Immersive nature suite with private veranda facing the landscaped waterfall, premium king bed, and acoustic design.',
                        'image_url' => 'images/accommodations/baia_nest_suite.jpg',
                        'amenities' => ['Free WiFi', 'Air Conditioning', 'Hot Shower', 'Free Parking', 'Restaurant']
                    ]
                ]
            ],
            [
                'name' => 'RESHAUS Community Homestay',
                'barangay' => 'Buenavista',
                'description' => 'A community-based homestay initiative along the Ariman–Gubat junction. Offers travelers authentic connection with warm local residents, cultural exchange, and comfortable, budget-friendly rooms.',
                'address' => 'Ariman–Gubat Junction, Abuyog Road, Buenavista, Gubat, Sorsogon',
                'google_map_url' => 'https://maps.google.com/?q=RESHAUS+Buenavista+Gubat+Sorsogon',
                'rating' => 4.70,
                'reviews_count' => 35,
                'category' => 'homestay',
                'image_url' => 'images/resorts/reshaus.jpg',
                'is_lgu_approved' => true,
                'featured' => false,
                'accommodations' => [
                    [
                        'name' => 'Community Guest Room',
                        'type' => 'room',
                        'price_per_night' => 900.00,
                        'max_guests' => 2,
                        'total_units' => 4,
                        'description' => 'Clean, welcoming guest bedroom inside a local family residence with shared kitchen privileges and local tour tips.',
                        'image_url' => 'images/accommodations/reshaus_room.jpg',
                        'amenities' => ['Free WiFi', 'Kitchen', 'Pet Friendly', 'Free Parking']
                    ]
                ]
            ],
        ];

        foreach ($resorts as $rData) {
            $bModel = $barangays[$rData['barangay']] ?? $barangays['Buenavista'];
            $accList = $rData['accommodations'] ?? [];
            unset($rData['barangay'], $rData['accommodations']);

            $rData['barangay_id'] = $bModel->id;

            $resort = Resort::updateOrCreate(
                ['name' => $rData['name']],
                $rData
            );

            foreach ($accList as $acc) {
                $amenityNames = $acc['amenities'] ?? [];
                unset($acc['amenities']);
                $acc['resort_id'] = $resort->id;
                $acc['status'] = 'approved';

                $accommodation = Accommodation::updateOrCreate(
                    ['resort_id' => $resort->id, 'name' => $acc['name']],
                    $acc
                );

                // Attach amenities
                $amenityIds = [];
                foreach ($amenityNames as $anName) {
                    if (isset($amenities[$anName])) {
                        $amenityIds[] = $amenities[$anName]->id;
                    }
                }
                if (!empty($amenityIds)) {
                    $accommodation->amenities()->sync($amenityIds);
                }
            }
        }
    }
}

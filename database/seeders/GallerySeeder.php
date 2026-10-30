<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $b = Destination::where('name', 'like', '%Buenavista%')->first();
        if ($b) {
            $b->image_url = 'images/destinations/buenavista_tourism_hub.jpg';
            $b->gallery_images = [
                'images/destinations/buenavista_tourism_hub.jpg',
                'images/destinations/buenavista_baywalk_sunset.jpg',
                'images/destinations/rizal_beach_sunset.jpg',
            ];
            $b->save();
        }

        $a = Destination::where('name', 'like', '%Agoho%')->first();
        if ($a) {
            $a->image_url = 'images/destinations/agoho_forest_reserve.jpg';
            $a->gallery_images = [
                'images/destinations/agoho_forest_reserve.jpg',
                'images/destinations/agoho_canopy_walk.jpg',
                'images/destinations/liyang_cave.jpg',
            ];
            $a->save();
        }

        $ls = Destination::where('name', 'like', '%Lola Sayong%')->first();
        if ($ls) {
            $ls->gallery_images = [
                'images/destinations/lola_sayong_surf_camp.jpg',
                'images/destinations/lola_sayong_eco_surfarm.jpg',
                'images/destinations/angel_surf.jpg',
            ];
            $ls->save();
        }

        $rb = Destination::where('name', 'like', '%Rizal Beach%')->first();
        if ($rb) {
            $rb->gallery_images = [
                'images/destinations/rizal_beach.jpg',
                'images/destinations/rizal_beach_sunset.jpg',
                'images/destinations/kendis_beach_garden.jpg',
            ];
            $rb->save();
        }

        // Seed Craft Galleries
        $craftAbaca = \App\Models\Craft::where('category_slug', 'abaca')->first();
        if ($craftAbaca) {
            $craftAbaca->gallery_images = [
                'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1606744837616-56c9a5c6a6eb?auto=format&fit=crop&w=800&q=80',
            ];
            $craftAbaca->save();
        }

        $craftPottery = \App\Models\Craft::where('category_slug', 'pottery')->first();
        if ($craftPottery) {
            $craftPottery->gallery_images = [
                'https://images.unsplash.com/photo-1565192647048-f997ded879f0?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1531747056595-07f6cbbe10ad?auto=format&fit=crop&w=800&q=80',
            ];
            $craftPottery->save();
        }

        $craftCulinary = \App\Models\Craft::where('category_slug', 'culinary')->first();
        if ($craftCulinary) {
            $craftCulinary->gallery_images = [
                'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1587132137056-bfbf0166836e?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=800&q=80',
            ];
            $craftCulinary->save();
        }

        $craftSouvenirs = \App\Models\Craft::where('category_slug', 'souvenirs')->first();
        if ($craftSouvenirs) {
            $craftSouvenirs->gallery_images = [
                'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1582562124811-c09040d0a901?auto=format&fit=crop&w=800&q=80',
            ];
            $craftSouvenirs->save();
        }

        // Seed Resort Galleries
        $resort1 = \App\Models\Resort::find(1);
        if ($resort1) {
            $resort1->gallery_images = [
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
            ];
            $resort1->save();
        }

        $resort2 = \App\Models\Resort::find(2);
        if ($resort2) {
            $resort2->gallery_images = [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=80',
            ];
            $resort2->save();
        }

        $resort3 = \App\Models\Resort::find(3);
        if ($resort3) {
            $resort3->gallery_images = [
                'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=800&q=80',
            ];
            $resort3->save();
        }

        $resort4 = \App\Models\Resort::find(4);
        if ($resort4) {
            $resort4->gallery_images = [
                'https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80',
            ];
            $resort4->save();
        }

        $resort5 = \App\Models\Resort::find(5);
        if ($resort5) {
            $resort5->gallery_images = [
                'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
            ];
            $resort5->save();
        }
    }
}

<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Announcement;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Exception;

class EventsController extends Controller
{
    /**
     * Display the full Events & Festivals page.
     */
    public function index(): View
    {
        try {
            $events        = Event::orderBy('event_date', 'asc')->with('municipality')->get();
            $announcements = Announcement::orderBy('published_at', 'desc')->get();

            if ($events->isEmpty()) {
                $events = $this->getFallbackEvents();
            }
            if ($announcements->isEmpty()) {
                $announcements = $this->getFallbackAnnouncements();
            }
        } catch (Exception $e) {
            $events        = $this->getFallbackEvents();
            $announcements = $this->getFallbackAnnouncements();
        }

        return view('events.index', compact('events', 'announcements'));
    }

    private function getFallbackEvents()
    {
        return collect([
            (object)[
                'title'       => 'Kasanggayahan Festival',
                'description' => 'The premier province-wide festival of Sorsogon celebrating its foundation. Enjoy street dancing, local exhibitions, and agricultural fairs.',
                'event_date'  => Carbon::create(2026, 10, 15),
                'location'    => 'Sorsogon City Center',
                'image_url'   => 'images/events/kasanggayahan_festival.jpg',
            ],
            (object)[
                'title'       => 'Gubat Surf Nationals',
                'description' => 'Witness the country\'s top surfers take on the wild Pacific swells of Rizal Beach. Includes live music, beach workshops, and local food stalls.',
                'event_date'  => Carbon::create(2026, 9, 10),
                'location'    => 'Rizal Beach Surfing Hub',
                'image_url'   => 'images/events/gubat_surf_nationals.jpg',
            ],
            (object)[
                'title'       => 'St. Anthony Town Fiesta',
                'description' => 'Experience traditional Catholic religious processions, culinary heritage feasts, and vibrant local cultural dramas in the heart of Gubat.',
                'event_date'  => Carbon::create(2026, 6, 13),
                'location'    => 'Town Proper, Gubat',
                'image_url'   => 'images/events/st_anthony_town_fiesta.jpg',
            ],
        ]);
    }

    private function getFallbackAnnouncements()
    {
        return collect([
            (object)[
                'title'        => 'LGU Launches Eco-Tourism Green Guidelines',
                'content'      => 'The Municipal Government of Gubat has introduced new green certification guidelines for beachfront operators. This policy mandates solar energy alternatives, strict plastic bans, and responsible waste management protocols.',
                'category'     => 'Eco Guidelines',
                'image_url'    => 'images/announcements/eco_tourism_green_guidelines.jpg',
                'published_at' => Carbon::now()->subDays(2),
            ],
            (object)[
                'title'        => 'Kasanggayahan Surf Festival Registration Open',
                'content'      => 'Registration is now officially open for the local Gubat division heats. Interested contestants can file their applications online or visit the Municipal Tourism Office in Gubat Municipal Hall.',
                'category'     => 'Tourism Event',
                'image_url'    => 'images/announcements/surf_festival_registration.jpg',
                'published_at' => Carbon::now()->subDays(5),
            ],
            (object)[
                'title'        => 'Rizal Beach Rehabilitation & Clean-up Drive',
                'content'      => 'Join Gubat LGU and local surf associations this Saturday for the monthly beach clean-up and dune planting drive. Refreshments and planting kits will be provided for all volunteers.',
                'category'     => 'Environment',
                'image_url'    => 'images/announcements/rizal_beach_cleanup.jpg',
                'published_at' => Carbon::now()->subDays(8),
            ],
        ]);
    }
}

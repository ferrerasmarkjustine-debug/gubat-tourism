<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\User;
use App\Models\Destination;
use App\Models\Craft;
use App\Models\Event;
use App\Models\Accommodation;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the LGU Admin Dashboard.
     */
    public function index(): View
    {
        $totalResorts = Resort::count();
        $totalResortAdmins = User::where('role', 'resort_admin')->count();
        $activeResortAdmins = User::where('role', 'resort_admin')->where('is_active', true)->count();
        $inactiveResortAdmins = $totalResortAdmins - $activeResortAdmins;

        $recentAdmins = User::where('role', 'resort_admin')
            ->with('resort')
            ->latest()
            ->take(5)
            ->get();

        $resortsWithoutAdmin = Resort::doesntHave('admins')->count();

        return view('super-admin.dashboard', compact(
            'totalResorts',
            'totalResortAdmins',
            'activeResortAdmins',
            'inactiveResortAdmins',
            'recentAdmins',
            'resortsWithoutAdmin'
        ));
    }

    /**
     * Global Universal Search across all LGU portal entities.
     */
    public function globalSearch(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));

        if (mb_strlen($q) < 1) {
            return response()->json([
                'resorts' => [],
                'destinations' => [],
                'crafts' => [],
                'events' => [],
                'accommodations' => [],
                'admins' => [],
                'reservations' => [],
                'total' => 0,
            ]);
        }

        // 1. Resorts
        $resorts = Resort::with('barangay')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('address', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%")
                      ->orWhereHas('barangay', function ($b) use ($q) {
                          $b->where('name', 'like', "%{$q}%");
                      });
            })
            ->limit(5)
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'title' => $r->name,
                    'subtitle' => ($r->barangay ? $r->barangay->name . ' • ' : '') . ucfirst($r->category),
                    'image' => $r->image_url,
                    'badge' => $r->is_lgu_approved ? 'Accredited' : 'Pending',
                    'badge_class' => $r->is_lgu_approved ? 'bg-success' : 'bg-warning text-dark',
                    'url' => route('admin.resorts'),
                ];
            });

        // 2. Destinations
        $destinations = Destination::where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($d) {
                return [
                    'id' => $d->id,
                    'title' => $d->name,
                    'subtitle' => $d->category . ' • ' . ($d->barangay_name ?? 'Gubat'),
                    'image' => $d->image_url,
                    'badge' => $d->featured ? 'Featured' : null,
                    'badge_class' => 'bg-primary',
                    'url' => route('admin.destinations'),
                ];
            });

        // 3. Crafts & Livelihood
        $crafts = Craft::where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('category_name', 'like', "%{$q}%")
                      ->orWhere('barangay', 'like', "%{$q}%")
                      ->orWhere('address', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'title' => $c->name,
                    'subtitle' => $c->category_name . ' • Brgy. ' . ($c->barangay ?? 'Gubat'),
                    'image' => $c->image_url,
                    'badge' => $c->is_featured ? 'Featured' : null,
                    'badge_class' => 'bg-info text-dark',
                    'url' => route('admin.crafts.index'),
                ];
            });

        // 4. Events & Announcements
        $events = Event::where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('location', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'title' => $e->title,
                    'subtitle' => ($e->event_date ? $e->event_date->format('M d, Y') . ' • ' : '') . $e->location,
                    'image' => $e->image_url,
                    'badge' => 'Event',
                    'badge_class' => 'bg-primary',
                    'url' => route('admin.events.index'),
                ];
            });

        // 5. Accommodations (Approvals)
        $accommodations = Accommodation::with('resort')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('type', 'like', "%{$q}%")
                      ->orWhereHas('resort', function ($r) use ($q) {
                          $r->where('name', 'like', "%{$q}%");
                      });
            })
            ->limit(5)
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'title' => $a->name,
                    'subtitle' => ($a->resort ? $a->resort->name . ' • ' : '') . ucfirst($a->type) . ' (₱' . number_format($a->price_per_night, 2) . ')',
                    'image' => $a->image_url,
                    'badge' => ucfirst($a->status),
                    'badge_class' => ($a->status === 'approved') ? 'bg-success' : (($a->status === 'rejected') ? 'bg-danger' : 'bg-warning text-dark'),
                    'url' => route('admin.accommodations.index', ['status' => $a->status ?? 'all']),
                ];
            });

        // 6. Resort Admins
        $admins = User::where('role', 'resort_admin')
            ->with('resort')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('phone_number', 'like', "%{$q}%")
                      ->orWhereHas('resort', function ($r) use ($q) {
                          $r->where('name', 'like', "%{$q}%");
                      });
            })
            ->limit(5)
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'title' => $u->name,
                    'subtitle' => $u->email . ($u->resort ? ' • ' . $u->resort->name : ' • No assigned resort'),
                    'image' => null,
                    'badge' => $u->is_active ? 'Active' : 'Inactive',
                    'badge_class' => $u->is_active ? 'bg-success' : 'bg-danger',
                    'url' => route('admin.resort-admins.edit', $u->id),
                ];
            });

        // 7. Reservations
        $cleanRef = ltrim(trim($q, '#'), '0');
        $reservations = Booking::with(['accommodation.resort'])
            ->where(function ($query) use ($q, $cleanRef) {
                if (!empty($cleanRef) && is_numeric($cleanRef)) {
                    $query->orWhere('id', (int)$cleanRef);
                }
                $query->orWhere('guest_name', 'like', "%{$q}%")
                      ->orWhere('guest_email', 'like', "%{$q}%")
                      ->orWhereHas('accommodation', function ($acc) use ($q) {
                          $acc->where('name', 'like', "%{$q}%")
                              ->orWhereHas('resort', function ($resort) use ($q) {
                                  $resort->where('name', 'like', "%{$q}%");
                              });
                      });
            })
            ->limit(5)
            ->get()
            ->map(function ($b) {
                $ref = '#' . str_pad($b->id, 5, '0', STR_PAD_LEFT);
                $resortName = $b->accommodation && $b->accommodation->resort ? $b->accommodation->resort->name : 'N/A';
                return [
                    'id' => $b->id,
                    'title' => $ref . ' — ' . ($b->guest_name ?? 'Guest'),
                    'subtitle' => $resortName . ($b->accommodation ? ' (' . $b->accommodation->name . ')' : ''),
                    'image' => null,
                    'badge' => ucfirst($b->status ?? 'pending'),
                    'badge_class' => ($b->status === 'confirmed') ? 'bg-success' : (($b->status === 'cancelled') ? 'bg-danger' : 'bg-warning text-dark'),
                    'url' => route('admin.reservations'),
                ];
            });

        $total = count($resorts) + count($destinations) + count($crafts) + count($events) + count($accommodations) + count($admins) + count($reservations);

        return response()->json([
            'resorts' => $resorts,
            'destinations' => $destinations,
            'crafts' => $crafts,
            'events' => $events,
            'accommodations' => $accommodations,
            'admins' => $admins,
            'reservations' => $reservations,
            'total' => $total,
        ]);
    }
}

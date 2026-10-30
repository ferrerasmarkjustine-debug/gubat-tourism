<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Resort\ResortsController;
use App\Http\Controllers\Destination\DestinationsController;
use App\Http\Controllers\Events\EventsController;
use App\Http\Controllers\Crafts\CraftsController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/resorts', [ResortsController::class, 'index'])->name('resorts');

Route::get('/destinations', [DestinationsController::class, 'index'])->name('destinations');

Route::get('/crafts', [CraftsController::class, 'index'])->name('crafts');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/events', [EventsController::class, 'index'])->name('events');

Route::view('/about', 'about.index')->name('about');

// Booking routes
use App\Http\Controllers\Resort\BookingController;
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}/success', [BookingController::class, 'success'])->name('booking.success');



use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ResortAdminController;
use App\Http\Controllers\SuperAdmin\ResortController as SuperAdminResortController;
use App\Http\Controllers\SuperAdmin\DestinationController as SuperAdminDestinationController;
use App\Http\Controllers\SuperAdmin\EventController as SuperAdminEventController;
use App\Http\Controllers\SuperAdmin\CraftController as SuperAdminCraftController;
use App\Http\Controllers\SuperAdmin\ReservationController as SuperAdminReservationController;
use App\Http\Controllers\SuperAdmin\AccommodationApprovalController;
use App\Http\Controllers\ResortAdmin\DashboardController as ResortAdminDashboardController;
use App\Http\Controllers\ResortAdmin\BookingsController as ResortAdminBookingsController;
use App\Http\Controllers\ResortAdmin\AccommodationController as ResortAdminAccommodationController;

/*
|--------------------------------------------------------------------------
| Resort Admin (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'resort_admin'])->prefix('resort-admin')->name('resort.')->group(function () {
    Route::get('/dashboard', [ResortAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [ResortAdminBookingsController::class, 'index'])->name('bookings');
    Route::get('/accommodations', [ResortAdminAccommodationController::class, 'index'])->name('accommodations.index');
    Route::get('/accommodations/create', [ResortAdminAccommodationController::class, 'create'])->name('accommodations.create');
    Route::post('/accommodations', [ResortAdminAccommodationController::class, 'store'])->name('accommodations.store');
    Route::get('/accommodations/{accommodation}/edit', [ResortAdminAccommodationController::class, 'edit'])->name('accommodations.edit');
    Route::put('/accommodations/{accommodation}', [ResortAdminAccommodationController::class, 'update'])->name('accommodations.update');
    Route::post('/phone-number', [ResortAdminDashboardController::class, 'updatePhone'])->name('phone.update');
});


/*
|--------------------------------------------------------------------------
| LGU Admin (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Resorts Management
    Route::get('/resorts', [SuperAdminResortController::class, 'index'])->name('resorts');
    Route::get('/resorts/create', [SuperAdminResortController::class, 'create'])->name('resorts.create');
    Route::post('/resorts', [SuperAdminResortController::class, 'store'])->name('resorts.store');
    Route::put('/resorts/{resort}', [SuperAdminResortController::class, 'update'])->name('resorts.update');
    Route::delete('/resorts/{resort}', [SuperAdminResortController::class, 'destroy'])->name('resorts.destroy');

    // Accommodations Approval Workflow
    Route::get('/accommodations', [AccommodationApprovalController::class, 'index'])->name('accommodations.index');
    Route::post('/accommodations/{accommodation}/approve', [AccommodationApprovalController::class, 'approve'])->name('accommodations.approve');
    Route::post('/accommodations/{accommodation}/reject', [AccommodationApprovalController::class, 'reject'])->name('accommodations.reject');

    // Destinations management
    Route::get('/destinations', [SuperAdminDestinationController::class, 'index'])->name('destinations');
    Route::post('/destinations', [SuperAdminDestinationController::class, 'store'])->name('destinations.store');
    Route::put('/destinations/{destination}', [SuperAdminDestinationController::class, 'update'])->name('destinations.update');
    Route::delete('/destinations/{destination}', [SuperAdminDestinationController::class, 'destroy'])->name('destinations.destroy');
    Route::patch('/destinations/{destination}/toggle-featured', [SuperAdminDestinationController::class, 'toggleFeatured'])->name('destinations.toggle-featured');

    // Reservations overview
    Route::get('/reservations', [SuperAdminReservationController::class, 'index'])->name('reservations');

    // Events & Announcements Management
    Route::get('/events', [SuperAdminEventController::class, 'index'])->name('events.index');
    Route::post('/events', [SuperAdminEventController::class, 'storeEvent'])->name('events.store');
    Route::put('/events/{event}', [SuperAdminEventController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{event}', [SuperAdminEventController::class, 'destroyEvent'])->name('events.destroy');

    Route::post('/announcements', [SuperAdminEventController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [SuperAdminEventController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [SuperAdminEventController::class, 'destroyAnnouncement'])->name('announcements.destroy');

    // Crafts & Livelihood Management
    Route::get('/crafts', [SuperAdminCraftController::class, 'index'])->name('crafts.index');
    Route::post('/crafts', [SuperAdminCraftController::class, 'store'])->name('crafts.store');
    Route::put('/crafts/{craft}', [SuperAdminCraftController::class, 'update'])->name('crafts.update');
    Route::delete('/crafts/{craft}', [SuperAdminCraftController::class, 'destroy'])->name('crafts.destroy');
    Route::patch('/crafts/{craft}/toggle-featured', [SuperAdminCraftController::class, 'toggleFeatured'])->name('crafts.toggle-featured');

    // Resort Admin Management
    Route::get('/resort-admins', [ResortAdminController::class, 'index'])->name('resort-admins.index');
    Route::get('/resort-admins/create', [ResortAdminController::class, 'create'])->name('resort-admins.create');
    Route::post('/resort-admins', [ResortAdminController::class, 'store'])->name('resort-admins.store');
    Route::get('/resort-admins/{user}/edit', [ResortAdminController::class, 'edit'])->name('resort-admins.edit');
    Route::put('/resort-admins/{user}', [ResortAdminController::class, 'update'])->name('resort-admins.update');
    Route::patch('/resort-admins/{user}/toggle-status', [ResortAdminController::class, 'toggleStatus'])->name('resort-admins.toggle-status');
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Resort\ResortsController;
use App\Http\Controllers\Destination\DestinationsController;
use App\Http\Controllers\Events\EventsController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/resorts', [ResortsController::class, 'index'])->name('resorts');

Route::get('/destinations', [DestinationsController::class, 'index'])->name('destinations');

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
use App\Http\Controllers\SuperAdmin\ReservationController as SuperAdminReservationController;
use App\Http\Controllers\ResortAdmin\DashboardController as ResortAdminDashboardController;
use App\Http\Controllers\ResortAdmin\BookingsController as ResortAdminBookingsController;

/*
|--------------------------------------------------------------------------
| Resort Admin (Protected)
|--------------------------------------------------------------------------
*/



Route::middleware(['auth', 'resort_admin'])->prefix('resort-admin')->name('resort.')->group(function () {
    Route::get('/dashboard', [ResortAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [ResortAdminBookingsController::class, 'index'])->name('bookings');
    Route::get('/accommodations/create', function () {
        return view('resort-admin.coming-soon');
    })->name('accommodations.create');
});


/*
|--------------------------------------------------------------------------
| LGU Admin (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Resorts overview
    Route::get('/resorts', [SuperAdminResortController::class, 'index'])->name('resorts');

    // Destinations overview
    Route::get('/destinations', [SuperAdminDestinationController::class, 'index'])->name('destinations');

    // Reservations overview
    Route::get('/reservations', [SuperAdminReservationController::class, 'index'])->name('reservations');

    // Resort Admin Management
    Route::get('/resort-admins', [ResortAdminController::class, 'index'])->name('resort-admins.index');
    Route::get('/resort-admins/create', [ResortAdminController::class, 'create'])->name('resort-admins.create');
    Route::post('/resort-admins', [ResortAdminController::class, 'store'])->name('resort-admins.store');
    Route::get('/resort-admins/{user}/edit', [ResortAdminController::class, 'edit'])->name('resort-admins.edit');
    Route::put('/resort-admins/{user}', [ResortAdminController::class, 'update'])->name('resort-admins.update');
    Route::patch('/resort-admins/{user}/toggle-status', [ResortAdminController::class, 'toggleStatus'])->name('resort-admins.toggle-status');
});

require __DIR__.'/auth.php';
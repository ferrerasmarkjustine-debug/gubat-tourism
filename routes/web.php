<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::view('/', 'home.index')->name('home');

Route::view('/resorts', 'resorts.index')->name('resorts');

Route::view('/destinations', 'destinations.index')->name('destinations');

Route::view('/search', 'search.index')->name('search');

Route::view('/events', 'events.index')->name('events');

Route::view('/about', 'about.index')->name('about');


/*
|--------------------------------------------------------------------------
| Resort Admin
|--------------------------------------------------------------------------
*/

Route::view('/resort-admin/dashboard', 'resort-admin.dashboard')
    ->name('resort.dashboard');


/*
|--------------------------------------------------------------------------
| LGU Super Admin
|--------------------------------------------------------------------------
*/

Route::view('/super-admin/dashboard', 'super-admin.dashboard')
    ->name('admin.dashboard');

require __DIR__.'/auth.php';
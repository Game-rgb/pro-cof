<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

// homepage → dashboard
Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('home');

// dashboard route for breeze redirect
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// must be logged in
Route::middleware('auth')->group(function () {

    // sales → both admin and cashier
    Route::resource('sales', SaleController::class);

    // products → admin only
    Route::middleware('admin')->group(function () {
        Route::resource('products', ProductController::class);
    });

});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [CatalogController::class, 'index'])
    ->name('catalog.index');

Route::get('/products/{slug}', [CatalogController::class, 'show'])
    ->name('catalog.show');

/*
|--------------------------------------------------------------------------
| HALAMAN LOGIN USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // =========================
    // CART
    // =========================
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/{item}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{item}', [CartController::class, 'remove'])
        ->name('cart.remove');

    // =========================
    // WISHLIST
    // =========================
    Route::get('/wishlist', function () {
        return view('wishlist.index');
    })->name('wishlist.index');

    // =========================
    // PROFILE
    // =========================
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // =========================
    // ORDERS
    // =========================
    Route::get('/orders', function () {
        return view('orders.index');
    })->name('orders.index');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGIN, LOGOUT, REGISTER)
|--------------------------------------------------------------------------
*/

Auth::routes();

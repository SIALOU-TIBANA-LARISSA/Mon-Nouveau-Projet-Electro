<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/catalogue', [FrontendController::class, 'catalogue'])
    ->name('catalogue');

Route::get('/produit/{id}', [FrontendController::class, 'productDetails'])
    ->name('product.details');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/merci', function () {
    return view('merci');
});

/*
|--------------------------------------------------------------------------
| AUTH (PAGES)
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

/*
|--------------------------------------------------------------------------
| ESPACE CLIENT (FRONTEND SEULEMENT)
|--------------------------------------------------------------------------
*/

Route::get('/account', function () {
    return view('compte');
})->name('account');

Route::get('/orders', function () {
    return view('orders');
})->name('orders');

Route::get('/orders/{id}', function ($id) {
    return view('orders.show', compact('id'));
})->name('orders.show');




<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Api\PayDunyaController;

/*
|--------------------------------------------------------------------------
| FRONTEND (PAGES PUBLIQUES)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/catalogue', function () {
    return view('catalogue');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checkout', function () {
    return view('checkout');
});

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
});

Route::get('/register', function () {
    return view('auth.register');
});

/*
|--------------------------------------------------------------------------
| PAIEMENT
|--------------------------------------------------------------------------
*/

Route::post('/checkout/process', [CheckoutController::class, 'process']);
Route::get('/payer/{order}', [PayDunyaController::class, 'payFromBrowser']);

/*
|--------------------------------------------------------------------------
| ESPACE CLIENT
|--------------------------------------------------------------------------
*/

Route::get('/my-orders', [OrderController::class, 'index']);
Route::get('/my-orders/{id}', [OrderController::class, 'show']);

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/admin', [AdminController::class, 'dashboard']);

Route::prefix('admin')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{order}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus']);

    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit']);
    Route::put('/products/{product}', [AdminProductController::class, 'update']);
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy']);

    Route::get('/users', [AdminUserController::class, 'index']);
});

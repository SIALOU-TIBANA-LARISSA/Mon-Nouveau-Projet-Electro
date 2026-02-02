<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\PayDunyaController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\AddressController;



/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Création commande (checkout interne)
Route::post('/checkout', [CheckoutController::class, 'process']);

// PAYDUNYA PAR (UNE SEULE ROUTE)
Route::post('/paydunya/par', [PayDunyaController::class, 'createParPayment']);

// IPN PayDunya
Route::post('/paydunya/ipn', [PayDunyaController::class, 'ipn']);

// Redirections navigateur
Route::get('/paydunya/success', [PayDunyaController::class, 'success']);
Route::get('/paydunya/fail', [PayDunyaController::class, 'fail']);

// Produits
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/{id_or_slug}', [ProductController::class, 'show']);

// Catégories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id_or_slug}', [CategoryController::class, 'show']);
Route::get('/categories/{id_or_slug}/products', [CategoryController::class, 'products']);

// Panier
Route::get('/cart', [CartController::class, 'show']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::put('/cart/update/{item_id}', [CartController::class, 'update']);
Route::delete('/cart/remove/{item_id}', [CartController::class, 'remove']);

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
Route::middleware('auth:sanctum')->get('/orders/{id}', [OrderController::class, 'show']);

    // Commandes
    Route::post('/orders', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'listOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'showOrder']);

    // Stripe
    Route::post('/payment/stripe/checkout', [StripeController::class, 'createCheckoutSession']);
});

Route::get('/products/{slug}', [ProductController::class, 'show']);
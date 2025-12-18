<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\PayDunyaController;
use App\Http\Controllers\Api\CheckoutController;


// -------------------------------
// ROUTES PUBLIQUES
// -------------------------------

// Auth publiques
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Checkout public (Paydunya)
Route::post('/checkout', [CheckoutController::class, 'process']);

// Produits publics
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/{id_or_slug}', [ProductController::class, 'show']);

// Catégories publiques
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id_or_slug}', [CategoryController::class, 'show']);
Route::get('/categories/{id_or_slug}/products', [CategoryController::class, 'products']);

// PayDunya callback
Route::post('/paydunya/ipn', [PayDunyaController::class, 'ipn']);
Route::get('/paydunya/success', [PayDunyaController::class, 'success']);
Route::get('/paydunya/fail', [PayDunyaController::class, 'fail']);

// ❗ La route publique pour créer une commande
Route::middleware([])->post('/orders/public', [OrderController::class, 'publicOrder']);


// -------------------------------
// ROUTES CART (PUBLIQUES POUR TON PROJET)
// -------------------------------
Route::get('/cart', [CartController::class, 'show']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::put('/cart/update/{item_id}', [CartController::class, 'update']);
Route::delete('/cart/remove/{item_id}', [CartController::class, 'remove']);


// -------------------------------
// ROUTES PROTÉGÉES PAR TOKEN
// -------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Paydunya sécurisé
    Route::post('/paydunya/checkout', [PayDunyaController::class, 'createInvoice']);

    // Commandes utilisateur
    Route::post('/orders', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'listOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'showOrder']);

    // CRUD Produits (Admin)
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // CRUD Catégories (Admin)
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Commandes admin
    Route::get('/admin/orders', [OrderController::class, 'adminListOrders']);
    Route::get('/admin/orders/{id}', [OrderController::class, 'adminShowOrder']);
    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);

    // Admin utilisateurs
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::put('/admin/users/{id}', [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);

    // Stripe paiement
    Route::post('/payment/stripe/checkout', [StripeController::class, 'createCheckoutSession']);
    Route::get('/payment/success', [StripeController::class, 'paymentSuccess']);
    Route::get('/payment/cancel',  [StripeController::class, 'paymentCancel']);
});

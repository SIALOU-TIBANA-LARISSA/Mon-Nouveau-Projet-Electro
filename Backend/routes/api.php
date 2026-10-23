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

Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);

Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp']);

Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);

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


/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES
|--------------------------------------------------------------------------
*/

Route::get('/products/{slug}', [ProductController::class, 'show']);
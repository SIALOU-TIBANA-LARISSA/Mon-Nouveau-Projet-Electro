<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', function () {
    return view('home');
});

// Catalogue
Route::get('/catalogue', [FrontendController::class, 'catalogue'])->name('catalogue');

// Détails produit
Route::get('/produit/{id}', [FrontendController::class, 'productDetails'])->name('product.details');

// Connexion
Route::get('/connexion', [FrontendController::class, 'loginPage'])->name('connexion');
Route::post('/connexion', [FrontendController::class, 'login'])->name('login.action');

Route::get('/panier', function () {
    return view('cart');
})->name('cart');

Route::get('/panier', function () {
    return view('panier');
})->name('panier');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::post('/checkout/confirm', function () {
    return "Commande confirmée ! (backend prochainement)";
});

Route::get('/merci', function () {
    return view('merci');
});

Route::get('/catalogue', [FrontendController::class, 'catalogue'])
    ->name('catalogue');
    
Route::get('/produit/{id}', [FrontendController::class, 'productDetails'])
    ->name('product.details');
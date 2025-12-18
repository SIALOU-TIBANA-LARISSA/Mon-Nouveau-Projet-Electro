<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', function () {
    return view('home'); // ✅ Laravel affichera home.blade.php
});

Route::get('/catalogue', [FrontendController::class, 'catalogue'])->name('catalogue');

Route::get('/login', function () {
    return response()->json(['message' => 'Veuillez vous connecter'], 401);
})->name('login');

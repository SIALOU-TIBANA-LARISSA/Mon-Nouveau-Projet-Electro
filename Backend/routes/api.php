<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // ⬅️ AJOUTÉ

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ROTUES PUBLIQUES (non protégées par Sanctum)
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// ROUTES PROTÉGÉES (nécessitent un token Sanctum valide)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me'); // Pour récupérer les infos de l'utilisateur connecté

    // FUTURE: Routes protégées pour les produits, commandes, etc.
});

// La route /user par défaut de Laravel peut être retirée ou laissée
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// TEST COMMIT
// });
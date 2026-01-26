<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Api\PayDunyaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\OrderController;


Route::get('/', function () {
    return view('home');
});

Route::get('/catalogue', [FrontendController::class, 'catalogue'])
    ->name('catalogue');

Route::get('/login', function () {
    return response()->json(['message' => 'Veuillez vous connecter'], 401);
})->name('login');

Route::get('/merci', function () {
    return view('merci');
});

Route::post('/checkout', [CheckoutController::class, 'process']);
Route::get('/payer/{order}', [PayDunyaController::class, 'payFromBrowser']);

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

});

Route::get('/admin', function () {
    return 'ADMIN OK';
});

Route::get('/admin', [AdminController::class, 'dashboard']);


Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])
        ->name('admin.orders');

});

Route::prefix('admin')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders');

    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('admin.products');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('admin.users');

});

Route::prefix('admin')->group(function () {

    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('admin.products');

    Route::get('/products/create', [AdminProductController::class, 'create'])
        ->name('admin.products.create');

    Route::post('/products', [AdminProductController::class, 'store'])
        ->name('admin.products.store');

    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])
        ->name('admin.products.edit');

    Route::put('/products/{product}', [AdminProductController::class, 'update'])
        ->name('admin.products.update');

    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
        ->name('admin.products.destroy');

});

Route::get('/admin/orders/{order}', [
    \App\Http\Controllers\Admin\AdminOrderController::class,
    'show'
])->name('admin.orders.show');

Route::put('/admin/orders/{order}/status', 
    [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus']
)->name('admin.orders.updateStatus');

Route::get('/my-orders', [OrderController::class, 'index'])
    ->name('orders.index');

Route::get('/my-orders/{id}', [OrderController::class, 'show'])
    ->name('orders.show');


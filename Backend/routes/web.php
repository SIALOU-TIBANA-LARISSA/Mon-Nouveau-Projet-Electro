<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\OrderController;
//use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Api\PayDunyaController;
use Illuminate\Support\Facades\Artisan;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
/*
|--------------------------------------------------------------------------
| FRONTEND (PAGES PUBLIQUES)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/catalogue', function () {
    return view('catalog');

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

//Route::post('/checkout/process', [CheckoutController::class, 'process']);
Route::get('/payer/{order}', [PayDunyaController::class, 'payFromBrowser']);

/*
|--------------------------------------------------------------------------
| ESPACE CLIENT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/my-orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/my-orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
        });

Route::get('/account', [AccountController::class, 'index'])
    ->name('account');

Route::get('/account/addresses', [AccountController::class, 'addresses'])
    ->name('account.addresses');

Route::get('/account/preferences', [AccountController::class, 'preferences'])
    ->name('account.preferences');

    Route::get('/order-detail', function () {
    return view('orders.detail');
});


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



Route::prefix('admin')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

});


Route::get('/__fix-db', function () {
    Artisan::call('migrate --force');
    Artisan::call('db:seed --force');

    return '✅ Migrations et seeders exécutés avec succès';
});


Route::get('/__fix-images', function () {
    Product::where('main_image_url', 'not like', 'http%')
        ->update([
            'main_image_url' => 'https://via.placeholder.com/600x600?text=Produit'
        ]);

    return '✅ Images produits corrigées';
});


Route::get('/catalogue', [ProductController::class, 'catalogue'])
    ->name('catalogue');


Route::get('/product/{id}', [ProductController::class, 'show'])
    ->name('product.details');

    Route::get('/product/{id}', [ProductController::class, 'showPage'])
    ->name('product.details');

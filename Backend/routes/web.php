<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\PayDunyaController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;
//use App\Http\Controllers\Api\CartController;

/*
|--------------------------------------------------------------------------
| FRONTEND (PAGES PUBLIQUES)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/catalogue', [ProductController::class, 'catalogue'])->name('catalogue');

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::post('/checkout-old', [OrderController::class, 'store'])
    ->middleware('auth')
    ->name('checkout.store');

Route::get('/merci', function () {
    return view('merci');
});

// Produit (page détail)

Route::get('/produit/{slug}', [ProductController::class, 'showBySlug'])
    ->name('produit.slug');


Route::get('/product/{id}', [ProductController::class, 'showPage'])->name('product.details');

/*
|--------------------------------------------------------------------------
| AUTH (PAGES)
|--------------------------------------------------------------------------
*/


Route::get('/forgot-choice', function () {
    return view('auth.forgot-choice');
});

Route::get('/reset-sms', function () {
    return view('reset-sms');
});

Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::get('/verify-otp', function () {
    return view('verify-otp');
})->name('verify.otp');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.web');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthController::class, 'registerWeb'])->name('register.web');


/*
|--------------------------------------------------------------------------
| MOT DE PASSE OUBLIÉ
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return back()->with('status', __($status));
})->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
            ])->save();
        }
    );

    return $status == Password::PASSWORD_RESET
        ? redirect('/login')->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.update');

/*
|--------------------------------------------------------------------------
| PAIEMENT
|--------------------------------------------------------------------------
*/

Route::get('/payer/{order}', [PayDunyaController::class, 'payFromBrowser']);

/*
|--------------------------------------------------------------------------
| ESPACE CLIENT
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/order-detail-data/{id}', function ($id) {
    return \App\Models\Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->with('items.product')
        ->firstOrFail();
});

Route::get('/my-orders', function () {
    return view('orders.index');
})->name('orders.index');


Route::get('/order-detail', function () {
    return view('orders.detail');
})->middleware('auth');

Route::put('/account/address', [AccountController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('account.address.update');

Route::get('/account', [AccountController::class, 'index'])->name('account');
Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
Route::get('/account/preferences', [AccountController::class, 'preferences'])->name('account.preferences');

Route::put('/account/preferences', [AccountController::class, 'updatePreferences'])
    ->middleware('auth')
    ->name('account.preferences.update');

Route::get('/account/messages', [MessageController::class, 'index'])
    ->middleware('auth')
    ->name('account.messages');

Route::get('/account/reviews', function () {

    $reviews = \App\Models\Review::where('user_id', auth()->id())
        ->with('product')
        ->latest()
        ->get();

    return view('account.reviews', compact('reviews'));

})->middleware('auth')->name('account.reviews');

Route::get('/account/vouchers', function () {
    return view('account.vouchers');
})->name('account.vouchers');

Route::get('/account/favorites', function () {
    return view('account.favorites');
})->name('account.favorites');



Route::get('/account/recent', function () {
    return view('account.recent');
})->name('account.recent');

/*
|--------------------------------------------------------------------------
| CONTACT (ENVOI FORMULAIRE)
|--------------------------------------------------------------------------
*/

Route::post('/contact/send', [ContactController::class, 'send']);

    Route::get('/cart-data', [CartController::class, 'show']);
    Route::post('/cart-add', [CartController::class, 'add']);
    Route::put('/cart-update/{item_id}', [CartController::class, 'update']);
    Route::delete('/cart-remove/{item_id}', [CartController::class, 'remove']);

    Route::delete('/cart-clear', [CartController::class, 'clear'])
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN (SÉCURISÉ : CONNEXION OBLIGATOIRE)
|--------------------------------------------------------------------------
| Nécessite que l'auth Laravel soit configuré (middleware 'auth' actif).
*/
 

Route::delete('/admin/products/{slug}/delete-stl',
    [ProductController::class, 'deleteStl']
)->name('admin.products.deleteStl');

Route::delete('/admin/products/{slug}/delete-svg',
    [ProductController::class, 'deleteSvg']
)->name('admin.products.deleteSvg');

Route::prefix('admin')
    ->middleware(['auth', 'role:Admin'])
    ->group(function () {

        // DASHBOARD
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/orders/{order}/message', [AdminMessageController::class, 'send'])
    ->name('admin.orders.message');  

        // PRODUITS
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

        // COMMANDES
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

        // UTILISATEURS
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');

 // ✅ SUPPRESSION IMAGE EXEMPLE
        Route::delete('/products/examples/{id}',
            [AdminProductController::class, 'deleteExample']
        )->name('admin.products.examples.delete');


    });




Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);



    // Panier
//Route::get('/cart', [CartController::class, 'show']);
//Route::post('/cart/add', [CartController::class, 'add']);
//Route::put('/cart/update/{item_id}', [CartController::class, 'update']);
//Route::delete('/cart/remove/{item_id}', [CartController::class, 'remove']);

    // Commandes
    Route::post('/orders', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'listOrders']);

    Route::get('/orders/{order}', function (\App\Models\Order $order) {
    abort_if($order->user_id !== auth()->id(), 403);

    return response()->json(
        $order->load('items.product')
    );

  });


Route::post('/checkout', [CheckoutController::class, 'process'])
    ->middleware('auth');

Route::middleware('auth')->get('/orders-data', function () {
    return \App\Models\Order::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
});

    // Stripe
    Route::post('/payment/stripe/checkout', [StripeController::class, 'createCheckoutSession']);
});

    Route::get('/account/favorites', function () {

    $favorites = \App\Models\Favorite::where('user_id', auth()->id())
        ->with('product')
        ->get();

    return view('account.favorites', compact('favorites'));

})->middleware('auth')->name('account.favorites');


Route::post('/favorite/{productId}', [ProductController::class, 'addFavorite'])
    ->middleware('auth')
    ->name('product.favorite');

    Route::post('/review/{product}', [ProductController::class, 'storeReview'])
    ->middleware('auth')
    ->name('review.store');
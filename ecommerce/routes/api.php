<?php

use App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->name('api.v1.')->group(function () {

    // Public endpoints
    Route::prefix('store')->name('store.')->group(function () {
        Route::get('/products', [V1\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [V1\ProductController::class, 'show'])->name('products.show');
        Route::get('/categories', [V1\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/brands', [V1\BrandController::class, 'index'])->name('brands.index');
    });

    // Auth endpoints
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/register', [V1\AuthController::class, 'register'])->name('register');
        Route::post('/login', [V1\AuthController::class, 'login'])->name('login');
        Route::post('/logout', [V1\AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
        Route::get('/me', [V1\AuthController::class, 'me'])->middleware('auth:sanctum')->name('me');
    });

    // Authenticated API endpoints
    Route::middleware('auth:sanctum')->group(function () {

        // Cart
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [V1\CartController::class, 'index'])->name('index');
            Route::post('/add', [V1\CartController::class, 'add'])->name('add');
            Route::patch('/{item}', [V1\CartController::class, 'update'])->name('update');
            Route::delete('/{item}', [V1\CartController::class, 'remove'])->name('remove');
        });

        // Orders
        Route::apiResource('orders', V1\OrderController::class)->only(['index', 'show', 'store']);
        Route::post('/orders/{order}/cancel', [V1\OrderController::class, 'cancel'])->name('orders.cancel');

        // Wishlist
        Route::get('/wishlist', [V1\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle/{product}', [V1\WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // Reviews
        Route::post('/reviews', [V1\ReviewController::class, 'store'])->name('reviews.store');

        // Notifications
        Route::get('/notifications', [V1\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read-all', [V1\NotificationController::class, 'readAll'])->name('notifications.readAll');

        // Profile
        Route::get('/profile', [V1\ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile', [V1\ProfileController::class, 'update'])->name('profile.update');
    });
});

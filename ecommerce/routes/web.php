<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Vendor as VendorControllers;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Store;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Store Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [Store\HomeController::class, 'index'])->name('home');
Route::get('/shop', [Store\ProductController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [Store\ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [Store\CategoryController::class, 'show'])->name('category.show');
Route::get('/brand/{slug}', [Store\BrandController::class, 'show'])->name('brand.show');
Route::get('/search', [Store\SearchController::class, 'index'])->name('search');
Route::get('/vendors', [Store\VendorController::class, 'index'])->name('vendors.index');
Route::get('/vendors/{slug}', [Store\VendorController::class, 'show'])->name('vendors.show');

// Cart (public - works for guests too)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [Store\CartController::class, 'index'])->name('index');
    Route::post('/add', [Store\CartController::class, 'add'])->name('add');
    Route::patch('/update/{item}', [Store\CartController::class, 'update'])->name('update');
    Route::delete('/remove/{item}', [Store\CartController::class, 'remove'])->name('remove');
    Route::post('/coupon', [Store\CartController::class, 'applyCoupon'])->name('coupon.apply');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [Customer\DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Customer\ProfileController::class, 'update'])->name('profile.update');

    // Addresses
    Route::resource('addresses', Customer\AddressController::class);

    // Wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [Customer\WishlistController::class, 'index'])->name('index');
        Route::post('/toggle/{product}', [Customer\WishlistController::class, 'toggle'])->name('toggle');
    });

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [Customer\CheckoutController::class, 'index'])->name('index');
        Route::post('/place-order', [Customer\CheckoutController::class, 'placeOrder'])->name('place');
        Route::get('/success/{order}', [Customer\CheckoutController::class, 'success'])->name('success');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [Customer\OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [Customer\OrderController::class, 'show'])->name('show');
        Route::post('/{order}/cancel', [Customer\OrderController::class, 'cancel'])->name('cancel');
        Route::get('/{order}/invoice', [Customer\OrderController::class, 'invoice'])->name('invoice');
        Route::get('/{order}/track', [Customer\OrderController::class, 'track'])->name('track');
    });

    // Reviews
    Route::resource('reviews', Customer\ReviewController::class)->only(['store', 'destroy']);

    // Notifications
    Route::get('/notifications', [Customer\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [Customer\NotificationController::class, 'markAsRead'])->name('notifications.read');
});

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('vendor')->name('vendor.')->group(function () {
    // Vendor registration (before vendor middleware check)
    Route::get('/register', [VendorControllers\VendorRegistrationController::class, 'create'])->name('register');
    Route::post('/register', [VendorControllers\VendorRegistrationController::class, 'store'])->name('register.store');
    Route::get('/pending', [VendorControllers\VendorRegistrationController::class, 'pending'])->name('pending');

    // Protected vendor routes
    Route::middleware('vendor')->group(function () {
        Route::get('/dashboard', [VendorControllers\DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('products', VendorControllers\ProductController::class);
        Route::post('/products/{product}/images', [VendorControllers\ProductController::class, 'uploadImages'])->name('products.images.upload');
        Route::delete('/products/{product}/images/{image}', [VendorControllers\ProductController::class, 'deleteImage'])->name('products.images.delete');

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [VendorControllers\OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [VendorControllers\OrderController::class, 'show'])->name('show');
            Route::patch('/{order}/status', [VendorControllers\OrderController::class, 'updateStatus'])->name('status');
        });

        // Store settings
        Route::get('/settings', [VendorControllers\StoreSettingsController::class, 'edit'])->name('settings');
        Route::patch('/settings', [VendorControllers\StoreSettingsController::class, 'update'])->name('settings.update');

        // Earnings & Withdrawals
        Route::get('/earnings', [VendorControllers\EarningsController::class, 'index'])->name('earnings');
        Route::post('/withdrawals', [VendorControllers\EarningsController::class, 'requestWithdrawal'])->name('withdrawals.store');

        // Analytics
        Route::get('/analytics', [VendorControllers\AnalyticsController::class, 'index'])->name('analytics');
    });
});

/*
|--------------------------------------------------------------------------
| Delivery Agent Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'delivery'])->prefix('delivery')->name('delivery.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Delivery\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/shipments', [App\Http\Controllers\Delivery\ShipmentController::class, 'index'])->name('shipments.index');
    Route::patch('/shipments/{shipment}/status', [App\Http\Controllers\Delivery\ShipmentController::class, 'updateStatus'])->name('shipments.status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', Admin\UserController::class);
    Route::patch('/users/{user}/toggle-status', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::patch('/users/{user}/change-role', [Admin\UserController::class, 'changeRole'])->name('users.role');

    // Vendors
    Route::resource('vendors', Admin\VendorController::class)->only(['index', 'show', 'destroy']);
    Route::patch('/vendors/{vendor}/approve', [Admin\VendorController::class, 'approve'])->name('vendors.approve');
    Route::patch('/vendors/{vendor}/suspend', [Admin\VendorController::class, 'suspend'])->name('vendors.suspend');

    // Products
    Route::resource('products', Admin\ProductController::class);

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Brands
    Route::resource('brands', Admin\BrandController::class);

    // Orders
    Route::resource('orders', Admin\OrderController::class)->only(['index', 'show', 'destroy']);
    Route::patch('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/orders/{order}/invoice', [Admin\OrderController::class, 'invoice'])->name('orders.invoice');

    // Coupons
    Route::resource('coupons', Admin\CouponController::class);

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [Admin\ReviewController::class, 'index'])->name('index');
        Route::patch('/{review}/approve', [Admin\ReviewController::class, 'approve'])->name('approve');
        Route::patch('/{review}/reject', [Admin\ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [Admin\ReviewController::class, 'destroy'])->name('destroy');
    });

    // Shipping Methods
    Route::resource('shipping-methods', Admin\ShippingMethodController::class);

    // Withdrawals
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [Admin\WithdrawalController::class, 'index'])->name('index');
        Route::patch('/{withdrawal}/approve', [Admin\WithdrawalController::class, 'approve'])->name('approve');
        Route::patch('/{withdrawal}/reject', [Admin\WithdrawalController::class, 'reject'])->name('reject');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [Admin\ReportController::class, 'sales'])->name('sales');
        Route::get('/revenue', [Admin\ReportController::class, 'revenue'])->name('revenue');
        Route::get('/inventory', [Admin\ReportController::class, 'inventory'])->name('inventory');
        Route::get('/vendors', [Admin\ReportController::class, 'vendors'])->name('vendors');
        Route::get('/customers', [Admin\ReportController::class, 'customers'])->name('customers');
    });

    // Settings
    Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');

    // Activity Logs
    Route::get('/logs', [Admin\ActivityLogController::class, 'index'])->name('logs');
    Route::get('/inventory-logs', [Admin\InventoryLogController::class, 'index'])->name('inventory-logs');
});

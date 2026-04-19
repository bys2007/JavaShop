<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\WishlistApiController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/produk', [CatalogController::class, 'index'])->name('catalog.index');
// ═══════════════════════════════════
// AUTH REQUIRED — CUSTOMER ROUTES
// ═══════════════════════════════════
Route::middleware('auth')->group(function () {
    // Home (post-login)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/produk/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/pembayaran/{order:order_number}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/pembayaran/{order:order_number}/metode', [CheckoutController::class, 'updateMethod'])->name('checkout.update_method');
    Route::post('/checkout/upload-bukti', [CheckoutController::class, 'uploadProof'])->name('checkout.upload-proof');

    // Order Success
    Route::get('/pesanan/berhasil', [OrderController::class, 'success'])->name('order.success');

    // Account
    Route::prefix('akun')->group(function () {
        Route::get('/', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('/profil', [AccountController::class, 'updateProfile'])->name('account.update-profile');
        Route::get('/pesanan', [AccountController::class, 'orders'])->name('account.orders');
        Route::get('/pesanan/{order}', [AccountController::class, 'orderDetail'])->name('account.order-detail');
        Route::post('/pesanan/{order}/batal', [AccountController::class, 'cancelOrder'])->name('account.order-cancel');
        Route::post('/pesanan/{order}/ulasan', [AccountController::class, 'storeReview'])->name('account.order-review.store');
        Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
        Route::get('/ulasan', [AccountController::class, 'reviews'])->name('account.reviews');
        Route::get('/notifikasi', [AccountController::class, 'notifications'])->name('account.notifications');
        Route::get('/alamat', [AccountController::class, 'addresses'])->name('account.addresses');
        Route::post('/alamat', [AccountController::class, 'storeAddress'])->name('account.addresses.store');
        Route::delete('/alamat/{address}', [AccountController::class, 'destroyAddress'])->name('account.addresses.destroy');
        Route::get('/ubah-sandi', [AccountController::class, 'changePassword'])->name('account.change-password');
    });

    // API (AJAX)
    Route::prefix('api')->group(function () {
        Route::post('/cart/add', [CartApiController::class, 'add'])->name('api.cart.add');
        Route::post('/cart/update', [CartApiController::class, 'update'])->name('api.cart.update');
        Route::post('/cart/remove', [CartApiController::class, 'remove'])->name('api.cart.remove');
        Route::get('/cart/count', [CartApiController::class, 'count'])->name('api.cart.count');
        Route::post('/wishlist/toggle', [WishlistApiController::class, 'toggle'])->name('api.wishlist.toggle');
        Route::post('/voucher/check', [\App\Http\Controllers\Api\VoucherApiController::class, 'check'])->name('api.voucher.check');
        Route::get('/locations/search', [\App\Http\Controllers\Api\LocationApiController::class, 'search'])->name('api.locations.search');
        Route::post('/payments/midtrans/notification', [\App\Http\Controllers\Api\MidtransWebhookController::class, 'handle'])->name('api.midtrans.webhook');
        Route::post('/payments/midtrans/finish', [\App\Http\Controllers\Api\MidtransWebhookController::class, 'finish'])->name('api.midtrans.finish');
        Route::post('/shipping/couriers', [\App\Http\Controllers\Api\ShippingApiController::class, 'getCouriers'])->name('api.shipping.couriers');
    });

    // Breeze Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard redirect for Breeze compatibility
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect('/admin');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// ═══════════════════════════════════
// ADMIN AUTH (separate from Breeze)
// ═══════════════════════════════════
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('filament.admin.auth.logout');

require __DIR__.'/auth.php';

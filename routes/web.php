<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SettingController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes wrapped inside LaravelLocalization Group
|--------------------------------------------------------------------------
*/
$locales = (app()->environment('testing') || app()->runningInConsole())
    ? ['en', 'ar']
    : [LaravelLocalization::setLocale()];

foreach ($locales as $locale) {
    Route::group([
        'prefix' => $locale,
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    /*
    |--------------------------------------------------------------------------
    | Public Routes (Client facing)
    |--------------------------------------------------------------------------
    | These routes support both Arabic and English prefixes automatically.
    */
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/store', [HomeController::class, 'store'])->name('store');
    Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product.show');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
    Route::post('/product/{product_id}/review', [HomeController::class, 'submitReview'])->name('review.submit');

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes (Admin login/logout)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin.basic', 'admin.ip'])->group(function () {
        Route::get('/secure-admin-portal', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/secure-admin-portal', [AuthController::class, 'login']);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Routes (Dashboard & Management)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin.ip'])->prefix('admin')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // CRUDs
        Route::resource('categories', CategoryController::class)->names('admin.categories');
        Route::resource('brands', BrandController::class)->names('admin.brands');
        Route::resource('products', ProductController::class)->names('admin.products');
        
        // Reviews moderation
        Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
        
        // Contact Messages
        Route::get('contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
        Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
        
        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');
    });

    });
}

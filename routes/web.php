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
$isRouteCache = false;
if (app()->runningInConsole()) {
    $argv = $_SERVER['argv'] ?? [];
    foreach ($argv as $arg) {
        if (str_contains($arg, 'route:cache') || str_contains($arg, 'optimize')) {
            $isRouteCache = true;
            break;
        }
    }
}

$locales = (app()->environment('testing') || (app()->runningInConsole() && !$isRouteCache))
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

Route::get('/debug-env', function () {
    return [
        'env_cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'env_api_key' => env('CLOUDINARY_API_KEY'),
        'env_api_secret' => env('CLOUDINARY_API_SECRET'),
        'getenv_cloud_name' => getenv('CLOUDINARY_CLOUD_NAME'),
        'getenv_api_key' => getenv('CLOUDINARY_API_KEY'),
        'getenv_api_secret' => getenv('CLOUDINARY_API_SECRET'),
        '_SERVER_cloud_name' => $_SERVER['CLOUDINARY_CLOUD_NAME'] ?? null,
        '_SERVER_api_key' => $_SERVER['CLOUDINARY_API_KEY'] ?? null,
        '_SERVER_api_secret' => $_SERVER['CLOUDINARY_API_SECRET'] ?? null,
    ];
});

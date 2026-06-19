<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Brand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Share categories and brands globally across all views (excluding console)
        if (!app()->runningInConsole()) {
            try {
                view()->share('globalCategories', Category::withCount('products')->get());
                view()->share('globalBrands', Brand::get());
            } catch (\Exception $e) {
                view()->share('globalCategories', collect());
                view()->share('globalBrands', collect());
            }
        }
    }
}


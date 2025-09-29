<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product_category;
use Illuminate\Support\Facades\View;

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
        $categories = Product_category::with('translations', 'hasChild')
            ->where('level', 1)
            ->where('status', 'active')
            ->get();

        View::share('categories', $categories);
    }
}

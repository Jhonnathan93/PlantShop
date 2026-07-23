<?php

namespace App\Providers;

use App\Interfaces\MediaStorage;
use App\Models\Category;
use App\Services\MediaStorageService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MediaStorage::class, MediaStorageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.navbar', function ($view): void {
            $view->with('navigationCategories', Category::query()->orderBy('name')->get());
        });
    }
}

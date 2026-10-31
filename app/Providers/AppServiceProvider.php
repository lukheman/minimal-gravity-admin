<?php

namespace App\Providers;

use App\Models\SocialLink;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        View::composer('components.layouts.public', function ($view): void {
            $view->with('socialLinks', SocialLink::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get());
        });
    }
}

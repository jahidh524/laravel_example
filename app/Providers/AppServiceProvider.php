<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

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
        // Fix for Vite manifest not found
        Blade::directive('vite', function () {
            return '<?php // Vite directive intentionally disabled ?>';
        });
        
        Blade::directive('viteReactRefresh', function () {
            return '<?php // Vite React Refresh directive intentionally disabled ?>';
        });
        
        // If you're using HTTPS in production, uncomment this:
        // if (config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }
    }
}
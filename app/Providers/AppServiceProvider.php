<?php

namespace App\Providers;

use App\Components\WebsocketApplicationProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\ApplicationManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app(ApplicationManager::class)
            ->extend(WebsocketApplicationProvider::APP_PROVIDER_NAME, function ($container) {
                return new WebsocketApplicationProvider();
            });
    }
}

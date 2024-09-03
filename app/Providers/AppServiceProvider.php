<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Services\MicrosoftTokenService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    
    public function register(): void
    {
        // Registra el servicio
        $this->app->singleton(MicrosoftTokenService::class, function ($app) {
            return new MicrosoftTokenService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
        });
    }
}

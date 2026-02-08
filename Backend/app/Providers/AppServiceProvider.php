<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // ⬅️ AJOUTÉ
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
        // ➡️ LIGNE CRUCIALE POUR CORRIGER LES INDEX MYSQL DANS DOCKER ⬅️
        // Fixe le problème des clés trop longues pour les versions anciennes de MySQL
        Schema::defaultStringLength(191);

    // Force toutes les URLs en HTTPS (important pour reset password & emails)
    URL::forceScheme('https');


    }

}

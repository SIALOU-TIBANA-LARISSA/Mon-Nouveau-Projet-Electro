<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // ⬅️ AJOUTÉ

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
    }
}
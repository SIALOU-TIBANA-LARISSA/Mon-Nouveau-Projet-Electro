<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder; 
use Database\Seeders\CategorySeeder; // ⬅️ IMPORT DE LA NOUVELLE CLASSE
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tous les seeders DOIVENT être dans ce tableau [], séparés par des virgules.
        $this->call([
            RoleSeeder::class,     // 1. Rôles (doit être fait en premier)
            UserSeeder::class,     // 2. Utilisateurs (dépend des rôles)
            CategorySeeder::class, // 3. Catégories (AJOUTÉ ICI)//
            ProductSeeder::class,
            
            // Les produits, commandes, etc., viendront plus tard...
        ]);
    }
}
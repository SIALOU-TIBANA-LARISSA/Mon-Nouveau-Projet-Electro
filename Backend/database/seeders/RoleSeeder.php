<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Insère les rôles initiaux : Admin, Designer, Opérateur.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Administrateur avec accès complet au back-office et aux paramètres système.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Designer',
                'description' => 'Gère les personnalisations (logos, textes) et l\'envoi en production.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Opérateur',
                'description' => 'Gère les commandes, l\'emballage et l\'expédition des produits finis.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
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

    $roles = [
        [
            'name' => 'Admin',
            'description' => 'Administrateur avec accès complet au back-office et aux paramètres système.',
        ],
        [
            'name' => 'Designer',
            'description' => 'Gère les personnalisations (logos, textes) et l\'envoi en production.',
        ],
        [
            'name' => 'Opérateur',
            'description' => 'Gère les commandes, l\'emballage et l\'expédition des produits finis.',
        ],
    ];

    foreach ($roles as $role) {
        DB::table('roles')->updateOrInsert(
            ['name' => $role['name']],   // clé unique
            [
                'description' => $role['description'],
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }
 }
}
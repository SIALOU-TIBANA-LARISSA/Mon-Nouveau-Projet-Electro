<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Insère des catégories de produits par défaut.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('categories')->insert([
            [
                'name' => 'T-Shirts',
                'slug' => 't-shirts',
                'description' => 'Tous les types de T-shirts personnalisables (homme, femme, enfant).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mugs',
                'slug' => 'mugs',
                'description' => 'Tasses et mugs pour boissons chaudes, parfaits pour l\'impression de logos.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Stickers',
                'slug' => 'stickers',
                'description' => 'Autocollants en vinyle de différentes formes et tailles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Coques Téléphone',
                'slug' => 'coques-telephone',
                'description' => 'Coques de protection pour divers modèles de téléphones mobiles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->command->info('✅ 4 Catégories initiales insérées.');
    }
}
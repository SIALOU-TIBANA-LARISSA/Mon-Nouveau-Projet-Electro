<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Crée un utilisateur Administrateur par défaut.
     */
    public function run(): void
    {
        // 1. Trouver l'ID du rôle 'Admin' créé par RoleSeeder
        $adminRole = DB::table('roles')->where('name', 'Admin')->first();

        if ($adminRole) {
            DB::table('users')->updateOrInsert(
        ['email' => 'admin@electrov2.com'], // clé unique
        [
        'role_id' => $adminRole->id,
        'name' => 'Admin Electro V2',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('password'),
        'updated_at' => Carbon::now(),
        'created_at' => Carbon::now(),
        ]
);


            $this->command->info('✅ Utilisateur Admin créé : admin@electrov2.com (Mot de passe: password)');
        } else {
            $this->command->error('❌ Le rôle "Admin" n\'a pas été trouvé. Veuillez vérifier RoleSeeder.');
        }
    }
}
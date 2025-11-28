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
            DB::table('users')->insert([
                'role_id' => $adminRole->id, // Liaison au rôle 'Admin'
                'name' => 'Admin Electro V2',
                'email' => 'admin@electrov2.com',
                'email_verified_at' => Carbon::now(),
                // Le mot de passe haché de 'password'
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $this->command->info('✅ Utilisateur Admin créé : admin@electrov2.com (Mot de passe: password)');
        } else {
            $this->command->error('❌ Le rôle "Admin" n\'a pas été trouvé. Veuillez vérifier RoleSeeder.');
        }
    }
}
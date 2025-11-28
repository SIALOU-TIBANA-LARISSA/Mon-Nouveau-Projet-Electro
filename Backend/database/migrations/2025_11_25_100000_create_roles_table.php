<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette table définit les rôles des utilisateurs (Admin, Designer, Opérateur).
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            // Nom du rôle (ex: 'Admin', 'Designer', 'Opérateur')
            // Doit être unique pour éviter les doublons
            $table->string('name')->unique();

            // Description pour clarifier le rôle
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

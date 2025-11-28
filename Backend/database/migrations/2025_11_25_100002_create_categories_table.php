<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table des catégories de produits.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Nom de la catégorie (ex: "Claviers")
            $table->string('name')->unique();

            // Slug unique pour l'URL (ex: "claviers")
            $table->string('slug')->unique();

            // Courte description pour le SEO ou l'affichage
            $table->text('description')->nullable();

            // Champ pour la hiérarchie (si une catégorie a un parent)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
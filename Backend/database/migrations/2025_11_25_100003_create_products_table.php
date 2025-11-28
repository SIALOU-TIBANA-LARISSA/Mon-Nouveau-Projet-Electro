<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table des produits.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // LIEN VERS LA TABLE DES CATÉGORIES
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');

            // Informations du produit
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Prix et Stock
            $table->decimal('price', 8, 2); // Prix du produit (8 chiffres au total, 2 décimales)
            $table->integer('stock_quantity')->default(0); // Quantité en stock
            $table->boolean('is_published')->default(false); // Statut de publication

            // Images et Références
            $table->string('main_image_url')->nullable(); // URL de l'image principale
            $table->string('sku')->unique(); // Stock Keeping Unit (référence unique)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

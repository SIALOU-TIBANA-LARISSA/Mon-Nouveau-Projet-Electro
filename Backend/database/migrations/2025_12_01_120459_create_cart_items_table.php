<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Chaque article appartient à un panier
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');

            // Produit associé
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');

            // Quantité choisie par le client
            $table->integer('quantity')->default(1);

            // Prix unitaire du produit au moment où il a été ajouté
            $table->decimal('unit_price', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

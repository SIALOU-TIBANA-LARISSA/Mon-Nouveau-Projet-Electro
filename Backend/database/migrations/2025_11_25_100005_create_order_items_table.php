<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table de liaison entre les commandes (orders) et les produits (products).
     * Elle stocke les détails de chaque produit inclus dans une commande.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // ➡️ LIEN VERS LA COMMANDE MÈRE ⬅️
            // 'onDelete('cascade')' signifie que si la commande est supprimée, tous ses articles sont supprimés.
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            // ➡️ LIEN VERS LE PRODUIT COMMANDÉ ⬅️
            // 'onDelete('restrict')' empêche la suppression d'un produit s'il est encore référencé dans une commande.
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');

            $table->integer('quantity'); // Quantité commandée de ce produit spécifique
            $table->decimal('unit_price', 8, 2); // Prix unitaire du produit au moment de la commande

            $table->timestamps();

            // Rendre la combinaison order_id et product_id unique pour éviter les doublons dans une seule commande
            $table->unique(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

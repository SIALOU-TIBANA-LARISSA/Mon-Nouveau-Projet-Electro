<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table des commandes clients.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // ➡️ LIEN VERS L'UTILISATEUR QUI A PASSÉ LA COMMANDE ⬅️
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');

            // Détails financiers de la commande
            $table->decimal('total_amount', 10, 2); // Montant total final de la commande
            $table->string('status')->default('pending'); // Statut: pending, processing, shipped, delivered, cancelled

            // Informations de livraison
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_zip');
            $table->string('shipping_country');

            // Numéro de référence unique de la commande (pour le client)
            $table->string('reference_number')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

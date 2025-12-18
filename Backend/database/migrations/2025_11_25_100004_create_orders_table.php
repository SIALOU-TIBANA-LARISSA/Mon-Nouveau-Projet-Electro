<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // ➡️ LIEN VERS L'UTILISATEUR QUI PASSE LA COMMANDE
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');

            // Détails financiers
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending');

            // Informations de livraison — RENDUES NULLABLES
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('payment_session_id')->nullable();

            // Numéro de commande unique
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

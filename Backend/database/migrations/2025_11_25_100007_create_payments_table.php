<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table des paiements effectués pour chaque commande.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // ➡️ LIEN VERS LA COMMANDE CONCERNÉE ⬅️
            // Une commande peut avoir un seul paiement (ou plusieurs tentatives).
            $table->foreignId('order_id')->constrained('orders')->onDelete('restrict');

            $table->string('transaction_id')->unique(); // ID de la transaction fourni par Stripe, CinetPay, etc.
            $table->decimal('amount', 10, 2); // Montant payé
            $table->string('currency')->default('XOF'); // Devise de la transaction (XOF par défaut)
            $table->string('payment_method'); // Méthode de paiement: 'stripe', 'mobile_money', 'carte'
            $table->string('status')->default('pending'); // Statut: 'pending', 'succeeded', 'failed'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

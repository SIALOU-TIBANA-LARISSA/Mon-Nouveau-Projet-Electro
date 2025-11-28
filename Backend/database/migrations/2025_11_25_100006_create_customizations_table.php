<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table des personnalisations demandées par le client.
     */
    public function up(): void
    {
        Schema::create('customizations', function (Blueprint $table) {
            $table->id();

            // ➡️ LIEN VERS L'ARTICLE DANS LA COMMANDE QUI EST PERSONNALISÉ ⬅️
            // C'est l'article spécifique qui contient le produit (ex: T-shirt blanc)
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');

            // Détails de la personnalisation
            $table->string('type'); // Type de personnalisation: 'text', 'logo', 'image'
            $table->text('details'); // Les données réelles (texte, ou chemin/URL du fichier)

            // Statut de la personnalisation pour l'atelier (ex: 'pending', 'validated', 'printed')
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customizations');
    }
};
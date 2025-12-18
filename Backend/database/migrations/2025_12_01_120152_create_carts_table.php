<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // Le panier appartient à un utilisateur (connecté)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Total du panier (calculé automatiquement)
            $table->decimal('total_amount', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};


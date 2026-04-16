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
        /* Tabla creada para vincular a cada clan con sus disciplinas nativas, que salvo los Caitiff todos tienen alguna
         *
         */
        Schema::create('clan_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained('clanes')->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clan_disciplina');
    }
};

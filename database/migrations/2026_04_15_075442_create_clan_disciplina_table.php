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
        Schema::create('clan_disciplina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained();
            $table->foreignId('disciplina_id')->constrained();

            //Un booleano que determina si una disciplina es nativa de clan o no, (para costes de experiencia menores)
            $table->boolean('pertenece_clan')->default(true);
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

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
        Schema::create('personaje_disciplina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personaje_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');

            /*Que nivel de maestría tiene sobre esa disciplina, pero algunas disciplinas de clan pueden no aprenderse
            durante la creación de personaje, sin embargo tienes un bono de facilidad de aprendizaje al momento de tener,
            al menos, solo la disciplina, (menos coste de experiencia)*/

            $table->tinyInteger('nivel_aprendido')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personaje_disciplina');
    }
};

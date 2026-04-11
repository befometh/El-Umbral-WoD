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
        Schema::create('personajes', function (Blueprint $table) {
            $table->id(); // ID único del personaje

            // Conexión con el usuario. Si borras al usuario, se borran sus fichas.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Datos principales
            $table->string('nombre');
            $table->string('clan');
            $table->unsignedTinyInteger('generacion')->default(13);

            // Atributos físicos (Rango 1-5 para vástagos o hasta 10 para Matusalenes)
            $table->unsignedTinyInteger('fuerza')->default(1);
            $table->unsignedTinyInteger('destreza')->default(1);
            $table->unsignedTinyInteger('resistencia')->default(1);

            // Atributos sociales
            $table->unsignedTinyInteger('carisma')->default(1);
            $table->unsignedTinyInteger('manipulacion')->default(1);
            $table->unsignedTinyInteger('apariencia')->default(1);

            // Atributos mentales
            $table->unsignedTinyInteger('percepcion')->default(1);
            $table->unsignedTinyInteger('inteligencia')->default(1);
            $table->unsignedTinyInteger('astucia')->default(1);

            // Estado Vital
            $table->unsignedTinyInteger('salud_actual')->default(7); // Niveles de salud estándar
            $table->unsignedSmallInteger('reserva_sangre')->default(0); // Comienza con 0 puntos de sangre

            $table->timestamps(); // Crea created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personajes');
    }
};

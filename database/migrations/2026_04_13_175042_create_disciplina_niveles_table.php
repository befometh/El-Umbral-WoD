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
        Schema::create('disciplina_niveles', function (Blueprint $table) {
            // --- INFORMACIÓN PRINCIPAL/GENERAL ---
            $table->id();
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->integer('nivel');
            $table->string('nombre');
            $table->text('descripcion')->nullable(); //Descripción del punto de disciplina
            $table->text('sistema')->nullable(); //Sistema aplicado, (solo informativo)

            // --- EL MOTOR LÓGICO ---
            // Array de strings: ["percepción", "atletismo", "nivel_disciplina", etc.]
            $table->json('pool_dados_lanzados')->nullable();

            // Objeto: {"fuerza": 1} -> Stats cuando  suma cuando la disciplina está inactiva
            $table->json('pool_stats_pasivos')->nullable();

            // Objeto: {"destreza": 2} -> Si la disciplina está activa
            $table->json('pool_stats_activos')->nullable();

            /* Refleja el comportamiento de la disciplina
             * 1 - Activación instántanea
             * 2 - Interruptor, (Si se activa solo funciona el estado activo, si se desactiva, solo el pasivo)
             * 3 - Híbrida, (Siempre permanecen las características pasivas aunque se active)
             * 4 - Siempre activa, (como la disciplina Fortaleza, por ejemplo)
             */
            $table->Integer('comportamiento')->default(1);

            /* Tiempo de duración de la disciplina
             * -1: Definido por tirada de dados
             *  0: Permanente/Dura una escena
             *  1: Efecto instantaneo
             *  <1: Turnos de duración
             */
            $table->tinyInteger('duracion')->default(1)->nullable();

            /* Array de objetos: [{"tipo": 1, "valor": 1}, {"tipo": 2, "valor": 1}] según esta lista:
             * -Tipo 1: Puntos de sangre
             * -Tipo 2: Puntos de Fuerza de Voluntad Temporal
             * -Tipo 3: Puntos de Fuerza de Voluntad Permanentes
             *
             * Cantidad: coste en cantidad de puntos respectivos gastados
             */
            $table->json('costes')->nullable();

            // Array de strings: ["$personaje ha liberado sus garras, $personaje fuerza a quemar la sangre de $victima, etc."]
            $table->json('msj_info')->nullable();
            $table->boolean('visible')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplina_nivels');
    }
};

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
        Schema::create('personaje_niveles_disciplina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personaje_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_niveles_id')->constrained('disciplina_niveles')->onDelete('cascade');

            //false: Se aplican los "cambios de estado pasivos" (si aplica), true: Se aplican los "cambios de estado activos";
            $table->boolean('estado_actual')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personaje_niveles_disciplina');
    }
};

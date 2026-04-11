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
        Schema::create('personaje_habilidad', function (Blueprint $table) {
            $table->id();
            //Claves foráneas, que borran automáticamente elementos de esta tabla si se borra o el personaje o la habilidad asociada
            $table->unsignedBigInteger('personaje_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('habilidad_id')->constrained()->onDelete('cascade');

            //Todas las habilidades empiezan por 0
            $table->unsignedTinyInteger('nivel')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personaje_habilidad');
    }
};

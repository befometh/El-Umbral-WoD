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
        Schema::create('clanes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            //Todos los clanes tienen un apodo despectivo por el que se les caracteriza
            $table->string('apodo')->nullable();

            //Si normalmente pertenece a la camarilla, al sabbat o si es de los clanes independientes
            $table->string('faccion')->nullable();

            /* Según qué clanes descienden de otros, por ejemplo los Malkavian (Antitribu) que descienden de los base
             * por utilidad vamos a autoreferenciar un posible clan padre, si es linea principal = nulo
             */
            $table->foreignId('clan_padre_id')->nullable()->constrained();

            $table->text('debilidad')->nullable();
            $table->boolean('visible')->default(false);
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clans');
    }
};

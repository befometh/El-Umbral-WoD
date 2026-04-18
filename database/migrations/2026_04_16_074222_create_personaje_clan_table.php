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
        Schema::create('personaje_clan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personaje_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('clan_id')->unique()->constrained('clanes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personaje_clan');
    }
};

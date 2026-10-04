<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rpe_partidos')) {
            Schema::create('rpe_partidos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('partido_id')->constrained('partidos')->cascadeOnDelete();
                $table->foreignId('jugador_id')->constrained('jugadores')->cascadeOnDelete();
                $table->decimal('rpe', 3, 1);
                $table->unsignedSmallInteger('minutos');
                $table->timestamps();
                $table->unique(['partido_id', 'jugador_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rpe_partidos');
    }
};

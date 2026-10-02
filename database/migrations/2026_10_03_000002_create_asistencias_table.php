<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrenamiento_id')->constrained('entrenamientos')->onDelete('cascade');
            $table->foreignId('jugador_id')->constrained('jugadores')->onDelete('cascade');
            $table->string('estado');
            $table->decimal('multa', 8, 2)->default(0);
            $table->string('motivo')->nullable();
            $table->timestamps();
            $table->unique(['entrenamiento_id', 'jugador_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('equipo_local');
            $table->string('equipo_visitante');
            $table->dateTime('fecha');
            $table->string('lugar');
            $table->enum('estado', ['pendiente', 'en_curso', 'finalizado', 'cancelado'])->default('pendiente');
            $table->integer('goles_local')->nullable();
            $table->integer('goles_visitante')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};

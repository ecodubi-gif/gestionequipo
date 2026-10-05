<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tareas_sesion')) {
            Schema::create('tareas_sesion', function (Blueprint $table) {
                $table->id();
                $table->foreignId('entrenamiento_id')->constrained('entrenamientos')->cascadeOnDelete();
                $table->string('bloque', 30);
                $table->string('nombre', 120);
                $table->string('objetivo', 30)->nullable();
                $table->string('referencia', 20)->default('sin_referencia');
                $table->unsignedTinyInteger('n_ataque')->default(0);
                $table->unsignedTinyInteger('n_defensa')->default(0);
                $table->unsignedTinyInteger('n_comodines')->default(0);
                $table->unsignedTinyInteger('n_porteros')->default(0);
                $table->unsignedSmallInteger('largo')->nullable();
                $table->unsignedSmallInteger('ancho')->nullable();
                $table->unsignedTinyInteger('series')->default(1);
                $table->unsignedSmallInteger('duracion_min')->nullable();
                $table->unsignedSmallInteger('pausa_seg')->nullable();
                $table->text('descripcion')->nullable();
                $table->json('jugadores')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_sesion');
    }
};

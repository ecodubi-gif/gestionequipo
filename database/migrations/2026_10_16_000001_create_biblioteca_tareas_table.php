<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('biblioteca_tareas')) {
            Schema::create('biblioteca_tareas', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 120);
                $table->string('bloque', 30)->nullable();
                $table->string('objetivo', 30)->nullable();
                $table->string('referencia', 20)->default('sin_referencia');
                $table->unsignedTinyInteger('n_ataque')->default(0);
                $table->unsignedTinyInteger('n_defensa')->default(0);
                $table->unsignedTinyInteger('n_comodines')->default(0);
                $table->unsignedTinyInteger('n_porteros')->default(0);
                $table->unsignedSmallInteger('largo')->nullable();
                $table->unsignedSmallInteger('ancho')->nullable();
                $table->unsignedTinyInteger('series')->default(3);
                $table->unsignedSmallInteger('duracion_seg')->nullable();
                $table->unsignedSmallInteger('pausa_seg')->nullable();
                $table->text('descripcion')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('biblioteca_tareas');
    }
};

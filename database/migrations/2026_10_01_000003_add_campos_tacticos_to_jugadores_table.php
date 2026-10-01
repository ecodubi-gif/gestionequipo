<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            if (!Schema::hasColumn('jugadores', 'posicion')) {
                $table->string('posicion')->nullable()->default('Centrocampista');
            }
            if (!Schema::hasColumn('jugadores', 'pierna')) {
                $table->string('pierna')->nullable()->default('Derecha');
            }
            if (!Schema::hasColumn('jugadores', 'estado')) {
                $table->string('estado')->nullable()->default('Disponible');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn(['posicion', 'pierna', 'estado']);
        });
    }
};

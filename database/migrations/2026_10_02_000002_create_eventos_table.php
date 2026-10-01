<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partido_id')->constrained()->onDelete('cascade');
            $table->string('tipo');
            $table->string('equipo');
            $table->unsignedInteger('minuto');
            $table->unsignedTinyInteger('parte')->default(1);
            $table->string('resultado')->nullable();
            $table->foreignId('jugador_id')->nullable()->constrained('jugadores')->nullOnDelete();
            $table->foreignId('jugador_sale_id')->nullable()->constrained('jugadores')->nullOnDelete();
            $table->foreignId('jugador_entra_id')->nullable()->constrained('jugadores')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

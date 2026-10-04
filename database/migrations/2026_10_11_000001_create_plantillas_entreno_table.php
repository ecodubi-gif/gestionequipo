<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('plantillas_entreno')) {
            Schema::create('plantillas_entreno', function (Blueprint $table) {
                $table->id();
                $table->unsignedTinyInteger('numero')->unique();
                $table->json('preventivo');
                $table->json('movilidad');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('plantillas_entreno');
    }
};

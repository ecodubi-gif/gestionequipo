<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('jugadores', 'posicion_secundaria')) {
            Schema::table('jugadores', function (Blueprint $table) {
                $table->string('posicion_secundaria', 40)->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn('posicion_secundaria');
        });
    }
};

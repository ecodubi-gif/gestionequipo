<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entrenamientos', function (Blueprint $table) {
            if (! Schema::hasColumn('entrenamientos', 'duracion_minutos')) {
                $table->unsignedSmallInteger('duracion_minutos')->nullable();
            }
            if (! Schema::hasColumn('entrenamientos', 'rpe_medio')) {
                $table->decimal('rpe_medio', 3, 1)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('entrenamientos', function (Blueprint $table) {
            $table->dropColumn(['duracion_minutos', 'rpe_medio']);
        });
    }
};

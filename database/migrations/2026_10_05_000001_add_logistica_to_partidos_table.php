<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            $table->boolean('es_local')->default(true)->after('lugar');
            $table->string('lugar_citacion')->nullable()->after('es_local');
            $table->time('hora_citacion')->nullable()->after('lugar_citacion');
        });
    }

    public function down(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            $table->dropColumn(['es_local', 'lugar_citacion', 'hora_citacion']);
        });
    }
};

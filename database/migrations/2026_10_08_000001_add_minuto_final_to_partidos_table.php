<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('partidos', 'minuto_final')) {
            Schema::table('partidos', function (Blueprint $table) {
                $table->unsignedSmallInteger('minuto_final')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            $table->dropColumn('minuto_final');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entrenamientos', function (Blueprint $table) {
            if (! Schema::hasColumn('entrenamientos', 'tipo_sesion')) {
                $table->unsignedTinyInteger('tipo_sesion')->nullable();
            }
            if (! Schema::hasColumn('entrenamientos', 'bloques')) {
                $table->text('bloques')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('entrenamientos', function (Blueprint $table) {
            $table->dropColumn(['tipo_sesion', 'bloques']);
        });
    }
};

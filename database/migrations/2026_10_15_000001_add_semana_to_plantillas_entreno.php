<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('plantillas_entreno', 'semana')) {
            Schema::table('plantillas_entreno', function (Blueprint $table) {
                $table->json('semana')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('plantillas_entreno', 'semana')) {
            Schema::table('plantillas_entreno', function (Blueprint $table) {
                $table->dropColumn('semana');
            });
        }
    }
};

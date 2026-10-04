<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            if (! Schema::hasColumn('jugadores', 'readaptacion')) {
                $table->string('readaptacion', 500)->nullable();
            }
            if (! Schema::hasColumn('jugadores', 'observaciones')) {
                $table->string('observaciones', 500)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn(['readaptacion', 'observaciones']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('eventos', 'dorsal_rival')) {
            Schema::table('eventos', function (Blueprint $table) {
                $table->unsignedSmallInteger('dorsal_rival')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('dorsal_rival');
        });
    }
};

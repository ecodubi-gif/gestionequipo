<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tareas_sesion', 'duracion_seg')) {
            Schema::table('tareas_sesion', function (Blueprint $table) {
                $table->unsignedSmallInteger('duracion_seg')->nullable()->after('duracion_min');
            });
        }
        // Las tareas que ya existían tenían la duración en minutos.
        DB::table('tareas_sesion')->whereNull('duracion_seg')->whereNotNull('duracion_min')
            ->update(['duracion_seg' => DB::raw('duracion_min * 60')]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('tareas_sesion', 'duracion_seg')) {
            Schema::table('tareas_sesion', function (Blueprint $table) {
                $table->dropColumn('duracion_seg');
            });
        }
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * RPE (esfuerzo percibido, 1-10) que un jugador dio a un partido, y los minutos
 * que jugó. La carga es rpe × minutos. Los minutos se guardan tal como estaban
 * al registrar el RPE.
 */
class RpePartido extends Model
{
    protected $table = 'rpe_partidos';

    protected $fillable = ['partido_id', 'jugador_id', 'rpe', 'minutos'];

    protected $casts = [
        'rpe' => 'float',
        'minutos' => 'integer',
    ];
}

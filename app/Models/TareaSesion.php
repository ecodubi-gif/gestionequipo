<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Una tarea de la sesión de entrenamiento: formato (ataque / defensa / comodines),
 * espacio, series y los jugadores asignados a cada rol.
 */
class TareaSesion extends Model
{
    protected $table = 'tareas_sesion';

    protected $fillable = [
        'entrenamiento_id', 'bloque', 'nombre', 'objetivo', 'referencia',
        'n_ataque', 'n_defensa', 'n_comodines', 'n_porteros',
        'largo', 'ancho', 'series', 'duracion_min', 'duracion_seg', 'pausa_seg',
        'descripcion', 'jugadores',
    ];

    protected $casts = [
        'jugadores' => 'array',
    ];

    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class);
    }
}

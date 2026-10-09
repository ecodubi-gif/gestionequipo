<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Una tarea guardada para reutilizar en cualquier sesión (sin jugadores asignados). */
class BibliotecaTarea extends Model
{
    protected $table = 'biblioteca_tareas';

    protected $fillable = [
        'nombre', 'bloque', 'objetivo', 'referencia',
        'n_ataque', 'n_defensa', 'n_comodines', 'n_porteros',
        'largo', 'ancho', 'series', 'duracion_seg', 'pausa_seg', 'descripcion',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = ['entrenamiento_id', 'jugador_id', 'estado', 'multa', 'motivo'];

    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class);
    }

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }
}

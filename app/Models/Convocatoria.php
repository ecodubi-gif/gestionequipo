<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{
    protected $fillable = ['partido_id', 'jugador_id', 'titular'];
    protected $casts = ['titular' => 'boolean'];

    public function partido() { return $this->belongsTo(Partido::class); }
    public function jugador() { return $this->belongsTo(Jugador::class); }
}

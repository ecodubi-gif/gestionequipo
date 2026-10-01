<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'equipo_local',
        'equipo_visitante',
        'fecha',
        'lugar',
        'estado',
        'goles_local',
        'goles_visitante'
    ];

    public function convocatorias()
    {
        return $this->hasMany(Convocatoria::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

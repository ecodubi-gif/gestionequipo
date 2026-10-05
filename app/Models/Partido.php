<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    protected $fillable = [
        'user_id',
        'equipo_local',
        'equipo_visitante',
        'fecha',
        'lugar',
        'estado',
        'goles_local',
        'goles_visitante',
        'es_local',
        'lugar_citacion',
        'hora_citacion', 'minuto_final'
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

    /**
     * La app manda la fecha como instante UTC ("...Z"). La columna guarda la hora local
     * sin zona, así que se pasa a la hora de la aplicación (Europe/Madrid) antes de guardarla.
     * Sin esto, un partido de las 12:00 se guardaría como las 10:00 u 11:00.
     */
    public function setFechaAttribute($valor): void
    {
        $this->attributes['fecha'] = ($valor === null || $valor === '')
            ? null
            : \Illuminate\Support\Carbon::parse($valor)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
    }
}

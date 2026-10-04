<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'partido_id', 'tipo', 'equipo', 'minuto', 'parte',
        'resultado', 'jugador_id', 'jugador_sale_id', 'jugador_entra_id', 'dorsal_rival'
    ];

    public function partido() { return $this->belongsTo(Partido::class); }
    public function jugador() { return $this->belongsTo(Jugador::class); }
    public function jugadorSale() { return $this->belongsTo(Jugador::class, 'jugador_sale_id'); }
    public function jugadorEntra() { return $this->belongsTo(Jugador::class, 'jugador_entra_id'); }
}

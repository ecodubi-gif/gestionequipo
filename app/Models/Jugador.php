<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';

    protected $fillable = [
        'dorsal',
        'nombre',
        'apellidos',
        'apodo',
        'posicion',
        'pierna',
        'estado', 'posicion_secundaria'
    ];
}

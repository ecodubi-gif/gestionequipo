<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Programa de preparación física de un tipo de entreno (1, 2 o 3):
 * trabajo preventivo (estaciones) y movilidad (tramos). Lo gestiona el
 * preparador físico y se aplica a todos los entrenos de ese tipo.
 */
class PlantillaEntreno extends Model
{
    protected $table = 'plantillas_entreno';

    protected $fillable = ['numero', 'preventivo', 'movilidad'];

    protected $casts = [
        'preventivo' => 'array',
        'movilidad' => 'array',
    ];
}

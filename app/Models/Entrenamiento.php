<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    protected $fillable = ['fecha', 'hora', 'lugar', 'material', 'notas', 'user_id'];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

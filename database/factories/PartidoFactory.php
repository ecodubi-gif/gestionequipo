<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PartidoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'equipo_local' => $this->faker->city(),
            'equipo_visitante' => $this->faker->city(),
            'fecha' => now()->addWeek(),
            'lugar' => 'Campo Municipal',
            'estado' => 'pendiente',
        ];
    }
}

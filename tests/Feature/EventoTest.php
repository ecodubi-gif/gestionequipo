<?php

namespace Tests\Feature;

use App\Models\Partido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventoTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_entrenador_puede_registrar_un_gol_en_un_partido(): void
    {
        $entrenador = User::factory()->create(['role' => 'entrenador']);
        $partido = Partido::factory()->create(['user_id' => $entrenador->id]);
        Sanctum::actingAs($entrenador);

        $response = $this->postJson("/api/partidos/{$partido->id}/eventos", [
            'tipo' => 'tiro',
            'equipo' => 'local',
            'minuto' => 23,
            'resultado' => 'gol',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('eventos', [
            'partido_id' => $partido->id,
            'tipo' => 'tiro',
            'resultado' => 'gol',
        ]);
    }

    public function test_un_delegado_no_puede_registrar_eventos(): void
    {
        $entrenador = User::factory()->create(['role' => 'entrenador']);
        $partido = Partido::factory()->create(['user_id' => $entrenador->id]);

        $delegado = User::factory()->create(['role' => 'delegado']);
        Sanctum::actingAs($delegado);

        $response = $this->postJson("/api/partidos/{$partido->id}/eventos", [
            'tipo' => 'tiro',
            'equipo' => 'local',
            'minuto' => 23,
            'resultado' => 'gol',
        ]);

        $response->assertStatus(403);
    }
}

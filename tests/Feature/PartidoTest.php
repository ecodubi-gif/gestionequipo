<?php

namespace Tests\Feature;

use App\Models\Partido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PartidoTest extends TestCase
{
    use RefreshDatabase;

    private function datosPartido(): array
    {
        return [
            'equipo_local' => 'Mi Equipo',
            'equipo_visitante' => 'Rival CF',
            'fecha' => '2026-10-10 18:00:00',
            'lugar' => 'Campo Municipal',
        ];
    }

    public function test_un_entrenador_puede_crear_un_partido(): void
    {
        $entrenador = User::factory()->create(['role' => 'entrenador']);
        Sanctum::actingAs($entrenador);

        $response = $this->postJson('/api/partidos', $this->datosPartido());

        $response->assertStatus(201);
        $this->assertDatabaseHas('partidos', ['equipo_local' => 'Mi Equipo']);
    }

    public function test_un_preparador_fisico_no_puede_crear_un_partido(): void
    {
        $preparador = User::factory()->create(['role' => 'preparador_fisico']);
        Sanctum::actingAs($preparador);

        $response = $this->postJson('/api/partidos', $this->datosPartido());

        $response->assertStatus(403);
        $this->assertDatabaseMissing('partidos', ['equipo_local' => 'Mi Equipo']);
    }

    public function test_un_usuario_sin_autenticar_no_puede_ver_partidos(): void
    {
        $response = $this->getJson('/api/partidos');
        $response->assertStatus(401);
    }

    public function test_el_delegado_si_puede_ver_partidos_aunque_no_pueda_crearlos(): void
    {
        $entrenador = User::factory()->create(['role' => 'entrenador']);
        Partido::factory()->create([
            'user_id' => $entrenador->id,
            ...$this->datosPartido(),
        ]);

        $delegado = User::factory()->create(['role' => 'delegado']);
        Sanctum::actingAs($delegado);

        $response = $this->getJson('/api/partidos');
        $response->assertStatus(200)->assertJsonCount(1, 'data');
    }
}

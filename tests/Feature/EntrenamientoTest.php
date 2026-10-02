<?php

namespace Tests\Feature;

use App\Models\Entrenamiento;
use App\Models\Jugador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EntrenamientoTest extends TestCase
{
    use RefreshDatabase;

    private function datosEntrenamiento(): array
    {
        return ['fecha' => '2026-10-10', 'hora' => '19:30', 'lugar' => 'Campo Anexo'];
    }

    public function test_un_delegado_puede_crear_un_entrenamiento(): void
    {
        $delegado = User::factory()->create(['role' => 'delegado']);
        Sanctum::actingAs($delegado);

        $response = $this->postJson('/api/entrenamientos', $this->datosEntrenamiento());

        $response->assertStatus(201);
        $this->assertDatabaseHas('entrenamientos', ['lugar' => 'Campo Anexo']);
    }

    public function test_un_preparador_fisico_no_puede_crear_un_entrenamiento(): void
    {
        $preparador = User::factory()->create(['role' => 'preparador_fisico']);
        Sanctum::actingAs($preparador);

        $response = $this->postJson('/api/entrenamientos', $this->datosEntrenamiento());

        $response->assertStatus(403);
    }

    public function test_el_delegado_puede_guardar_asistencia_con_multa(): void
    {
        $delegado = User::factory()->create(['role' => 'delegado']);
        $entrenamiento = Entrenamiento::create([...$this->datosEntrenamiento(), 'user_id' => $delegado->id]);
        $jugador = Jugador::create(['nombre' => 'Juan', 'apellidos' => 'Pérez']);
        Sanctum::actingAs($delegado);

        $response = $this->postJson("/api/entrenamientos/{$entrenamiento->id}/asistencias", [
            'asistencias' => [
                ['jugador_id' => $jugador->id, 'estado' => 'retraso', 'multa' => 5, 'motivo' => 'Llegó 10 min tarde'],
            ],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('asistencias', ['jugador_id' => $jugador->id, 'estado' => 'retraso', 'multa' => 5]);
    }
}

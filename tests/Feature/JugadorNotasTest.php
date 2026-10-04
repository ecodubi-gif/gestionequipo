<?php

namespace Tests\Feature;

use App\Models\Jugador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class JugadorNotasTest extends TestCase
{
    use RefreshDatabase;

    private function jugador(): Jugador
    {
        return Jugador::create(['nombre' => 'Juan', 'apellidos' => 'Pérez']);
    }

    private function entrarComo(string $rol): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => $rol]));
    }

    public function test_el_preparador_fisico_puede_poner_a_un_jugador_en_readaptacion(): void
    {
        $this->entrarComo('preparador_fisico');
        $jugador = $this->jugador();

        $this->putJson("/api/jugadores/{$jugador->id}/readaptacion", ['readaptacion' => 'Isquios: sin series'])
            ->assertOk()
            ->assertJsonPath('data.readaptacion', 'Isquios: sin series');

        $this->assertDatabaseHas('jugadores', ['id' => $jugador->id, 'readaptacion' => 'Isquios: sin series']);
    }

    public function test_se_puede_quitar_la_readaptacion_enviando_null(): void
    {
        $this->entrarComo('preparador_fisico');
        $jugador = $this->jugador();
        $jugador->forceFill(['readaptacion' => 'algo'])->save();

        $this->putJson("/api/jugadores/{$jugador->id}/readaptacion", ['readaptacion' => null])->assertOk();

        $this->assertDatabaseHas('jugadores', ['id' => $jugador->id, 'readaptacion' => null]);
    }

    public function test_el_entrenador_no_puede_tocar_la_readaptacion(): void
    {
        $this->entrarComo('entrenador');
        $jugador = $this->jugador();

        $this->putJson("/api/jugadores/{$jugador->id}/readaptacion", ['readaptacion' => 'x'])->assertStatus(403);
    }

    public function test_el_entrenador_si_puede_poner_observaciones(): void
    {
        $this->entrarComo('entrenador');
        $jugador = $this->jugador();

        $this->putJson("/api/jugadores/{$jugador->id}/observaciones", ['observaciones' => 'Comodín'])
            ->assertOk()
            ->assertJsonPath('data.observaciones', 'Comodín');
    }

    public function test_el_delegado_no_puede_poner_observaciones(): void
    {
        $this->entrarComo('delegado');
        $jugador = $this->jugador();

        $this->putJson("/api/jugadores/{$jugador->id}/observaciones", ['observaciones' => 'x'])->assertStatus(403);
    }
}

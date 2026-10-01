<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_usuario_puede_iniciar_sesion_con_credenciales_correctas(): void
    {
        User::factory()->create([
            'email' => 'entrenador@test.com',
            'password' => bcrypt('password123'),
            'role' => 'entrenador',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'entrenador@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user' => ['id', 'name', 'email', 'role'], 'token']);
    }

    public function test_el_login_falla_con_contrasena_incorrecta(): void
    {
        User::factory()->create([
            'email' => 'entrenador@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'entrenador@test.com',
            'password' => 'otra-cosa',
        ]);

        $response->assertStatus(401);
    }
}

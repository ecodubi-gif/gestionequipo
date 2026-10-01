<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrador',
                'email' => 'admin@estpartido.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Delegado Principal',
                'email' => 'delegado@estpartido.com',
                'password' => Hash::make('password'),
                'role' => 'delegado'
            ],
            [
                'name' => 'Primer Entrenador',
                'email' => 'entrenador@estpartido.com',
                'password' => Hash::make('password'),
                'role' => 'entrenador'
            ],
            [
                'name' => 'Segundo Entrenador',
                'email' => 'segundo@estpartido.com',
                'password' => Hash::make('password'),
                'role' => 'segundo_entrenador'
            ],
            [
                'name' => 'Preparador Físico',
                'email' => 'pfisico@estpartido.com',
                'password' => Hash::make('password'),
                'role' => 'preparador_fisico'
            ],
            [
                'name' => 'Usuario Invitado',
                'email' => 'user@estpartido.com',
                'password' => Hash::make('password'),
                'role' => 'user'
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}

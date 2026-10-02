<?php

namespace App\Policies;

use App\Models\Jugador;
use App\Models\User;

class JugadorPolicy
{
    private const ROLES_GESTION = ['delegado'];

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Jugador $jugador): bool { return true; }
    public function create(User $user): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function update(User $user, Jugador $jugador): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function delete(User $user, Jugador $jugador): bool { return in_array($user->role, self::ROLES_GESTION, true); }
}

<?php

namespace App\Policies;

use App\Models\Partido;
use App\Models\User;

class PartidoPolicy
{
    private const ROLES_GESTION = ['entrenador', 'segundo_entrenador'];

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Partido $partido): bool { return true; }
    public function create(User $user): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function update(User $user, Partido $partido): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function delete(User $user, Partido $partido): bool { return in_array($user->role, self::ROLES_GESTION, true); }
}

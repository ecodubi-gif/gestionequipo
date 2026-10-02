<?php

namespace App\Policies;

use App\Models\Entrenamiento;
use App\Models\User;

class EntrenamientoPolicy
{
    private const ROLES_GESTION = ['entrenador', 'segundo_entrenador'];
    private const ROLES_MATERIAL = ['entrenador', 'segundo_entrenador', 'preparador_fisico'];
    private const ROLES_ASISTENCIA = ['entrenador', 'segundo_entrenador', 'delegado'];

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Entrenamiento $entrenamiento): bool { return true; }
    public function create(User $user): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function update(User $user, Entrenamiento $entrenamiento): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function delete(User $user, Entrenamiento $entrenamiento): bool { return in_array($user->role, self::ROLES_GESTION, true); }

    public function editarMaterial(User $user, Entrenamiento $entrenamiento): bool
    {
        return in_array($user->role, self::ROLES_MATERIAL, true);
    }

    public function gestionarAsistencia(User $user, Entrenamiento $entrenamiento): bool
    {
        return in_array($user->role, self::ROLES_ASISTENCIA, true);
    }
}

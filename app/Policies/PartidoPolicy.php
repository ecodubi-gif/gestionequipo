<?php

namespace App\Policies;

use App\Models\Partido;
use App\Models\User;

class PartidoPolicy
{
    // Crear/editar los datos del partido (equipos, fecha, campo) y
    // decidir la convocatoria: entrenador y segundo entrenador.
    private const ROLES_GESTION = ['entrenador', 'segundo_entrenador'];

    // Registrar lo que pasa en directo (empezar, goles, tarjetas,
    // cambios, finalizar): el delegado. El entrenador está dirigiendo
    // el partido, no puede estar a la vez metido en el móvil.
    private const ROLES_DIRECTO = ['delegado'];

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Partido $partido): bool { return true; }
    public function create(User $user): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function delete(User $user, Partido $partido): bool { return in_array($user->role, self::ROLES_GESTION, true); }

    // Los datos básicos del partido los puede tocar quien gestiona
    // (equipos/fecha/campo) y también el delegado (porque el estado y
    // el resultado se actualizan desde el directo).
    public function update(User $user, Partido $partido): bool
    {
        return in_array($user->role, [...self::ROLES_GESTION, ...self::ROLES_DIRECTO], true);
    }

    public function gestionarConvocatoria(User $user, Partido $partido): bool
    {
        return in_array($user->role, self::ROLES_GESTION, true);
    }

    public function gestionarEnVivo(User $user, Partido $partido): bool
    {
        return in_array($user->role, self::ROLES_DIRECTO, true);
    }
}

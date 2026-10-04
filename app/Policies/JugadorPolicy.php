<?php

namespace App\Policies;

use App\Models\Jugador;
use App\Models\User;

/**
 * - Alta, edición y baja de jugadores (la plantilla): el delegado.
 * - Readaptación (vuelta tras lesión): solo el preparador físico.
 * - Observaciones (comodín, "no hacer series"...): cuerpo técnico
 *   (entrenador, segundo entrenador y preparador físico).
 * Todos los roles pueden consultar.
 */
class JugadorPolicy
{
    private const ROLES_GESTION = ['delegado'];
    private const ROLES_READAPTACION = ['preparador_fisico'];
    private const ROLES_OBSERVACIONES = ['entrenador', 'segundo_entrenador', 'preparador_fisico'];

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Jugador $jugador): bool { return true; }
    public function create(User $user): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function update(User $user, Jugador $jugador): bool { return in_array($user->role, self::ROLES_GESTION, true); }
    public function delete(User $user, Jugador $jugador): bool { return in_array($user->role, self::ROLES_GESTION, true); }

    public function editarReadaptacion(User $user, Jugador $jugador): bool
    {
        return in_array($user->role, self::ROLES_READAPTACION, true);
    }

    public function editarObservaciones(User $user, Jugador $jugador): bool
    {
        return in_array($user->role, self::ROLES_OBSERVACIONES, true);
    }
}

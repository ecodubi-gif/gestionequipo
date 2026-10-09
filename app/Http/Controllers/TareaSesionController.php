<?php

namespace App\Http\Controllers;

use App\Models\Entrenamiento;
use App\Models\TareaSesion;
use Illuminate\Http\Request;

/**
 * Tareas de la sesión.
 * - Crear, editar y borrar: entrenador y segundo entrenador.
 * - Consultar: cuerpo técnico (entrenador, segundo y preparador físico). El delegado no.
 */
class TareaSesionController extends Controller
{
    private const ROLES_EDITAR = ['entrenador', 'segundo_entrenador'];
    private const ROLES_VER = ['entrenador', 'segundo_entrenador', 'preparador_fisico'];

    private function exigir(Request $request, array $roles): void
    {
        abort_unless(in_array($request->user()->role, $roles, true), 403, 'No tienes permiso para hacer esto.');
    }

    private function formato(TareaSesion $t): array
    {
        return [
            'id' => $t->id,
            'entrenamiento_id' => $t->entrenamiento_id,
            'bloque' => $t->bloque,
            'nombre' => $t->nombre,
            'objetivo' => $t->objetivo,
            'referencia' => $t->referencia,
            'n_ataque' => $t->n_ataque,
            'n_defensa' => $t->n_defensa,
            'n_comodines' => $t->n_comodines,
            'n_porteros' => $t->n_porteros,
            'largo' => $t->largo,
            'ancho' => $t->ancho,
            'series' => $t->series,
            'duracion_min' => $t->duracion_min,
            'pausa_seg' => $t->pausa_seg,
            'descripcion' => $t->descripcion,
            'jugadores' => $t->jugadores ?? [],
        ];
    }

    private function validar(Request $request): array
    {
        $datos = $request->validate([
            'bloque' => 'required|in:rueda_perfiles,activacion,parte_central,cierre_tactico',
            'nombre' => 'required|string|max:120',
            'objetivo' => 'nullable|in:recuperacion,compensacion,fuerza,puesta_a_punto',
            'referencia' => 'required|in:porterias,miniporterias,sin_referencia',
            'n_ataque' => 'required|integer|min:0|max:20',
            'n_defensa' => 'required|integer|min:0|max:20',
            'n_comodines' => 'required|integer|min:0|max:20',
            'n_porteros' => 'required|integer|min:0|max:4',
            'largo' => 'nullable|integer|min:5|max:110',
            'ancho' => 'nullable|integer|min:5|max:75',
            'series' => 'required|integer|min:1|max:20',
            'duracion_min' => 'nullable|integer|min:1|max:60',
            'pausa_seg' => 'nullable|integer|min:0|max:600',
            'descripcion' => 'nullable|string|max:2000',
            'jugadores' => 'nullable|array|max:40',
            'jugadores.*.jugador_id' => 'required|integer|exists:jugadores,id',
            'jugadores.*.rol' => 'required|in:ataque,defensa,comodin,portero',
        ]);

        $ids = array_column($datos['jugadores'] ?? [], 'jugador_id');
        abort_if(count($ids) !== count(array_unique($ids)), 422, 'Un jugador no puede estar dos veces en la misma tarea.');

        $datos['jugadores'] = array_values($datos['jugadores'] ?? []);

        return $datos;
    }

    public function index(Request $request, Entrenamiento $entrenamiento)
    {
        $this->exigir($request, self::ROLES_VER);

        return response()->json([
            'data' => TareaSesion::where('entrenamiento_id', $entrenamiento->id)->orderBy('id')->get()
                ->map(fn ($t) => $this->formato($t))->values(),
        ]);
    }

    public function store(Request $request, Entrenamiento $entrenamiento)
    {
        $this->exigir($request, self::ROLES_EDITAR);

        $tarea = TareaSesion::create(array_merge($this->validar($request), ['entrenamiento_id' => $entrenamiento->id]));

        return response()->json(['data' => $this->formato($tarea)], 201);
    }

    public function update(Request $request, TareaSesion $tarea)
    {
        $this->exigir($request, self::ROLES_EDITAR);

        $tarea->fill($this->validar($request))->save();

        return response()->json(['data' => $this->formato($tarea)]);
    }

    public function destroy(Request $request, TareaSesion $tarea)
    {
        $this->exigir($request, self::ROLES_EDITAR);

        $tarea->delete();

        return response()->noContent();
    }
}

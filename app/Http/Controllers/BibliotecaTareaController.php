<?php

namespace App\Http\Controllers;

use App\Models\BibliotecaTarea;
use Illuminate\Http\Request;

/**
 * Biblioteca de tareas.
 * - Consultar: entrenador, segundo y preparador físico.
 * - Guardar, cambiar y borrar: entrenador y segundo.
 */
class BibliotecaTareaController extends Controller
{
    private const ROLES_EDITAR = ['entrenador', 'segundo_entrenador'];
    private const ROLES_VER = ['entrenador', 'segundo_entrenador', 'preparador_fisico'];

    private function exigir(Request $request, array $roles): void
    {
        abort_unless(in_array($request->user()->role, $roles, true), 403, 'No tienes permiso para hacer esto.');
    }

    private function formato(BibliotecaTarea $t): array
    {
        return [
            'id' => $t->id,
            'nombre' => $t->nombre,
            'bloque' => $t->bloque,
            'objetivo' => $t->objetivo,
            'referencia' => $t->referencia,
            'n_ataque' => $t->n_ataque,
            'n_defensa' => $t->n_defensa,
            'n_comodines' => $t->n_comodines,
            'n_porteros' => $t->n_porteros,
            'largo' => $t->largo,
            'ancho' => $t->ancho,
            'series' => $t->series,
            'duracion_seg' => $t->duracion_seg,
            'pausa_seg' => $t->pausa_seg,
            'descripcion' => $t->descripcion,
        ];
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre' => 'required|string|max:120',
            'bloque' => 'nullable|in:rueda_perfiles,activacion,parte_central,cierre_tactico',
            'objetivo' => 'nullable|in:recuperacion,compensacion,fuerza,puesta_a_punto',
            'referencia' => 'required|in:porterias,miniporterias,sin_referencia',
            'n_ataque' => 'required|integer|min:0|max:20',
            'n_defensa' => 'required|integer|min:0|max:20',
            'n_comodines' => 'required|integer|min:0|max:20',
            'n_porteros' => 'required|integer|min:0|max:4',
            'largo' => 'nullable|integer|min:5|max:110',
            'ancho' => 'nullable|integer|min:5|max:75',
            'series' => 'required|integer|min:1|max:20',
            'duracion_seg' => 'nullable|integer|min:5|max:3600',
            'pausa_seg' => 'nullable|integer|min:0|max:600',
            'descripcion' => 'nullable|string|max:2000',
        ]);
    }

    public function index(Request $request)
    {
        $this->exigir($request, self::ROLES_VER);

        return response()->json([
            'data' => BibliotecaTarea::orderBy('nombre')->get()->map(fn ($t) => $this->formato($t))->values(),
        ]);
    }

    public function store(Request $request)
    {
        $this->exigir($request, self::ROLES_EDITAR);

        return response()->json(['data' => $this->formato(BibliotecaTarea::create($this->validar($request)))], 201);
    }

    public function update(Request $request, BibliotecaTarea $tarea)
    {
        $this->exigir($request, self::ROLES_EDITAR);

        $tarea->fill($this->validar($request))->save();

        return response()->json(['data' => $this->formato($tarea)]);
    }

    public function destroy(Request $request, BibliotecaTarea $tarea)
    {
        $this->exigir($request, self::ROLES_EDITAR);

        $tarea->delete();

        return response()->noContent();
    }
}

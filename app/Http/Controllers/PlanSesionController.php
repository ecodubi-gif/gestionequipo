<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntrenamientoResource;
use App\Models\Entrenamiento;
use App\Models\PlantillaEntreno;
use Illuminate\Http\Request;

/**
 * Plan de la sesión.
 * - Preventivo y movilidad (por tipo de entreno): solo el preparador físico.
 * - Bloques del entrenador (rueda de perfiles, activación, parte central y
 *   cierre táctico) de cada sesión: entrenador y segundo entrenador.
 * - Tipo de entreno de una sesión (1, 2 o 3): entrenador, segundo y preparador físico.
 * Todos los roles pueden consultarlo.
 */
class PlanSesionController extends Controller
{
    private function exigirRol(Request $request, array $roles): void
    {
        abort_unless(in_array($request->user()->role, $roles, true), 403, 'No tienes permiso para hacer esto.');
    }

    private function formato(PlantillaEntreno $p): array
    {
        return [
            'numero' => $p->numero,
            'preventivo' => $p->preventivo,
            'movilidad' => $p->movilidad,
        ];
    }

    public function plantillas()
    {
        return response()->json([
            'data' => PlantillaEntreno::orderBy('numero')->get()->map(fn ($p) => $this->formato($p))->values(),
        ]);
    }

    public function actualizarPlantilla(Request $request, int $numero)
    {
        $this->exigirRol($request, ['preparador_fisico']);

        $datos = $request->validate([
            'preventivo' => 'sometimes|array|min:1|max:8',
            'preventivo.*.zona' => 'required|string|max:160',
            'preventivo.*.ejercicio' => 'required|string|max:1500',
            'preventivo.*.series' => 'nullable|string|max:40',
            'preventivo.*.detalle' => 'nullable|string|max:160',
            'movilidad' => 'sometimes|array|min:1|max:10',
            'movilidad.*.tiempo' => 'required|string|max:20',
            'movilidad.*.zona' => 'required|string|max:160',
            'movilidad.*.descripcion' => 'required|string|max:1500',
        ]);

        $plantilla = PlantillaEntreno::where('numero', $numero)->firstOrFail();
        if (array_key_exists('preventivo', $datos)) {
            $plantilla->preventivo = array_values($datos['preventivo']);
        }
        if (array_key_exists('movilidad', $datos)) {
            $plantilla->movilidad = array_values($datos['movilidad']);
        }
        $plantilla->save();

        return response()->json(['data' => $this->formato($plantilla)]);
    }

    public function actualizarBloques(Request $request, Entrenamiento $entrenamiento)
    {
        $this->exigirRol($request, ['entrenador', 'segundo_entrenador']);

        $datos = $request->validate([
            'bloques' => 'required|array',
            'bloques.rueda_perfiles' => 'nullable|string|max:1500',
            'bloques.activacion' => 'nullable|string|max:1500',
            'bloques.activacion_activa' => 'nullable|boolean',
            'bloques.parte_central' => 'nullable|string|max:1500',
            'bloques.cierre_tactico' => 'nullable|string|max:1500',
        ]);

        // Se mezcla con lo que ya había: se puede guardar un bloque cada vez.
        $actuales = $entrenamiento->bloques ? (json_decode($entrenamiento->bloques, true) ?: []) : [];
        $entrenamiento->bloques = json_encode(array_merge($actuales, $datos['bloques']), JSON_UNESCAPED_UNICODE);
        $entrenamiento->save();

        return new EntrenamientoResource($entrenamiento);
    }

    public function actualizarTipo(Request $request, Entrenamiento $entrenamiento)
    {
        $this->exigirRol($request, ['entrenador', 'segundo_entrenador', 'preparador_fisico']);

        $request->validate(['tipo_sesion' => 'nullable|integer|in:1,2,3']);

        $entrenamiento->tipo_sesion = $request->input('tipo_sesion');
        $entrenamiento->save();

        return new EntrenamientoResource($entrenamiento);
    }
}

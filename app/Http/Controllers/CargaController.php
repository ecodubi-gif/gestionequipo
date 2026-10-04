<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntrenamientoResource;
use App\Models\Entrenamiento;
use App\Models\Partido;
use App\Models\RpePartido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Carga de entrenamiento (RPE).
 * - Duración y RPE medio de cada entreno, y el RPE de cada jugador en el partido:
 *   solo el preparador físico.
 * - Consultar: todos los roles.
 */
class CargaController extends Controller
{
    private function exigirPreparador(Request $request): void
    {
        abort_unless($request->user()->role === 'preparador_fisico', 403, 'Solo el preparador físico puede registrar la carga.');
    }

    public function actualizarCarga(Request $request, Entrenamiento $entrenamiento)
    {
        $this->exigirPreparador($request);

        $request->validate([
            'duracion_minutos' => 'nullable|integer|min:1|max:300|required_with:rpe_medio',
            'rpe_medio' => 'nullable|numeric|min:0.5|max:10|required_with:duracion_minutos',
        ]);

        $entrenamiento->duracion_minutos = $request->input('duracion_minutos');
        $entrenamiento->rpe_medio = $request->input('rpe_medio');
        $entrenamiento->save();

        return new EntrenamientoResource($entrenamiento);
    }

    private function formatoRpe($filas): array
    {
        return $filas->map(fn ($r) => [
            'jugador_id' => $r->jugador_id,
            'rpe' => (float) $r->rpe,
            'minutos' => (int) $r->minutos,
        ])->values()->all();
    }

    public function rpePartido(Partido $partido)
    {
        return response()->json(['data' => $this->formatoRpe(RpePartido::where('partido_id', $partido->id)->get())]);
    }

    public function guardarRpePartido(Request $request, Partido $partido)
    {
        $this->exigirPreparador($request);
        abort_unless($partido->estado === 'finalizado', 422, 'El partido todavía no ha terminado.');

        $datos = $request->validate([
            'rpes' => 'required|array|min:1|max:40',
            'rpes.*.jugador_id' => 'required|integer|exists:jugadores,id',
            'rpes.*.rpe' => 'required|numeric|min:0.5|max:10',
            'rpes.*.minutos' => 'required|integer|min:1|max:200',
        ]);

        DB::transaction(function () use ($partido, $datos) {
            $ids = [];
            foreach ($datos['rpes'] as $fila) {
                RpePartido::updateOrCreate(
                    ['partido_id' => $partido->id, 'jugador_id' => $fila['jugador_id']],
                    ['rpe' => $fila['rpe'], 'minutos' => $fila['minutos']]
                );
                $ids[] = $fila['jugador_id'];
            }
            // Lo guardado es siempre lo último enviado: quien ya no está, se quita.
            RpePartido::where('partido_id', $partido->id)->whereNotIn('jugador_id', $ids)->delete();
        });

        return response()->json(['data' => $this->formatoRpe(RpePartido::where('partido_id', $partido->id)->get())]);
    }

    /**
     * Datos de varias semanas (de lunes a domingo) para calcular la carga y el riesgo:
     * entrenos con su carga y quién asistió, y partidos con el RPE de cada jugador.
     * El cálculo en sí lo hace la app; aquí solo se reúnen los datos.
     */
    public function semanas(Request $request)
    {
        $datos = $request->validate([
            'lunes' => 'required|date_format:Y-m-d',
            'semanas' => 'nullable|integer|min:1|max:12',
        ]);
        $n = (int) ($datos['semanas'] ?? 6);

        $ultimoLunes = Carbon::createFromFormat('Y-m-d', $datos['lunes'])->startOfWeek(Carbon::MONDAY)->startOfDay();
        $primerLunes = $ultimoLunes->copy()->subWeeks($n - 1);
        $desde = $primerLunes->toDateString();
        $hasta = $ultimoLunes->copy()->addDays(6)->toDateString();

        $entrenos = Entrenamiento::whereBetween('fecha', [$desde, $hasta])->orderBy('fecha')->orderBy('hora')->get();
        $asistentes = DB::table('asistencias')
            ->whereIn('entrenamiento_id', $entrenos->pluck('id')->all())
            ->whereIn('estado', ['presente', 'retraso'])
            ->get(['entrenamiento_id', 'jugador_id'])
            ->groupBy('entrenamiento_id');

        $partidos = Partido::whereBetween('fecha', [$primerLunes->copy()->startOfDay(), $ultimoLunes->copy()->addDays(6)->endOfDay()])
            ->orderBy('fecha')->get();
        $rpes = RpePartido::whereIn('partido_id', $partidos->pluck('id')->all())->get()->groupBy('partido_id');

        $dia = fn ($fecha) => substr((string) $fecha, 0, 10);
        $semanas = [];
        for ($i = 0; $i < $n; $i++) {
            $lunes = $primerLunes->copy()->addWeeks($i)->toDateString();
            $domingo = $primerLunes->copy()->addWeeks($i)->addDays(6)->toDateString();

            $semanas[] = [
                'lunes' => $lunes,
                'entrenamientos' => $entrenos
                    ->filter(fn ($e) => $dia($e->fecha) >= $lunes && $dia($e->fecha) <= $domingo)
                    ->map(fn ($e) => [
                        'id' => $e->id,
                        'fecha' => $dia($e->fecha),
                        'hora' => $e->hora,
                        'tipo_sesion' => $e->tipo_sesion,
                        'duracion_minutos' => $e->duracion_minutos,
                        'rpe_medio' => $e->rpe_medio !== null ? (float) $e->rpe_medio : null,
                        'asistentes' => ($asistentes[$e->id] ?? collect())->pluck('jugador_id')->values()->all(),
                    ])->values()->all(),
                'partidos' => $partidos
                    ->filter(fn ($p) => $p->fecha->toDateString() >= $lunes && $p->fecha->toDateString() <= $domingo)
                    ->map(fn ($p) => [
                        'id' => $p->id,
                        'fecha' => $p->fecha->toIso8601String(),
                        'estado' => $p->estado,
                        'equipo_local' => $p->equipo_local,
                        'equipo_visitante' => $p->equipo_visitante,
                        'actualizado_en' => $p->updated_at ? $p->updated_at->toIso8601String() : null,
                        'rpe' => $this->formatoRpe($rpes[$p->id] ?? collect()),
                    ])->values()->all(),
            ];
        }

        return response()->json(['data' => ['semanas' => $semanas]]);
    }
}

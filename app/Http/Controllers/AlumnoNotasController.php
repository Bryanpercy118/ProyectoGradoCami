<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asignacion;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Periodo;
use Illuminate\Support\Facades\Auth;

class AlumnoNotasController extends Controller
{
    public function index()
    {
        $alumnoId = Auth::id();
        $year     = now()->year;

        // Matrícula activa del alumno (con salón)
        $matricula = Matricula::with('salon:id,nombre,grado,seccion')
            ->where('alumno_user_id', $alumnoId)
            ->where('year', $year)
            ->where('estado', 'matriculado')
            ->firstOrFail();

        // Periodos (ordenados)
        $periodos = Periodo::orderBy('fecha_inicio')->get();

        // Materias (subjects) que cursa el salón en este año (por asignaciones)
        $subjects = Asignacion::with('subject:id,nombre')
            ->where('salon_id', $matricula->salon_id)
            ->where('year', $year)
            ->get()
            ->pluck('subject')      // colección de Subject
            ->unique('id')          // evitar repetidos si hay varios docentes por error
            ->values();

        // Notas del alumno en esos subjects y periodos del año
        $notas = Nota::where('estudiante_id', $alumnoId)
            ->where('year', $year)
            ->whereIn('subject_id', $subjects->pluck('id'))
            ->whereIn('periodo_id', $periodos->pluck('id'))
            ->get(['subject_id','periodo_id','nota']);

        // Mapa [subject_id][periodo_id] => nota
        $notasMap = [];
        foreach ($notas as $n) {
            $notasMap[$n->subject_id][$n->periodo_id] = (float) $n->nota;
        }

        // Promedio por materia (solo con periodos que tengan nota)
        $promedios = [];
        foreach ($subjects as $s) {
            $vals = [];
            foreach ($periodos as $p) {
                if (isset($notasMap[$s->id][$p->id])) {
                    $vals[] = $notasMap[$s->id][$p->id];
                }
            }
            $promedios[$s->id] = count($vals) ? round(array_sum($vals) / count($vals), 2) : null;
        }

        // Periodo “en curso” (útil para resaltar columna)
        $hoy = now();
        $periodoActualId = optional(
            $periodos->first(fn ($p) => $hoy->between($p->fecha_inicio, $p->fecha_fin))
        )->id;

        return view('pages.alumno.notas.index', [
            'year'            => $year,
            'matricula'       => $matricula,
            'periodos'        => $periodos,
            'subjects'        => $subjects,
            'notasMap'        => $notasMap,
            'promedios'       => $promedios,
            'periodoActualId' => $periodoActualId,
        ]);
    }
}

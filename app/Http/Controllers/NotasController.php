<?php
// app/Http/Controllers/Docente/NotasController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asignacion;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Salon;
use App\Models\Subject;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotasController extends Controller
{
    // Paso 1: selección de asignación y periodo
    public function index()
    {
        $year = now()->year;

        // Asignaciones del docente este año
        $asignaciones = Asignacion::with(['subject:id,nombre','salon:id,nombre,grado,seccion'])
            ->where('teacher_id', Auth::id())
            ->where('year', $year)
            ->orderBy('salon_id')
            ->get();

        // Periodos visibles (pueden estar abiertos o cerrados)
        $periodos = Periodo::orderBy('fecha_inicio')->get();

        return view('pages.docente.notas.index', compact('year','asignaciones','periodos'));
    }

    // Paso 2: vista de carga de notas
    // public function cargar(Request $request)
    // {
    //     $request->validate([
    //         'asignacion_id' => 'required|exists:asignaciones,id',
    //         'periodo_id'    => 'required|exists:periodos,id',
    //     ]);

    //     $year = now()->year;

    //     $asignacion = Asignacion::with(['subject:id,nombre','salon:id,nombre,grado,seccion'])
    //         ->where('id', $request->asignacion_id)
    //         ->where('teacher_id', Auth::id())
    //         ->where('year', $year)
    //         ->firstOrFail();

    //     $periodo = Periodo::findOrFail($request->periodo_id);

    //     // Estado de ventana
    //     $hoy = now();
    //     $abierto = ($periodo->permite_calificar ?? false) || ($hoy->between($periodo->fecha_inicio, $periodo->fecha_fin));

    //     return view('pages.docente.notas.cargar', compact('year','asignacion','periodo','abierto'));
    // }

    // Datos JSON: alumnos del salón + notas existentes para esa asignación/periodo
    public function data(Request $request)
    {
        $request->validate([
            'asignacion_id' => 'required|exists:asignaciones,id',
            'periodo_id'    => 'required|exists:periodos,id',
        ]);

        $asignacion = Asignacion::where('id', $request->asignacion_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $periodo = Periodo::findOrFail($request->periodo_id);

        // alumnos matriculados en ese salón y año
        $alumnos = Matricula::with(['alumno:id,name,email'])
            ->where('salon_id', $asignacion->salon_id)
            ->where('year', $asignacion->year)
            ->where('estado', 'matriculado')
            ->get()
            ->map(function ($m) {
                return [
                    'estudiante_id' => $m->alumno_user_id,
                    'nombre'        => $m->alumno->name,
                    'email'         => $m->alumno->email,
                ];
            });

        // notas existentes indexadas por estudiante_id
        $notas = Nota::where('periodo_id', $request->periodo_id)
            ->where('subject_id', $asignacion->subject_id)
            ->whereIn('estudiante_id', $alumnos->pluck('estudiante_id'))
            ->get()
            ->keyBy('estudiante_id')
            ->map(function ($n) {
                return [
                    'nota_id' => $n->id,
                    'nota'    => (float) $n->nota,
                ];
            });

        // info de ventana
        $hoy = now();
        $abierto = ($periodo->permite_calificar ?? false) || ($hoy->between($periodo->fecha_inicio, $periodo->fecha_fin));

        return response()->json([
            'abierto'       => $abierto,
            'alumnos'       => $alumnos->values(),
            'notas'         => $notas,
            'escala'        => ['min' => 0, 'max' => 5, 'step' => 0.1], // ajusta a tu escala
        ]);
    }

    
public function cargar(Request $request)
{
    $request->validate([
        'asignacion_id' => 'required|exists:asignaciones,id',
        'periodo_id'    => 'required|exists:periodos,id',
    ]);

    $year = now()->year;

    $asignacion = \App\Models\Asignacion::with([
            'salon:id,nombre,grado,seccion',
            'subject:id,nombre',
        ])
        ->where('id', $request->asignacion_id)
        ->where('teacher_id', auth()->id())
        ->where('year', $year)
        ->firstOrFail();

    $periodo = \App\Models\Periodo::findOrFail($request->periodo_id);

    $hoy = now();
    $abierto = ($periodo->permite_calificar ?? false) || $hoy->between($periodo->fecha_inicio, $periodo->fecha_fin);

    // ⬇️ Esta vista SÍ espera $asignacion y $periodo
    return view('pages.docente.notas.cargar', compact('year','asignacion','periodo','abierto'));
}


    // Guardado masivo
    public function guardar(Request $request)
    {
        $data = $request->validate([
            'asignacion_id' => 'required|exists:asignaciones,id',
            'periodo_id'    => 'required|exists:periodos,id',
            'items'         => 'required|array',
            'items.*.estudiante_id' => 'required|integer',
            'items.*.nota'          => 'nullable|numeric|min:0|max:5',
        ]);

        $asignacion = \App\Models\Asignacion::where('id', $data['asignacion_id'])
            ->where('teacher_id', auth()->id())
            ->firstOrFail();

        $periodo = \App\Models\Periodo::findOrFail($data['periodo_id']);

        // Ventana
        $hoy = now();
        $abierto = ($periodo->permite_calificar ?? false) || $hoy->between($periodo->fecha_inicio, $periodo->fecha_fin);
        if (!$abierto) {
            return response()->json(['message' => 'El periodo está cerrado. Contacte al administrador.'], 403);
        }

        // Validar que los estudiantes pertenecen al salón/año de la asignación
        $validos = \App\Models\Matricula::where('salon_id', $asignacion->salon_id)
            ->where('year', $asignacion->year)
            ->where('estado', 'matriculado')
            ->whereIn('alumno_user_id', collect($data['items'])->pluck('estudiante_id'))
            ->pluck('alumno_user_id')
            ->all();

        $items = collect($data['items'])->filter(function ($it) use ($validos) {
            return in_array($it['estudiante_id'], $validos) && $it['nota'] !== null && $it['nota'] !== '';
        });

        \DB::transaction(function () use ($items, $asignacion, $periodo) {
            foreach ($items as $it) {
                // 🔒 No sobrescribir: si ya existe, saltar
                $existe = \App\Models\Nota::where('estudiante_id', $it['estudiante_id'])
                    ->where('periodo_id', $periodo->id)
                    ->where('subject_id', $asignacion->subject_id)
                    ->exists();

                if ($existe) {
                    continue;
                }

                \App\Models\Nota::create([
                    'estudiante_id' => $it['estudiante_id'],
                    'docente_id'    => auth()->id(),
                    'periodo_id'    => $periodo->id,
                    'subject_id'    => $asignacion->subject_id,
                    'year'          => $asignacion->year,
                    'nota'          => $it['nota'],
                ]);
            }
        });

        return response()->json(['success' => true]);
    }

}

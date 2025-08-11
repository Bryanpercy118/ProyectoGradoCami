<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $year = now()->year;

        // 1) Ubicar matrícula activa del alumno este año
        $matricula = Matricula::with('salon')
            ->where('alumno_user_id', Auth::id())
            ->where('year', $year)
            ->where('estado', 'matriculado')
            ->first();

        if (!$matricula) {
            // Si no tiene matrícula este año, muestra vista “sin matrícula”
            return view('pages.alumno.dashboard_sin_matricula', compact('year'));
        }

        // 2) Traer asignaciones del salón para el año (materia + docente)
        $asignaciones = Asignacion::with([
                'subject:id,nombre',
                'teacher:id,name,email', // teacher es users.* con rol docente
            ])
            ->where('salon_id', $matricula->salon_id)
            ->where('year', $year)
            ->orderByDesc('id')
            ->get();

        return view('pages.alumno.dashboard', [
            'year'         => $year,
            'matricula'    => $matricula,
            'asignaciones' => $asignaciones,
        ]);
    }
}

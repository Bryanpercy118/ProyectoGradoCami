<?php

namespace App\Http\Controllers;

use App\Models\Aspirante;
use App\Models\Matricula;
use App\Models\PreinscripcionCupo;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::with(['alumno','salon'])
            ->orderByDesc('id')
            ->get();

        return view('pages.matriculas.index', compact('matriculas'));
    }

    // Form para crear matrícula; si viene aspirante_id, prellena datos
    public function create(Request $request)
    {
        $aspirante = null;
        if ($request->has('aspirante_id')) {
            $aspirante = Aspirante::with('salon','preinscripcion')->findOrFail($request->aspirante_id);
        }
        $salones = Salon::orderBy('grado')->orderBy('seccion')->get();
        $year = now()->year;

        return view('pages.matriculas.create', compact('aspirante','salones','year'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_estudiante' => 'required|string',
            'email'             => 'required|email',
            'salon_id'          => 'required|exists:salons,id',
            'year'              => 'required|digits:4',
            'aspirante_id'      => 'nullable|exists:aspirantes,id',
            'preinscripcion_id' => 'nullable|exists:preinscripcions,id',
            'folio'             => 'nullable|string',
            'observaciones'     => 'nullable|string',
        ]);

        $roleAlumno = 'estudiante';

        $matricula = \DB::transaction(function () use ($data, $roleAlumno) {

            // 1) Buscar o crear User (alumno)
            $user = \App\Models\User::where('email', $data['email'])->first();

            if (!$user) {
                // Crear forzando campos no fillable (gender, active)
                $user = new \App\Models\User();
                $user->forceFill([
                    'name'     => $data['nombre_estudiante'],
                    'email'    => $data['email'],
                    'password' => bcrypt('alumno'), // contraseña fija temporal

                    // Campos NOT NULL en tu tabla users
                    'gender'   => 'N',
                    'active'   => 1,
                ])->save();

                // Asignar rol alumno
                if (method_exists($user, 'assignRole')) {
                    $user->assignRole($roleAlumno);
                }
            } else {
                // Asegurar rol alumno
                if (method_exists($user, 'hasRole') && !$user->hasRole($roleAlumno)) {
                    $user->assignRole($roleAlumno);
                }
                // No tocamos password si ya existe
            }

            // 2) Revalidar cupo (si viene desde preinscripción)
            if (!empty($data['preinscripcion_id'])) {
                $totalCuposSalon = \App\Models\PreinscripcionCupo::where('preinscripcion_id', $data['preinscripcion_id'])
                    ->where('salon_id', $data['salon_id'])
                    ->sum('cupo_total');

                if ($totalCuposSalon > 0) {
                    $matriculadosSalon = \App\Models\Matricula::where('year', $data['year'])
                        ->where('salon_id', $data['salon_id'])
                        ->where('estado', 'matriculado')
                        ->count();

                    if ($matriculadosSalon >= $totalCuposSalon) {
                        abort(422, 'No hay cupos disponibles en este salón para este año.');
                    }
                }
            }

            // 3) Crear matrícula
            $matricula = \App\Models\Matricula::create([
                'alumno_user_id'    => $user->id,
                'salon_id'          => $data['salon_id'],
                'year'              => $data['year'],
                'estado'            => 'matriculado',
                'folio'             => $data['folio'] ?? null,
                'observaciones'     => $data['observaciones'] ?? null,
                'aspirante_id'      => $data['aspirante_id'] ?? null,
                'preinscripcion_id' => $data['preinscripcion_id'] ?? null,
            ]);

            return $matricula->load(['alumno','salon']);
        });

        if ($request->ajax()) {
            return response()->json($matricula, 201);
        }

        return redirect()->route('matriculas.show', $matricula->id)
            ->with('success', 'Matrícula creada y alumno habilitado.');
    }



    public function show(Matricula $matricula)
    {
        $matricula->load(['alumno','salon','aspirante','preinscripcion']);
        return view('pages.matriculas.show', compact('matricula'));
    }
}

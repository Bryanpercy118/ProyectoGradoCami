<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Subject;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsignacionController extends Controller
{
    public function index()
    {
        $year = now()->year;

        $asignaciones = Asignacion::with(['teacher','subject','salon'])
            ->orderByDesc('id')
            ->get();

        $docentes = User::role('profesor')->select('id','name','email')->orderBy('name')->get();
        $subjects = Subject::select('id','nombre')->orderBy('nombre')->get();
        $salones  = Salon::select('id','nombre','grado','seccion')->orderBy('grado')->orderBy('seccion')->get();

        return view('pages/asignaciones.index', compact('asignaciones','docentes','subjects','salones','year'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => ['required','exists:users,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'salon_id'   => ['required','exists:salons,id'],
            'year'       => [
                'required','integer','min:2000','max:2100',
                Rule::unique('asignaciones')->where(fn($q) => $q
                    ->where('teacher_id', $request->teacher_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('salon_id',   $request->salon_id)
                ),
            ],
        ]);

        $a = Asignacion::create($validated);
        return response()->json($a->load(['teacher','subject','salon']), 201);
    }

    // app/Http/Controllers/AsignacionController.php

    public function show(Asignacion $asignacion)
    {
        // Forzamos a devolver ids crudos y año
        return response()->json([
            'id'         => $asignacion->id,
            'teacher_id' => $asignacion->teacher_id,
            'subject_id' => $asignacion->subject_id,
            'salon_id'   => $asignacion->salon_id,
            'year'       => $asignacion->year,
        ]);
    }

    public function update(Request $request, Asignacion $asignacion)
    {
        $validated = $request->validate([
            'teacher_id' => ['required','exists:users,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'salon_id'   => ['required','exists:salons,id'],
            'year'       => [
                'required','integer','min:2000','max:2100',
                Rule::unique('asignaciones')->where(fn($q) => $q
                    ->where('teacher_id', $request->teacher_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('salon_id',   $request->salon_id)
                )->ignore($asignacion->id),
            ],
        ]);

        $asignacion->update($validated);

        // Devolvemos lo mismo que show para que el front quede consistente
        return response()->json([
            'id'         => $asignacion->id,
            'teacher_id' => $asignacion->teacher_id,
            'subject_id' => $asignacion->subject_id,
            'salon_id'   => $asignacion->salon_id,
            'year'       => $asignacion->year,
        ]);
    }


    public function destroy(Asignacion $asignacion)
    {
        $asignacion->delete();
        return response()->json(['mensaje' => 'Asignación eliminada correctamente']);
    }
}

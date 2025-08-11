<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsignacionController extends Controller
{
    public function index()
    {
        return Asignacion::with(['teacher','subject','salon'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => ['required','exists:users,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'salon_id'   => ['required','exists:salons,id'],
            'year'       => ['required','integer','min:2000','max:2100',
                Rule::unique('asignaciones')->where(fn($q) => $q
                    ->where('teacher_id', $request->teacher_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('salon_id',   $request->salon_id)
                )
            ],
        ]);

        return Asignacion::create($validated);
    }

    public function show(Asignacion $asignacion)
    {
        return $asignacion->load(['teacher','subject','salon']);
    }

    public function update(Request $request, Asignacion $asignacion)
    {
        $validated = $request->validate([
            'teacher_id' => ['required','exists:users,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'salon_id'   => ['required','exists:salons,id'],
            'year'       => ['required','integer','min:2000','max:2100',
                Rule::unique('asignaciones')->where(fn($q) => $q
                    ->where('teacher_id', $request->teacher_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('salon_id',   $request->salon_id)
                )->ignore($asignacion->id)
            ],
        ]);

        $asignacion->update($validated);
        return $asignacion->load(['teacher','subject','salon']);
    }

    public function destroy(Asignacion $asignacion)
    {
        $asignacion->delete();
        return response()->json(['mensaje' => 'Asignación eliminada correctamente']);
    }
}

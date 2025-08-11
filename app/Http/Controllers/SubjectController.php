<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $asignaturas = Subject::orderByDesc('id')->get();
        return view('pages/asignaturas.index', compact('asignaturas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
        ]);

        $subject = Subject::create($data);
        return response()->json($subject, 201);
    }

    public function show(Subject $subject)
    {
        return response()->json($subject);
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'nombre'      => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
        ]);

        $subject->update($data);
        return response()->json($subject->fresh());
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json(['mensaje' => 'Asignatura eliminada correctamente']);
    }
}

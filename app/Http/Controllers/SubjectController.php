<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return Subject::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable'
        ]);

        return Subject::create($request->all());
    }

    public function show(Subject $subject)
    {
        return $subject;
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->all());
        return $subject;
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json(['mensaje' => 'Asignatura eliminada correctamente']);
    }
}

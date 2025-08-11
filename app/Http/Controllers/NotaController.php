<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        return Nota::with(['periodo', 'docente', 'estudiante'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'periodo_id' => 'required|exists:periodos,id',
            'docente_id' => 'required|exists:users,id',
            'estudiante_id' => 'required|exists:users,id',
            'valor' => 'required|numeric|min:0|max:100',
        ]);

        return Nota::create($request->all());
    }

    public function show(Nota $nota)
    {
        return $nota->load(['periodo', 'docente', 'estudiante']);
    }

    public function update(Request $request, Nota $nota)
    {
        $nota->update($request->all());
        return $nota;
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();
        return response()->json(['mensaje' => 'Nota eliminada correctamente']);
    }
}

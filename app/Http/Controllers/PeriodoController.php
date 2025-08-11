<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function index()
    {
        // IMPORTANTE: devolver la vista con $periodos, no JSON
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        return view('periodos.index', compact('periodos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $periodo = Periodo::create($data);
        return response()->json($periodo, 201);
    }

    public function show($id)
    {
        $p = Periodo::findOrFail($id);
        return response()->json($p);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $periodo = Periodo::findOrFail($id);
        $periodo->update($data);

        // devolvemos el modelo actualizado como JSON
        return response()->json($periodo->fresh());
    }

    public function destroy($id)
    {
        $periodo = Periodo::findOrFail($id);
        $periodo->delete();
        return response()->json(['mensaje' => 'Periodo eliminado correctamente']);
    }
}

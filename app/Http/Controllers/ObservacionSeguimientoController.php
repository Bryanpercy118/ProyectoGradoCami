<?php

namespace App\Http\Controllers;

use App\Models\ObservacionSeguimiento;
use Illuminate\Http\Request;

class ObservacionSeguimientoController extends Controller
{
    public function index()
    {
        return ObservacionSeguimiento::with(['periodo', 'docente', 'estudiante'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'periodo_id' => 'required|exists:periodos,id',
            'docente_id' => 'required|exists:users,id',
            'estudiante_id' => 'required|exists:users,id',
            'contenido' => 'required|string|max:1000',
        ]);

        return ObservacionSeguimiento::create($request->all());
    }

    public function show(ObservacionSeguimiento $observacion)
    {
        return $observacion->load(['periodo', 'docente', 'estudiante']);
    }

    public function update(Request $request, ObservacionSeguimiento $observacion)
    {
        $observacion->update($request->all());
        return $observacion;
    }

    public function destroy(ObservacionSeguimiento $observacion)
    {
        $observacion->delete();
        return response()->json(['mensaje' => 'Observación eliminada correctamente']);
    }
}

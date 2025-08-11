<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        return Salon::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'grado' => 'required',
            'seccion' => 'required'
        ]);

        return Salon::create($request->all());
    }

    public function show(Salon $salon)
    {
        return $salon;
    }

    public function update(Request $request, Salon $salon)
    {
        $salon->update($request->all());
        return $salon;
    }

    public function destroy(Salon $salon)
    {
        $salon->delete();
        return response()->json(['mensaje' => 'Salón eliminado correctamente']);
    }
}

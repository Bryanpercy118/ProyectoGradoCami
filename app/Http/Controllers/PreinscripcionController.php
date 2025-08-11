<?php
namespace App\Http\Controllers;

use App\Models\Preinscripcion;
use Illuminate\Http\Request;

class PreinscripcionController extends Controller
{
    public function index()
    {
        $preinscripciones = Preinscripcion::withCount('aspirantes')->get();
        return view('pages.preinscripciones.index', compact('preinscripciones'));
    }

    public function edit($id)
    {
        $preinscripcion = Preinscripcion::findOrFail($id);
        $preinscripciones = Preinscripcion::withCount('aspirantes')->get();

        return view('pages.preinscripciones.index', compact('preinscripcion', 'preinscripciones'));
    }

  
    public function json($id)
    {
        $pre = Preinscripcion::findOrFail($id);
        return response()->json([
            'fecha_inicio' => $pre->fecha_inicio->format('Y-m-d'),
            'fecha_fin' => $pre->fecha_fin->format('Y-m-d'),
            'cupo' => $pre->cupo,
        ]);
    }

    public function show($id)
    {
        $preinscripcion = Preinscripcion::with([
                'aspirantes.salon', 
                'cupos.salon'       
            ])
            ->withCount('aspirantes')
            ->withSum('cupos', 'cupo_total')
            ->findOrFail($id);

        $salones = \App\Models\Salon::orderBy('grado')->orderBy('seccion')->get();

        return view('pages.preinscripcionesShow', compact('preinscripcion', 'salones'));
    }






    public function store(Request $request)
{
    $validated = $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'cupo' => 'required|integer|min:1',
    ]);

    $pre = Preinscripcion::create($validated);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'id' => $pre->id]);
    }

    return redirect()->back()->with('success', 'Preinscripción creada.');
}

public function update(Request $request, $id)
{  

    $pre = Preinscripcion::findOrFail($id);
    $validated = $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'cupo' => 'required|integer|min:1',
    ]);

  
    $pre->update($validated);

    return redirect()->back()->with('success', 'Preinscripción actualizada.');
}


public function destroy(Request $request, $id)
{
    Preinscripcion::findOrFail($id)->delete();

    return redirect()->back()->with('success', 'Preinscripción eliminada.');
}

}

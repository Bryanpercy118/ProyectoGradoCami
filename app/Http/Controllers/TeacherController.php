<?php
namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return Teacher::with('salon')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:teachers',
            'telefono' => 'required',
            'salon_id' => 'required|exists:salons,id'
        ]);

        return Teacher::create($request->all());
    }

    public function show(Teacher $teacher)
    {
        return $teacher->load('salon');
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update($request->all());
        return $teacher;
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(['mensaje' => 'Docente eliminado correctamente']);
    }
}

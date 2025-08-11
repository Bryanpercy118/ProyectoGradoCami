<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Vista con listado de docentes (users con rol profesor)
     */
    public function index()
    {
        $docentes = User::query()
            ->role('profesor') // <- Filtra solo usuarios con rol profesor
            ->select('id', 'name', 'email', 'gender', 'active', 'created_at')
            ->orderByDesc('id')
            ->get();

        return view('pages/docente.index', compact('docentes'));
    }


    /**
     * Crear docente (User) + asignar rol profesor
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'name'     => ['required','string','max:255'],
        'email'    => ['required','email','max:255','unique:users,email'],
        'password' => ['required','string','min:8'],
        'gender'   => ['nullable','string'],
        'active'   => ['nullable','boolean'],
    ]);

    $gender = $request->filled('gender') && trim((string)$data['gender']) !== '' ? $data['gender'] : null;
    $active = $request->has('active') ? $request->boolean('active') : true;

    $user = DB::transaction(function () use ($data, $gender, $active) {
        $u = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'gender'   => $gender,
            'active'   => $active,
        ]);
        $u->assignRole('profesor');
        return $u;
    });

    return response()->json($user->only(['id','name','email','gender','active','created_at']), 201);
}


    /**
     * Mostrar un docente (JSON)
     */
    public function show(User $profesor)
    {
        abort_unless($profesor->hasRole('profesor'), 404, 'Profesor no encontrado');

        return response()->json(
            $profesor->only(['id','name','email','gender','active','created_at'])
        );
    }

    /**
     * Actualizar docente (email único, password opcional)
     */
    public function update(Request $request, User $profesor)
    {
        abort_unless($profesor->hasRole('profesor'), 404, 'Profesor no encontrado');

        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255', Rule::unique('users','email')->ignore($profesor->id)],
            'password' => ['nullable','string','min:8'],
            'gender'   => ['nullable','in:male,female,other'],
            'active'   => ['nullable','boolean'],
        ]);

        DB::transaction(function () use (&$profesor, $data) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $profesor->update($data);
        });

        return response()->json($profesor->fresh()->only(['id','name','email','gender','active','updated_at']));
    }

    /**
     * Eliminar docente
     */
    public function destroy(User $profesor)
    {
        abort_unless($profesor->hasRole('profesor'), 404, 'Profesor no encontrado');

        $profesor->delete();

        return response()->json(['mensaje' => 'Docente eliminado correctamente']);
    }
}

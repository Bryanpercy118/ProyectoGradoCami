<?php
namespace App\Http\Controllers;

use App\Models\Aspirante;
use App\Models\Preinscripcion;
use App\Models\PreinscripcionCupo;
use Illuminate\Http\Request;

class AspiranteController extends Controller
{
    public function index()
    {
        // Preinscripción activa por fechas
        $preinscripcion = Preinscripcion::whereRaw('CURDATE() BETWEEN fecha_inicio AND fecha_fin')->firstOrFail();

        // Cupos por salón con disponibles calculados
        $cupos = PreinscripcionCupo::with('salon')
            ->where('preinscripcion_id', $preinscripcion->id)
            ->get()
            ->map(function ($c) use ($preinscripcion) {
                $ocupados = Aspirante::where('preinscripcion_id', $preinscripcion->id)
                    ->where('salon_id', $c->salon_id)
                    ->count();

                $c->disponibles = max(0, $c->cupo_total - $ocupados);
                return $c;
            });

        return view('pages/preinscripcion', compact('preinscripcion', 'cupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'preinscripcion_id' => 'required|exists:preinscripcions,id',
            'salon_id'          => 'required|exists:salons,id',
            'nombre_estudiante' => 'required|string',
            'fecha_nacimiento'  => 'required|date',
            'discapacidad'      => 'nullable|string',
            'grado_solicitado'  => 'required|string',
            'nombre_acudiente'  => 'required|string',
            'correo_acudiente'  => 'required|email',
            'telefono_acudiente'=> 'required|string',
            // El formulario envía texto libre; mantenemos string para no romper UX
            'datos_acudiente'   => 'nullable|string',
        ]);

        $pre = Preinscripcion::findOrFail($request->preinscripcion_id);

        // Validar si la preinscripción está activa
        if (!$pre->es_activa) {
            return $this->failResponse($request, 'La preinscripción no está activa', 400);
        }

        // Buscar cupo configurado para el salón solicitado
        $cupoSalon = PreinscripcionCupo::where('preinscripcion_id', $request->preinscripcion_id)
            ->where('salon_id', $request->salon_id)
            ->first();

        if (!$cupoSalon) {
            return $this->failResponse($request, 'No hay cupos configurados para este salón', 400);
        }

        // Validar disponibilidad
        $ocupados = Aspirante::where('preinscripcion_id', $request->preinscripcion_id)
            ->where('salon_id', $request->salon_id)
            ->count();

        if ($ocupados >= $cupoSalon->cupo_total) {
            return $this->failResponse($request, 'No hay cupo disponible en este salón', 400);
        }

        // Preparar payload respetando tu fillable; si el modelo castea datos_acudiente a 'array',
        // envolvemos el texto en un JSON válido para no fallar.
        $payload = $request->all();
        if (isset($payload['datos_acudiente']) && $payload['datos_acudiente'] !== '') {
            $decoded = json_decode($payload['datos_acudiente'], true);
            if (!is_array($decoded)) {
                $payload['datos_acudiente'] = json_encode(['texto' => $payload['datos_acudiente']]);
            }
        }

        $aspirante = Aspirante::create($payload);

        // Responder según el tipo de petición
        if ($request->ajax()) {
            return response()->json($aspirante, 201);
        }

        return back()->with('success', 'Inscripción registrada. Nos pondremos en contacto pronto.');
    }

    public function show(Aspirante $aspirante)
    {
        return $aspirante->load('preinscripcion', 'salon');
    }

    public function update(Request $request, Aspirante $aspirante)
    {
        $request->validate([
            'nombre_estudiante' => 'sometimes|string',
            'fecha_nacimiento'  => 'sometimes|date',
            'grado_solicitado'  => 'sometimes|string',
            'nombre_acudiente'  => 'sometimes|string',
            'correo_acudiente'  => 'sometimes|email',
            'telefono_acudiente'=> 'sometimes|string',
            // si dejas el cast a 'array' en el modelo, puedes aceptar JSON aquí;
            // si prefieres texto, cambia el cast del modelo a 'string'
            'datos_acudiente'   => 'nullable|string',
        ]);

        $payload = $request->all();
        if (isset($payload['datos_acudiente']) && $payload['datos_acudiente'] !== '') {
            $decoded = json_decode($payload['datos_acudiente'], true);
            if (!is_array($decoded)) {
                $payload['datos_acudiente'] = json_encode(['texto' => $payload['datos_acudiente']]);
            }
        }

        $aspirante->update($payload);
        return $aspirante->load('preinscripcion', 'salon');
    }

    public function destroy(Aspirante $aspirante)
    {
        $aspirante->delete();
        return response()->json(['mensaje' => 'Aspirante eliminado correctamente']);
    }

    /** Helper para responder error según AJAX o no */
    private function failResponse(Request $request, string $msg, int $status)
    {
        if ($request->ajax()) {
            return response()->json(['error' => $msg], $status);
        }
        return back()->withErrors($msg)->withInput();
    }
}

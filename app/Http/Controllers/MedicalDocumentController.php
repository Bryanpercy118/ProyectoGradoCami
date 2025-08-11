<?php

namespace App\Http\Controllers;

use App\Models\MedicalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MedicalDocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // todos los métodos requieren login
    }

    /**
     * Listado de documentos del alumno (o todos si es admin).
     */
    public function index()
    {
        $user = auth()->user();

        // Si es admin/super-admin ve todos; si no, solo los suyos
        $docs = $user->hasAnyRole(['admin', 'super-admin'])
            ? MedicalDocument::with('user:id,name,email')->latest()->get()
            : MedicalDocument::where('user_id', $user->id)->latest()->get();

        return view('pages/documentos_medicos.index', compact('docs'));
    }

    /**
     * Subir un documento PDF.
     * Requiere rol estudiante (o admin si quieres permitirles subir).
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['estudiante', 'admin', 'super-admin'])) {
            abort(403, 'No tiene permisos para subir documentos.');
        }


        $data = $request->validate([
            'titulo'    => ['required','string','max:150'],
            'categoria' => ['nullable','string','max:50'],
            'archivo'   => ['required','file','mimetypes:application/pdf','max:10240'], // 10MB
        ], [
            'archivo.mimetypes' => 'El archivo debe ser un PDF.',
            'archivo.max'       => 'El PDF no puede exceder 10 MB.',
        ]);

        $file = $data['archivo'];

        $folder   = 'medical/'.$user->id;
        $filename = now()->format('Ymd_His')
            .'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            .'.pdf';

        $path = Storage::disk('private')->putFileAs($folder, $file, $filename);

        $doc = MedicalDocument::create([
            'user_id'        => $user->id,
            'titulo'         => $data['titulo'],
            'categoria'      => $data['categoria'] ?? null,
            'archivo_path'   => $path,
            'archivo_nombre' => $file->getClientOriginalName(),
            'archivo_tamano' => $file->getSize(),
            'archivo_mime'   => $file->getMimeType() ?: 'application/pdf',
            'checksum'       => hash_file('sha256', $file->getRealPath()),
            'estado'         => 'cargado',
        ]);

        return back()->with('success', 'Documento cargado correctamente.');
    }

  
    public function download(MedicalDocument $documento)
    {
        $user = auth()->user();

        if (! ($user->id === $documento->user_id || $user->hasAnyRole(['admin','super-admin']))) {
            abort(403, 'No tiene permisos para descargar este documento.');
        }

        if (! Storage::disk('private')->exists($documento->archivo_path)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::disk('private')->download($documento->archivo_path, $documento->archivo_nombre);
    }

 
    public function destroy(MedicalDocument $documento)
    {
        $user = auth()->user();

        $esAdmin = $user->hasAnyRole(['admin','super-admin']);
        $esDueno = $user->id === $documento->user_id;

        if (! $esAdmin && ! $esDueno) {
            abort(403, 'No tiene permisos para eliminar este documento.');
        }

        if ($esDueno && ! $esAdmin && $documento->estado !== 'cargado') {
            return back()->withErrors(['No se puede eliminar un documento ya revisado/rechazado.']);
        }

        Storage::disk('private')->delete($documento->archivo_path);
        $documento->delete();

        return back()->with('success', 'Documento eliminado.');
    }
}

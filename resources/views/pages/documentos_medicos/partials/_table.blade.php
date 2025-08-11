@php
  use Illuminate\Support\Facades\Auth;
  $user = Auth::user();
  $isAdmin = $user->hasAnyRole(['admin','super-admin']);
@endphp

<div class="overflow-auto">
  <table class="table table-report">
    <thead>
      <tr class="uppercase">
        @if($isAdmin)
          <th>Alumno</th>
        @endif
        <th>Título</th>
        <th>Categoría</th>
        <th>Estado</th>
        <th>Subido</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($docs as $doc)
        <tr class="intro-x">
          @if($isAdmin)
            <td>{{ optional($doc->user)->name ?? '—' }}</td>
          @endif
          <td class="font-medium">{{ $doc->titulo }}</td>
          <td>{{ $doc->categoria ?: '—' }}</td>
          <td>
            <span class="badge {{ $doc->estado === 'cargado' ? 'bg-slate-200' : ($doc->estado === 'revisado' ? 'bg-success' : 'bg-danger') }}">
              {{ ucfirst($doc->estado) }}
            </span>
          </td>
          <td>{{ optional($doc->created_at)->format('d/m/Y H:i') }}</td>
          <td class="table-report__action w-60">
            <div class="flex justify-center gap-2">
              <a class="btn btn-outline-primary" href="{{ route('meddocs.download', $doc) }}">Descargar</a>

              {{-- El alumno dueño puede borrar si está en estado "cargado"; admins siempre --}}
              @php
                $esDueno = $user->id === $doc->user_id;
                $puedeBorrar = $isAdmin || ($esDueno && $doc->estado === 'cargado');
              @endphp

              @if($puedeBorrar)
                <form action="{{ route('meddocs.destroy', $doc) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar el documento?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
              @else
                <button class="btn btn-secondary" disabled title="No se puede eliminar en este estado">Eliminar</button>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="{{ $isAdmin ? 6 : 5 }}" class="text-center text-slate-500 py-6">
            No hay documentos.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

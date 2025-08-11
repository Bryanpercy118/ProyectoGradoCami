@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detalle Preinscripción #{{ $preinscripcion->id }}</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">
    Preinscripción #{{ $preinscripcion->id }} — Detalle
</h2>

@php
    // Totales
    $totalCupos = (int) ($preinscripcion->cupos_sum_cupo_total ?? $preinscripcion->cupos->sum('cupo_total'));
    $inscritos  = (int) ($preinscripcion->aspirantes_count ?? $preinscripcion->aspirantes->count());
    $disponibles = max(0, $totalCupos - $inscritos);

    // Colecciones esperadas:
    // - $preinscripcion->cupos (con ->salon)
    // - $preinscripcion->aspirantes (con ->salon)
    // - $salones (lista completa de salones para poder agregar cupos por salón)
    $salonesConfigurados = $preinscripcion->cupos->pluck('salon_id')->all();
@endphp

{{-- Resumen --}}
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 md:col-span-3">
        <div class="box p-5">
            <div class="text-slate-500">Rango</div>
            <div class="text-xl font-semibold mt-1">
                {{ \Carbon\Carbon::parse($preinscripcion->fecha_inicio)->format('d/m/Y') }}
                —
                {{ \Carbon\Carbon::parse($preinscripcion->fecha_fin)->format('d/m/Y') }}
            </div>
        </div>
    </div>
    <div class="col-span-12 md:col-span-3">
        <div class="box p-5">
            <div class="text-slate-500">Estado</div>
            <div class="mt-1">
                <span class="badge
                    {{ $preinscripcion->estado_calculado === 'activa' ? 'badge-success'
                       : ($preinscripcion->estado_calculado === 'inactiva' ? 'badge-warning' : 'badge-danger') }}">
                    {{ ucfirst($preinscripcion->estado_calculado) }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-span-12 md:col-span-2">
        <div class="box p-5">
            <div class="text-slate-500">Cupos Totales</div>
            <div class="text-2xl font-bold mt-1">{{ $totalCupos }}</div>
        </div>
    </div>
    <div class="col-span-12 md:col-span-2">
        <div class="box p-5">
            <div class="text-slate-500">Inscritos</div>
            <div class="text-2xl font-bold mt-1">{{ $inscritos }}</div>
        </div>
    </div>
    <div class="col-span-12 md:col-span-2">
        <div class="box p-5">
            <div class="text-slate-500">Disponibles</div>
            <div class="text-2xl font-bold mt-1 {{ $disponibles > 0 ? 'text-emerald-700' : 'text-red-700' }}">
                {{ $disponibles }}
            </div>
        </div>
    </div>
</div>

{{-- Cupos por salón --}}
<div class="intro-y mt-10">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-medium">Cupos por Salón</h3>
        <button class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#add-cupo-modal">
            + Agregar Cupo a Salón
        </button>
    </div>

    <div class="intro-y overflow-auto">
        <table class="table table-report">
            <thead>
                <tr class="uppercase">
                    <th>Salón</th>
                    <th class="text-right">Cupo Total</th>
                    <th class="text-right">Inscritos</th>
                    <th class="text-right">Disponibles</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($preinscripcion->cupos as $c)
                    @php
                        $inscritosSalon = $preinscripcion->aspirantes->where('salon_id', $c->salon_id)->count();
                        $dispSalon = max(0, $c->cupo_total - $inscritosSalon);
                    @endphp
                    <tr>
                        <td>
                            {{ $c->salon->nombre }} — {{ $c->salon->grado }}{{ $c->salon->seccion }}
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end items-center gap-2">
                                <input type="number" min="0" class="form-control w-24 text-right"
                                       value="{{ $c->cupo_total }}" id="cupo-input-{{ $c->id }}">
                                <button class="btn btn-sm btn-outline-primary"
                                        onclick="updateCupo({{ $preinscripcion->id }}, {{ $c->id }})">
                                    Guardar
                                </button>
                            </div>
                        </td>
                        <td class="text-right">{{ $inscritosSalon }}</td>
                        <td class="text-right {{ $dispSalon>0?'text-emerald-700':'text-red-700' }}">{{ $dispSalon }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="deleteCupo({{ $preinscripcion->id }}, {{ $c->id }})">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-slate-500 py-6">Sin cupos configurados aún.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Aspirantes --}}
<div class="intro-y mt-10">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-medium">Aspirantes</h3>
        <div class="text-slate-500 text-sm">
            Total: {{ $preinscripcion->aspirantes->count() }}
        </div>
    </div>

    <div class="intro-y overflow-auto">
        <table class="table table-report">
            <thead>
                <tr class="uppercase">
                    <th>Estudiante</th>
                    <th>Salón</th>
                    <th>Acudiente</th>
                    <th>Contacto</th>
                    <th>Grado Solicitado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
    <tbody>
    @forelse($preinscripcion->aspirantes as $a)
        <tr>
            <td class="font-medium">{{ $a->nombre_estudiante }}</td>
            <td>
                @if($a->salon)
                    {{ $a->salon->nombre }} — {{ $a->salon->grado }}{{ $a->salon->seccion }}
                @else
                    <span class="text-slate-500">Sin salón</span>
                @endif
            </td>
            <td>{{ $a->nombre_acudiente }}</td>
            <td>
                <div>{{ $a->correo_acudiente }}</div>
                <div>{{ $a->telefono_acudiente }}</div>
            </td>
            <td>{{ $a->grado_solicitado }}</td>
            <td class="text-center">
                {{-- Opción A: abrir formulario de matrícula con datos prellenados --}}
                <a class="btn btn-sm btn-outline-primary mr-2"
                href="{{ route('matriculas.create', ['aspirante_id' => $a->id]) }}">
                Matricular
                </a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-slate-500 py-6">No hay aspirantes registrados.</td></tr>
    @endforelse
    </tbody>
        </table>
    </div>
</div>

{{-- Modal: Agregar cupo por salón --}}
<div id="add-cupo-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="add-cupo-form">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Agregar Cupo por Salón</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="preinscripcion_id" value="{{ $preinscripcion->id }}">

        <div class="mb-3">
            <label class="form-label">Salón</label>
            <select name="salon_id" class="form-select" required>
                <option value="">-- Seleccionar --</option>
                @foreach($salones as $s)
                    <option value="{{ $s->id }}" {{ in_array($s->id, $salonesConfigurados) ? 'disabled' : '' }}>
                        {{ $s->nombre }} — {{ $s->grado }}{{ $s->seccion }}
                        {{ in_array($s->id, $salonesConfigurados) ? ' (ya configurado)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cupo total</label>
            <input type="number" name="cupo_total" class="form-control" min="0" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div></div>
</div>
@endsection

@section('script')
<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

// Crear cupo por salón
document.getElementById('add-cupo-form')?.addEventListener('submit', function(e){
    e.preventDefault();
    const payload = Object.fromEntries(new FormData(this));
    fetch(`/preinscripciones/{{ $preinscripcion->id }}/cupos`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
    }).then(async r=>{
        if(!r.ok){ const err=await r.json(); alert(JSON.stringify(err)); return; }
        tailwind.Modal.getInstance(document.querySelector('#add-cupo-modal'))?.hide();
        location.reload();
    }).catch(()=>alert('Error al crear el cupo'));
});

async function matricularRapido(a) {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Validaciones rápidas
    if (!a.salon_id) {
        alert('Este aspirante no tiene salón seleccionado. Asigna salón en preinscripción antes de matricular.');
        return;
    }
    if (!a.email) {
        alert('No tenemos email para crear credenciales. Usa "Formulario" para ingresarlo.');
        return;
    }

    const payload = {
        nombre_estudiante: a.nombre,
        email: a.email,
        salon_id: a.salon_id,
        year: new Date().getFullYear().toString(),
        aspirante_id: a.id,
        preinscripcion_id: a.pre_id,
        observaciones: 'Matrícula creada desde Preinscripción (rápido)',
    };

    try {
        // 1) Crear matrícula
        const res = await fetch(`{{ route('matriculas.store') }}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        if (!res.ok) {
            const errText = await res.text();
            throw new Error(errText || 'Error creando matrícula');
        }
        const data = await res.json();

        // 2) Eliminar aspirante de preinscripciones (como pediste)
        const del = await fetch(`/aspirantes/${a.id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf }
        });
        if (!del.ok) {
            // Si falla la eliminación, al menos seguimos al detalle de matrícula
            console.warn('No se pudo eliminar el aspirante después de matricular.');
        }

        // 3) Ir al detalle de la matrícula creada
        window.location.href = `/matriculas/${data.id}`;
    } catch (e) {
        alert('No se pudo matricular: ' + (e.message || e));
    }
}

// Actualizar cupo
function updateCupo(preId, cupoId){
    const input = document.getElementById(`cupo-input-${cupoId}`);
    const cupo_total = parseInt(input.value || '0', 10);
    fetch(`/preinscripciones/${preId}/cupos/${cupoId}`, {
        method: 'PUT',
        headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json'},
        body: JSON.stringify({ cupo_total })
    }).then(async r=>{
        if(!r.ok){ const err=await r.json(); alert(JSON.stringify(err)); return; }
        location.reload();
    }).catch(()=>alert('Error al actualizar el cupo'));
}

// Eliminar cupo
function deleteCupo(preId, cupoId){
    if(!confirm('¿Eliminar este cupo de salón?')) return;
    fetch(`/preinscripciones/${preId}/cupos/${cupoId}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': csrf}
    }).then(async r=>{
        if(!r.ok){ const err=await r.json(); alert(JSON.stringify(err)); return; }
        location.reload();
    }).catch(()=>alert('Error al eliminar el cupo'));
}
</script>
@endsection

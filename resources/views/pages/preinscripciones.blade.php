@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Preinscripciones</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Preinscripciones</h2>

@if(session('success'))
    <div class="alert alert-success mt-5">{{ session('success') }}</div>
@endif

<!-- Botón Nueva -->
<div class="intro-y flex justify-end mt-5 mb-5">
    <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-pre-modal">
        + Nueva Preinscripción
    </button>
</div>

<!-- Tabla -->
<div class="intro-y overflow-auto">
    <table class="table table-report">
        <thead>
            <tr class="uppercase">
                <th>Fechas</th>
                <th class="text-right">Cupos Totales</th>
                <th class="text-right">Inscritos</th>
                <th class="text-right">Disponibles</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preinscripciones as $p)
                @php
                    // Compatibilidad: usa total enviado por el controlador (total_cupos),
                    // o el withSum generado por Eloquent, o 0 si no vino.
                    $totalCupos = (int)($p->total_cupos ?? $p->cupos_sum_cupo_total ?? 0);
                    $inscritos  = (int)($p->aspirantes_count ?? 0);
                    $disp       = max(0, $totalCupos - $inscritos);
                @endphp
                <tr class="intro-x">
                    <td>{{ \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($p->fecha_fin)->format('d/m/Y') }}</td>
                    <td class="text-right font-medium">{{ $totalCupos }}</td>
                    <td class="text-right">{{ $inscritos }}</td>
                    <td class="text-right font-semibold {{ $disp > 0 ? 'text-emerald-700' : 'text-red-700' }}">{{ $disp }}</td>
                    <td>
                        <span class="badge
                            {{ ($p->estado_calculado ?? 'inactiva') === 'activa' ? 'badge-success'
                               : (($p->estado_calculado ?? 'inactiva') === 'inactiva' ? 'badge-warning' : 'badge-danger') }}">
                            {{ ucfirst($p->estado_calculado ?? 'inactiva') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('preinscripciones.show', $p->id) }}" class="btn btn-sm btn-outline-info mr-2" title="Detalle de cupos por salón">👥</a>
                        <button class="btn btn-sm btn-outline-warning mr-2" onclick="openEditModal({{ $p->id }})" title="Editar">✏️</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $p->id }})" title="Eliminar">🗑️</button>
                    </td>
                </tr>
            @endforeach

            @if($preinscripciones->isEmpty())
                <tr><td colspan="6" class="text-center text-gray-500 py-6">No hay preinscripciones.</td></tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal CREAR -->
<div id="add-pre-modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="create-pre-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Preinscripción</h5>
                </div>
                <div class="modal-body">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control mb-3" required>

                    <label class="form-label">Fecha fin</label>
                    <input type="date" name="fecha_fin" class="form-control mb-3" required>

                    {{-- Ya no hay cupo global. Los cupos se configuran por salón en la pantalla de detalle/edición. --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal EDITAR -->
<div id="edit-pre-modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-pre-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Editar Preinscripción</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id">

                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" id="edit-fecha-inicio" class="form-control mb-3" required>

                    <label class="form-label">Fecha fin</label>
                    <input type="date" name="fecha_fin" id="edit-fecha-fin" class="form-control mb-3" required>

                    {{-- Los cupos por salón se administran en la vista de detalle (show) --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

/* Crear */
document.getElementById('create-pre-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const payload = Object.fromEntries(new FormData(this));

    fetch('{{ route("preinscripciones.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(async r => {
        if (!r.ok) throw await r.json();
        return r.json();
    })
    .then(() => {
        tailwind.Modal.getInstance(document.querySelector('#add-pre-modal'))?.hide();
        showToast('Preinscripción creada con éxito.');
        setTimeout(() => location.reload(), 800);
    })
    .catch(() => alert("Error al crear la preinscripción"));
});

/* Cargar datos y mostrar modal de edición */
function openEditModal(id) {
    fetch(`/preinscripciones/${id}/json`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-fecha-inicio').value = data.fecha_inicio;
            document.getElementById('edit-fecha-fin').value   = data.fecha_fin;

            tailwind.Modal.getOrCreateInstance(document.querySelector('#edit-pre-modal')).show();
        })
        .catch(() => alert("Error al cargar datos"));
}

/* Editar */
document.getElementById('edit-pre-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const payload = Object.fromEntries(new FormData(this));
    payload._method = 'PUT';

    fetch(`/preinscripciones/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(async r => {
        if (!r.ok) throw await r.json();
        return r.json();
    })
    .then(() => {
        tailwind.Modal.getInstance(document.querySelector('#edit-pre-modal'))?.hide();
        showToast('Preinscripción actualizada.');
        setTimeout(() => location.reload(), 800);
    })
    .catch(() => alert("Error al actualizar"));
});

/* Eliminar */
function confirmDelete(id) {
    if (!confirm('¿Eliminar esta preinscripción?')) return;

    fetch(`/preinscripciones/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrf },
    })
    .then(() => {
        showToast('Preinscripción eliminada.');
        setTimeout(() => location.reload(), 800);
    })
    .catch(() => alert("Error al eliminar"));
}

/* Toast visual */
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow z-50';
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}
</script>
@endsection

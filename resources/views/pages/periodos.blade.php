{{-- resources/views/periodos/index.blade.php --}}
@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Periodos Académicos</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Periodos Académicos</h2>

<div class="intro-y flex justify-end mt-5 mb-5">
    <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-periodo-modal">
        Nuevo Periodo
    </button>
</div>

<div id="alerts" class="intro-y mb-4 hidden">
    <div id="alert-content" class="alert"></div>
</div>

<div class="intro-y overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr class="uppercase">
                <th>Nombre del periodo</th>
                <th>Fecha de inicio</th>
                <th>Fecha de fin</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="periodos-tbody">
            @foreach ($periodos as $periodo)
                <tr class="intro-x" data-row-id="{{ $periodo->id }}">
                    <td class="font-medium">{{ $periodo->nombre }}</td>
                    <td>
                        {{ \Illuminate\Support\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }}
                    </td>
                    <td>
                        {{ \Illuminate\Support\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center gap-2">
                            <button class="btn btn-warning"
                                onclick="editPeriodo({{ $periodo->id }})"
                                data-tw-toggle="modal"
                                data-tw-target="#edit-periodo-modal">
                                Editar
                            </button>
                            <button class="btn btn-danger" onclick="deletePeriodo({{ $periodo->id }})">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            @if($periodos->isEmpty())
                <tr><td colspan="4" class="text-center text-slate-500 py-6">No hay periodos registrados.</td></tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal: Crear Periodo -->
<div id="add-periodo-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="add-periodo-form">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo periodo</h5>
        <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="add-nombre" class="form-label">Nombre del periodo</label>
            <input id="add-nombre" type="text" name="nombre" class="form-control" required
                   placeholder="Ej: 2025 - I">
            <small class="form-help text-slate-500">Usa un nombre claro y consistente.</small>
        </div>
        <div class="mb-3">
            <label for="add-inicio" class="form-label">Fecha de inicio</label>
            <input id="add-inicio" type="date" name="fecha_inicio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="add-fin" class="form-label">Fecha de fin</label>
            <input id="add-fin" type="date" name="fecha_fin" class="form-control" required>
            <small class="form-help text-slate-500">Debe ser igual o posterior a la fecha de inicio.</small>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add-submit" type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div></div>
</div>

<!-- Modal: Editar Periodo -->
<div id="edit-periodo-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="edit-periodo-form">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Editar periodo</h5>
        <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-periodo-id">

        <div class="mb-3">
            <label for="edit-periodo-nombre" class="form-label">Nombre del periodo</label>
            <input type="text" name="nombre" id="edit-periodo-nombre" class="form-control" required
                   placeholder="Ej: 2025 - I">
        </div>

        <div class="mb-3">
            <label for="edit-periodo-inicio" class="form-label">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="edit-periodo-inicio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="edit-periodo-fin" class="form-label">Fecha de fin</label>
            <input type="date" name="fecha_fin" id="edit-periodo-fin" class="form-control" required>
        </div>

      </div>
      <div class="modal-footer">
        <button id="edit-submit" type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div></div>
</div>

<script>
  const csrf = document.querySelector('meta[name="csrf-token"]').content;

  const showAlert = (msg, type = 'success') => {
    const alerts = document.getElementById('alerts');
    const content = document.getElementById('alert-content');
    content.className = `alert ${type === 'success' ? 'alert-success' : 'alert-danger'}`;
    content.textContent = msg;
    alerts.classList.remove('hidden');
    setTimeout(() => alerts.classList.add('hidden'), 3500);
  };

  const closeModal = (id) => {
    // dispara el atributo data-tw-dismiss del modal
    const modal = document.querySelector(`${id} [data-tw-dismiss="modal"]`);
    if (modal) modal.click();
  };

  const setLoading = (btn, loading) => {
    if (!btn) return;
    btn.disabled = loading;
    btn.dataset.originalText = btn.dataset.originalText || btn.textContent;
    btn.textContent = loading ? 'Procesando...' : btn.dataset.originalText;
  };

  // Crear
  document.getElementById('add-periodo-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('add-submit');
    setLoading(btn, true);

    const payload = Object.fromEntries(new FormData(e.target));
    // Validación rápida en cliente
    if (payload.fecha_fin < payload.fecha_inicio) {
      setLoading(btn, false);
      return showAlert('La fecha de fin debe ser posterior o igual a la de inicio.', 'danger');
    }

    try {
      const res = await fetch('{{ route("periodos.store") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      if (!res.ok) {
        const error = await res.json().catch(() => ({}));
        throw new Error(error.message || 'No se pudo crear el periodo.');
      }

      const created = await res.json();
      // Pintamos en la tabla sin recargar
      appendRow(created);
      e.target.reset();
      closeModal('#add-periodo-modal');
      showAlert('Periodo creado correctamente.');
    } catch (err) {
      showAlert(err.message, 'danger');
    } finally {
      setLoading(btn, false);
    }
  });

  const formatDateHuman = (yyyy_mm_dd) => {
    // Espera 'YYYY-MM-DD' y devuelve 'dd/mm/YYYY'
    if (!yyyy_mm_dd) return '';
    const [y, m, d] = yyyy_mm_dd.split('-');
    return `${d}/${m}/${y}`;
  };

  const appendRow = (p) => {
    const tbody = document.getElementById('periodos-tbody');
    // Si estaba el estado "vacío", lo removemos
    const empty = tbody.querySelector('tr td[colspan]');
    if (empty) empty.parentElement.remove();

    const tr = document.createElement('tr');
    tr.className = 'intro-x';
    tr.dataset.rowId = p.id;
    tr.innerHTML = `
      <td class="font-medium">${p.nombre}</td>
      <td>${formatDateHuman((p.fecha_inicio || '').slice(0,10))}</td>
      <td>${formatDateHuman((p.fecha_fin || '').slice(0,10))}</td>
      <td class="table-report__action w-56">
        <div class="flex justify-center gap-2">
          <button class="btn btn-warning"
            onclick="editPeriodo(${p.id})"
            data-tw-toggle="modal"
            data-tw-target="#edit-periodo-modal">
            Editar
          </button>
          <button class="btn btn-danger" onclick="deletePeriodo(${p.id})">Eliminar</button>
        </div>
      </td>
    `;
    tbody.prepend(tr);
  };

  // Cargar datos al modal de edición
  async function editPeriodo(id) {
    try {
      const res = await fetch(`/periodos/${id}`, { headers: { 'Accept': 'application/json' }});
      if (!res.ok) throw new Error('No se pudo cargar el periodo.');
      const data = await res.json();

      document.getElementById('edit-periodo-id').value = data.id;
      document.getElementById('edit-periodo-nombre').value = data.nombre;

      // Normalizamos a 'YYYY-MM-DD' por si viene con hora
      const ini = (data.fecha_inicio || '').slice(0,10);
      const fin = (data.fecha_fin || '').slice(0,10);

      document.getElementById('edit-periodo-inicio').value = ini;
      document.getElementById('edit-periodo-fin').value   = fin;
    } catch (e) {
      showAlert(e.message, 'danger');
    }
  }

  // Actualizar
  document.getElementById('edit-periodo-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('edit-submit');
    setLoading(btn, true);

    const id = document.getElementById('edit-periodo-id').value;
    const payload = Object.fromEntries(new FormData(e.target));

    if (payload.fecha_fin < payload.fecha_inicio) {
      setLoading(btn, false);
      return showAlert('La fecha de fin debe ser posterior o igual a la de inicio.', 'danger');
    }

    try {
      const res = await fetch(`/periodos/${id}`, {
        method: 'PUT',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      if (!res.ok) {
        const error = await res.json().catch(() => ({}));
        throw new Error(error.message || 'No se pudo actualizar el periodo.');
      }

      const updated = await res.json();

      // Actualizamos la fila sin recarga
      const row = document.querySelector(`tr[data-row-id="${id}"]`);
      if (row) {
        row.children[0].textContent = updated.nombre;
        row.children[1].textContent = formatDateHuman((updated.fecha_inicio || '').slice(0,10));
        row.children[2].textContent = formatDateHuman((updated.fecha_fin || '').slice(0,10));
      }

      closeModal('#edit-periodo-modal');
      showAlert('Periodo actualizado correctamente.');
    } catch (err) {
      showAlert(err.message, 'danger');
    } finally {
      setLoading(btn, false);
    }
  });

  // Eliminar
  async function deletePeriodo(id) {
    if (!confirm('¿Eliminar periodo?')) return;
    try {
      const res = await fetch(`/periodos/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
      });
      if (!res.ok) throw new Error('No se pudo eliminar el periodo.');

      // Quitamos la fila
      const row = document.querySelector(`tr[data-row-id="${id}"]`);
      if (row) row.remove();
      showAlert('Periodo eliminado correctamente.');
      // Si no queda ninguno, mostramos estado vacío
      const tbody = document.getElementById('periodos-tbody');
      if (!tbody.querySelector('tr')) {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td colspan="4" class="text-center text-slate-500 py-6">No hay periodos registrados.</td>`;
        tbody.appendChild(tr);
      }
    } catch (err) {
      showAlert(err.message, 'danger');
    }
  }
</script>
@endsection

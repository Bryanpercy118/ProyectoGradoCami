@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Asignaturas</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Asignaturas</h2>

<div class="intro-y flex justify-end mt-5 mb-5">
    <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-subject-modal">
        Nueva Asignatura
    </button>
</div>

<div id="alerts" class="intro-y mb-4 hidden">
    <div id="alert-content" class="alert"></div>
</div>

<div class="intro-y overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr class="uppercase">
                <th>Nombre</th>
                <th>Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="subjects-tbody">
            @forelse ($asignaturas as $s)
                <tr class="intro-x" data-row-id="{{ $s->id }}">
                    <td class="font-medium">{{ $s->nombre }}</td>
                    <td>{{ $s->descripcion ?? '—' }}</td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center gap-2">
                            <button class="btn btn-warning"
                                onclick="editSubject({{ $s->id }})"
                                data-tw-toggle="modal"
                                data-tw-target="#edit-subject-modal">
                                Editar
                            </button>
                            <button class="btn btn-danger" onclick="deleteSubject({{ $s->id }})">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-slate-500 py-6">No hay asignaturas registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal: Crear -->
<div id="add-subject-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="add-subject-form">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Registrar asignatura</h5>
        <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required placeholder="Ej: Matemática">
            <div class="form-text text-danger d-none" data-error="nombre"></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción (opcional)</label>
            <textarea name="descripcion" class="form-control" rows="3" placeholder="Breve descripción"></textarea>
            <div class="form-text text-danger d-none" data-error="descripcion"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add-submit" type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div></div>
</div>

<!-- Modal: Editar -->
<div id="edit-subject-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="edit-subject-form">
      @csrf @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Editar asignatura</h5>
        <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit-id" name="id">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" id="edit-nombre" name="nombre" class="form-control" required>
            <div class="form-text text-danger d-none" data-error="nombre"></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea id="edit-descripcion" name="descripcion" class="form-control" rows="3"></textarea>
            <div class="form-text text-danger d-none" data-error="descripcion"></div>
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
  const BASE = "{{ url('asignaturas') }}";

  const showAlert = (msg, type = 'success') => {
    const alerts = document.getElementById('alerts');
    const content = document.getElementById('alert-content');
    content.className = `alert ${type === 'success' ? 'alert-success' : 'alert-danger'}`;
    content.textContent = msg;
    alerts.classList.remove('hidden');
    setTimeout(() => alerts.classList.add('hidden'), 3000);
  };

  const closeModal = (id) => {
    const btn = document.querySelector(`${id} [data-tw-dismiss="modal"], ${id} .btn-close`);
    if (btn) btn.click();
  };

  const clearErrors = (form) => {
    form.querySelectorAll('[data-error]').forEach(el => { el.classList.add('d-none'); el.textContent = ''; });
  };
  const showErrors = (form, errors) => {
    Object.entries(errors || {}).forEach(([field, msgs]) => {
      const holder = form.querySelector(`[data-error="${field}"]`);
      if (holder) { holder.textContent = Array.isArray(msgs) ? msgs[0] : msgs; holder.classList.remove('d-none'); }
    });
  };

  const appendRow = (s) => {
    const tbody = document.getElementById('subjects-tbody');
    const empty = tbody.querySelector('tr td[colspan]');
    if (empty) empty.parentElement.remove();

    const tr = document.createElement('tr');
    tr.className = 'intro-x';
    tr.dataset.rowId = s.id;
    tr.innerHTML = `
      <td class="font-medium">${s.nombre ?? ''}</td>
      <td>${s.descripcion ?? '—'}</td>
      <td class="table-report__action w-56">
        <div class="flex justify-center gap-2">
          <button class="btn btn-warning"
            onclick="editSubject(${s.id})"
            data-tw-toggle="modal"
            data-tw-target="#edit-subject-modal">
            Editar
          </button>
          <button class="btn btn-danger" onclick="deleteSubject(${s.id})">
            Eliminar
          </button>
        </div>
      </td>
    `;
    tbody.prepend(tr);
  };

  const updateRow = (s) => {
    const row = document.querySelector(`tr[data-row-id="${s.id}"]`);
    if (!row) return;
    row.children[0].textContent = s.nombre ?? '';
    row.children[1].textContent = s.descripcion ?? '—';
  };

  // CREATE
  document.getElementById('add-subject-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    clearErrors(form);

    try {
      const res = await fetch("{{ route('asignaturas.store') }}", {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': csrf, 'Accept': 'application/json','Content-Type': 'application/json'},
        body: JSON.stringify(Object.fromEntries(new FormData(form)))
      });
      if (!res.ok) {
        if (res.status === 422) { const d = await res.json(); showErrors(form, d.errors); return; }
        throw new Error('No se pudo crear la asignatura.');
      }
      const created = await res.json();
      appendRow(created);
      form.reset();
      closeModal('#add-subject-modal');
      showAlert('Asignatura creada correctamente.');
    } catch (err) { showAlert(err.message, 'danger'); }
  });

  // READ + open edit modal
  async function editSubject(id) {
    clearErrors(document.getElementById('edit-subject-form'));
    try {
      const res = await fetch(`${BASE}/${id}`, { headers: { 'Accept': 'application/json' }});
      if (!res.ok) throw new Error('No se pudo cargar la asignatura.');
      const s = await res.json();

      document.getElementById('edit-id').value = s.id;
      document.getElementById('edit-nombre').value = s.nombre ?? '';
      document.getElementById('edit-descripcion').value = s.descripcion ?? '';
    } catch (e) { showAlert(e.message, 'danger'); }
  }
  window.editSubject = editSubject;

  // UPDATE
  document.getElementById('edit-subject-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    clearErrors(form);

    const id = document.getElementById('edit-id').value;
    const payload = Object.fromEntries(new FormData(form));

    try {
      const res = await fetch(`${BASE}/${id}`, {
        method: 'PUT',
        headers: {'X-CSRF-TOKEN': csrf, 'Accept':'application/json', 'Content-Type':'application/json'},
        body: JSON.stringify(payload)
      });
      if (!res.ok) {
        if (res.status === 422) { const d = await res.json(); showErrors(form, d.errors); return; }
        throw new Error('No se pudo actualizar la asignatura.');
      }
      const updated = await res.json();
      updateRow(updated);
      closeModal('#edit-subject-modal');
      showAlert('Asignatura actualizada correctamente.');
    } catch (err) { showAlert(err.message, 'danger'); }
  });

  // DELETE
  async function deleteSubject(id) {
    if (!confirm('¿Eliminar asignatura?')) return;
    try {
      const res = await fetch(`${BASE}/${id}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': csrf, 'Accept':'application/json'}
      });
      if (!res.ok) throw new Error('No se pudo eliminar la asignatura.');

      const row = document.querySelector(`tr[data-row-id="${id}"]`);
      if (row) row.remove();

      const tbody = document.getElementById('subjects-tbody');
      if (!tbody.querySelector('tr')) {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td colspan="3" class="text-center text-slate-500 py-6">No hay asignaturas registradas.</td>`;
        tbody.appendChild(tr);
      }
      showAlert('Asignatura eliminada correctamente.');
    } catch (err) { showAlert(err.message, 'danger'); }
  }
  window.deleteSubject = deleteSubject;
</script>
@endsection

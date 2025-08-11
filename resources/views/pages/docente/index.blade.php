@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Docentes</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Docentes</h2>

<div class="intro-y flex justify-end mt-5 mb-5">
    <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-professor-modal">
        Nuevo Docente
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
                <th>Email</th>
                <th>Género</th>
                <th>Activo</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="docentes-tbody">
            @forelse ($docentes as $t)
                <tr class="intro-x" data-row-id="{{ $t->id }}">
                    <td class="font-medium">{{ $t->name }}</td>
                    <td>{{ $t->email }}</td>
                    <td>{{ $t->gender ?? '—' }}</td>
                    <td>
                        @if ($t->active) <span class="text-success">Sí</span>
                        @else <span class="text-danger">No</span> @endif
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center gap-2">
                            <button class="btn btn-warning"
                                onclick="editProfessor({{ $t->id }})"
                                data-tw-toggle="modal"
                                data-tw-target="#edit-professor-modal">
                                Editar
                            </button>
                            <button class="btn btn-danger" onclick="deleteProfessor({{ $t->id }})">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-slate-500 py-6">No hay docentes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal: Crear Docente -->
<div id="add-professor-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="add-professor-form">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo docente</h5>
        <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" required placeholder="Nombre y apellido">
            <div class="form-text text-danger d-none" data-error="name"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="correo@colegio.com">
            <div class="form-text text-danger d-none" data-error="email"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required minlength="8" placeholder="mínimo 8 caracteres">
            <div class="form-text text-danger d-none" data-error="password"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Género</label>
            <select name="gender" class="form-select">
                <option value="">— Seleccionar —</option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
                <option value="other">Otro</option>
            </select>
            <div class="form-text text-danger d-none" data-error="gender"></div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="active" id="add-active" class="form-check-input" checked>
            <label for="add-active" class="form-check-label">Activo</label>
            <div class="form-text text-danger d-none" data-error="active"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add-submit" type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div></div>
</div>

<!-- Modal: Editar Docente -->
<div id="edit-professor-modal" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="edit-professor-form">
      @csrf @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Editar docente</h5>
        <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit-id" name="id">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" id="edit-name" name="name" class="form-control" required>
            <div class="form-text text-danger d-none" data-error="name"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" id="edit-email" name="email" class="form-control" required>
            <div class="form-text text-danger d-none" data-error="email"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña (opcional)</label>
            <input type="password" id="edit-password" name="password" class="form-control" minlength="8">
            <div class="form-text text-danger d-none" data-error="password"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Género</label>
            <select id="edit-gender" name="gender" class="form-select">
                <option value="">— Seleccionar —</option>
                <option value="male">Masculino</option>
                <option value="female">Femenino</option>
                <option value="other">Otro</option>
            </select>
            <div class="form-text text-danger d-none" data-error="gender"></div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" id="edit-active" name="active" class="form-check-input">
            <label for="edit-active" class="form-check-label">Activo</label>
            <div class="form-text text-danger d-none" data-error="active"></div>
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
  const BASE = "{{ url('docentes') }}";

  const showAlert = (msg, type = 'success') => {
    const alerts = document.getElementById('alerts');
    const content = document.getElementById('alert-content');
    content.className = `alert ${type === 'success' ? 'alert-success' : 'alert-danger'}`;
    content.textContent = msg;
    alerts.classList.remove('hidden');
    setTimeout(() => alerts.classList.add('hidden'), 3500);
  };

  const closeModal = (id) => {
    const btn = document.querySelector(`${id} [data-tw-dismiss="modal"], ${id} .btn-close`);
    if (btn) btn.click();
  };

  const setLoading = (btn, loading) => {
    if (!btn) return;
    btn.disabled = loading;
    btn.dataset.originalText = btn.dataset.originalText || btn.textContent;
    btn.textContent = loading ? 'Procesando...' : btn.dataset.originalText;
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

  // Añadir fila a la tabla
  const appendRow = (t) => {
    const tbody = document.getElementById('docentes-tbody');
    const empty = tbody.querySelector('tr td[colspan]');
    if (empty) empty.parentElement.remove();

    const tr = document.createElement('tr');
    tr.className = 'intro-x';
    tr.dataset.rowId = t.id;
    tr.innerHTML = `
      <td class="font-medium">${t.name ?? ''}</td>
      <td>${t.email ?? ''}</td>
      <td>${t.gender ?? '—'}</td>
      <td>${t.active ? '<span class="text-success">Sí</span>' : '<span class="text-danger">No</span>'}</td>
      <td class="table-report__action w-56">
        <div class="flex justify-center gap-2">
          <button class="btn btn-warning"
            onclick="editProfessor(${t.id})"
            data-tw-toggle="modal"
            data-tw-target="#edit-professor-modal">
            Editar
          </button>
          <button class="btn btn-danger" onclick="deleteProfessor(${t.id})">Eliminar</button>
        </div>
      </td>
    `;
    tbody.prepend(tr);
  };

  // Actualizar fila existente
  const updateRow = (t) => {
    const row = document.querySelector(`tr[data-row-id="${t.id}"]`);
    if (!row) return;
    row.children[0].textContent = t.name ?? '';
    row.children[1].textContent = t.email ?? '';
    row.children[2].textContent = t.gender ?? '—';
    row.children[3].innerHTML   = t.active ? '<span class="text-success">Sí</span>' : '<span class="text-danger">No</span>';
  };

  // Crear
  document.getElementById('add-professor-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    clearErrors(form);
    const btn = document.getElementById('add-submit');
    setLoading(btn, true);

    const fd = new FormData(form);
    const payload = Object.fromEntries(fd.entries());
    payload.active = form.querySelector('[name="active"]').checked ? true : false;
    if (payload.gender === '') payload.gender = null;

    try {
      const res = await fetch("{{ route('docentes.store') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      if (!res.ok) {
        if (res.status === 422) {
          const data = await res.json();
          showErrors(form, data.errors);
          return;
        }
        throw new Error('No se pudo crear el docente.');
      }
      const created = await res.json();
      appendRow(created);
      form.reset();
      closeModal('#add-professor-modal');
      showAlert('Docente creado correctamente.');
    } catch (err) {
      showAlert(err.message, 'danger');
    } finally {
      setLoading(btn, false);
    }
  });

  // Cargar datos en modal de edición
  async function editProfessor(id) {
    clearErrors(document.getElementById('edit-professor-form'));
    try {
      const res = await fetch(`${BASE}/${id}`, { headers: { 'Accept': 'application/json' }});
      if (!res.ok) throw new Error('No se pudo cargar el docente.');
      const t = await res.json();

      document.getElementById('edit-id').value = t.id;
      document.getElementById('edit-name').value = t.name ?? '';
      document.getElementById('edit-email').value = t.email ?? '';
      document.getElementById('edit-password').value = '';
      document.getElementById('edit-gender').value = t.gender ?? '';
      document.getElementById('edit-active').checked = !!t.active;
    } catch (e) {
      showAlert(e.message, 'danger');
    }
  }
  window.editProfessor = editProfessor;

  // Actualizar
  document.getElementById('edit-professor-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    clearErrors(form);
    const btn = document.getElementById('edit-submit');
    setLoading(btn, true);

    const id = document.getElementById('edit-id').value;
    const fd = new FormData(form);
    const payload = Object.fromEntries(fd.entries());
    payload.active = document.getElementById('edit-active').checked ? true : false;
    if (!payload.password) delete payload.password; // opcional
    if (payload.gender === '') payload.gender = null;

    try {
      const res = await fetch(`${BASE}/${id}`, {
        method: 'PUT',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      if (!res.ok) {
        if (res.status === 422) {
          const data = await res.json();
          showErrors(form, data.errors);
          return;
        }
        throw new Error('No se pudo actualizar el docente.');
      }
      const updated = await res.json();
      updateRow({ id, ...payload, active: payload.active });
      closeModal('#edit-professor-modal');
      showAlert('Docente actualizado correctamente.');
    } catch (err) {
      showAlert(err.message, 'danger');
    } finally {
      setLoading(btn, false);
    }
  });

  // Eliminar
  async function deleteProfessor(id) {
    if (!confirm('¿Eliminar docente?')) return;
    try {
      const res = await fetch(`${BASE}/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
      });
      if (!res.ok) throw new Error('No se pudo eliminar el docente.');

      const row = document.querySelector(`tr[data-row-id="${id}"]`);
      if (row) row.remove();

      const tbody = document.getElementById('docentes-tbody');
      if (!tbody.querySelector('tr')) {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td colspan="5" class="text-center text-slate-500 py-6">No hay docentes registrados.</td>`;
        tbody.appendChild(tr);
      }
      showAlert('Docente eliminado correctamente.');
    } catch (err) {
      showAlert(err.message, 'danger');
    }
  }
  window.deleteProfessor = deleteProfessor;
</script>
@endsection

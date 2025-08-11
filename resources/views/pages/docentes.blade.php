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
            <tbody>
            @forelse ($docentes as $t)
                <tr class="intro-x">
                    <td>{{ $t->name }}</td>
                    <td>{{ $t->email }}</td>
                    <td>{{ $t->gender ?? '—' }}</td>
                    <td>
                        @if ($t->active) <span class="text-success">Sí</span>
                        @else <span class="text-danger">No</span> @endif
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center">
                            <button class="btn btn-warning mr-2"
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
                <tr><td colspan="5" class="text-center text-slate-500">No hay docentes registrados.</td></tr>
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
                    <h5 class="modal-title">Nuevo Docente</h5>
                    <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                        <div class="form-text text-danger d-none" data-error="name"></div>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                        <div class="form-text text-danger d-none" data-error="email"></div>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                        <div class="form-text text-danger d-none" data-error="password"></div>
                    </div>

                    <div class="mb-3">
                        <label>Género</label>
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
                    <h5 class="modal-title">Editar Docente</h5>
                    <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" id="edit-name" name="name" class="form-control" required>
                        <div class="form-text text-danger d-none" data-error="name"></div>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="edit-email" name="email" class="form-control" required>
                        <div class="form-text text-danger d-none" data-error="email"></div>
                    </div>

                    <div class="mb-3">
                        <label>Nueva contraseña (opcional)</label>
                        <input type="password" id="edit-password" name="password" class="form-control" minlength="8">
                        <div class="form-text text-danger d-none" data-error="password"></div>
                    </div>

                    <div class="mb-3">
                        <label>Género</label>
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
        // Ajusta si tu resource se llama distinto:
        const BASE = "{{ url('profesores') }}";

        // Helpers
        function clearErrors(form) {
            form.querySelectorAll('[data-error]').forEach(el => { el.classList.add('d-none'); el.textContent = ''; });
        }
        function showErrors(form, errors) {
            Object.entries(errors || {}).forEach(([field, msgs]) => {
                const holder = form.querySelector(`[data-error="${field}"]`);
                if (holder) { holder.textContent = Array.isArray(msgs) ? msgs[0] : msgs; holder.classList.remove('d-none'); }
            });
        }
        function formToJson(form) {
            const fd = new FormData(form);
            const data = Object.fromEntries(fd.entries());
            // checkbox -> boolean
            data.active = form.querySelector('[name="active"]')?.checked ? true : false;
            // normaliza strings vacíos a null en gender
            if (data.gender === '') data.gender = null;
            // si password vacío en edición, eliminarlo
            if (form.id === 'edit-professor-form' && (!data.password || data.password === '')) delete data.password;
            return data;
        }

        // CREATE
        document.getElementById('add-professor-form').onsubmit = async (e) => {
            e.preventDefault();
            const form = e.target;
            clearErrors(form);
            const payload = formToJson(form);

            try {
                const res = await fetch(BASE, {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json'},
                    body: JSON.stringify(payload)
                });
                if (!res.ok) {
                    if (res.status === 422) {
                        const data = await res.json();
                        showErrors(form, data.errors);
                        return;
                    }
                    throw new Error('Error al crear docente');
                }
                location.reload();
            } catch (err) {
                alert(err.message);
            }
        };

        // READ + OPEN EDIT
        async function editProfessor(id) {
            clearErrors(document.getElementById('edit-professor-form'));
            try {
                const res = await fetch(`${BASE}/${id}`, { headers: {'Accept':'application/json'} });
                if (!res.ok) throw new Error('No se pudo cargar el docente');
                const t = await res.json();

                document.getElementById('edit-id').value = t.id;
                document.getElementById('edit-name').value = t.name ?? '';
                document.getElementById('edit-email').value = t.email ?? '';
                document.getElementById('edit-password').value = '';
                document.getElementById('edit-gender').value = t.gender ?? '';
                document.getElementById('edit-active').checked = !!t.active;
            } catch (err) {
                alert(err.message);
            }
        }

        // UPDATE
        document.getElementById('edit-professor-form').onsubmit = async (e) => {
            e.preventDefault();
            const form = e.target;
            clearErrors(form);
            const id = document.getElementById('edit-id').value;
            const payload = formToJson(form);

            try {
                const res = await fetch(`${BASE}/${id}`, {
                    method: 'PUT',
                    headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json'},
                    body: JSON.stringify(payload)
                });
                if (!res.ok) {
                    if (res.status === 422) {
                        const data = await res.json();
                        showErrors(form, data.errors);
                        return;
                    }
                    throw new Error('Error al actualizar docente');
                }
                location.reload();
            } catch (err) {
                alert(err.message);
            }
        };

        // DELETE
        async function deleteProfessor(id) {
            if (!confirm('¿Eliminar docente?')) return;
            try {
                const res = await fetch(`${BASE}/${id}`, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': csrf, 'Accept':'application/json'}
                });
                if (!res.ok) throw new Error('No se pudo eliminar el docente');
                location.reload();
            } catch (err) {
                alert(err.message);
            }
        }
        window.deleteProfessor = deleteProfessor;
        window.editProfessor = editProfessor;
    </script>
@endsection

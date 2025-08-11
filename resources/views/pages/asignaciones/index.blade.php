@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Asignaciones</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10 uppercase">Asignaciones</h2>

    <div class="intro-y flex justify-end mt-5 mb-5">
        <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-asignacion-modal">
            Nueva Asignación
        </button>
    </div>

    <div class="intro-y overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
            <tr class="uppercase">
                <th>Docente</th>
                <th>Materia</th>
                <th>Salón</th>
                <th>Año</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($asignaciones as $a)
                <tr class="intro-x">
                    <td>{{ $a->teacher->name ?? '—' }}</td>
                    <td>{{ $a->subject->nombre }}</td>
                    <td>{{ $a->salon->nombre }} - {{ $a->salon->grado }}{{ $a->salon->seccion }}</td>
                    <td>{{ $a->year }}</td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center">
                            <button class="btn btn-warning mr-2" onclick="editAsignacion({{ $a->id }})"
                                    data-tw-toggle="modal" data-tw-target="#edit-asignacion-modal">Editar</button>
                            <button class="btn btn-danger" onclick="deleteAsignacion({{ $a->id }})">Eliminar</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            @if($asignaciones->isEmpty())
                <tr><td colspan="5" class="text-center text-slate-500 py-6">No hay asignaciones registradas.</td></tr>
            @endif
            </tbody>
        </table>
    </div>

    <!-- Modal Crear -->
    <div id="add-asignacion-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <form id="add-asignacion-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Asignación</h5>
                    <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body grid grid-cols-1 gap-3">
                    <div>
                        <label>Docente</label>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($docentes as $d)
                                <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Materia</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($subjects as $m)
                                <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Salón</label>
                        <select name="salon_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($salones as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }} - {{ $s->grado }}{{ $s->seccion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Año</label>
                        <input type="number" name="year" class="form-control" value="{{ $year ?? now()->year }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-submit" type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div></div>
    </div>

    <!-- Modal Editar -->
    <div id="edit-asignacion-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <form id="edit-asignacion-form">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Asignación</h5>
                    <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body grid grid-cols-1 gap-3">
                    <input type="hidden" id="edit-asignacion-id" name="id">
                    <div>
                        <label>Docente</label>
                        <select id="edit-asignacion-teacher" name="teacher_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($docentes as $d)
                                <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Materia</label>
                        <select id="edit-asignacion-subject" name="subject_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($subjects as $m)
                                <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Salón</label>
                        <select id="edit-asignacion-salon" name="salon_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($salones as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }} - {{ $s->grado }}{{ $s->seccion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Año</label>
                        <input type="number" id="edit-asignacion-year" name="year" class="form-control" required>
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

        // Crear
        document.getElementById('add-asignacion-form').onsubmit = async (e) => {
            e.preventDefault();
            try {
                const res = await fetch('{{ route("asignaciones.store") }}', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json'},
                    body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
                });
                if (!res.ok) {
                    const data = await res.json().catch(()=>({}));
                    alert(data.message || 'No se pudo crear.');
                    return;
                }
                location.reload();
            } catch (err) { alert(err.message); }
        };

        // Cargar datos para editar
        async function editAsignacion(id) {
    try {
      const r = await fetch(`/asignaciones/${id}`, { headers: {'Accept':'application/json'} });
      if (!r.ok) throw new Error('No se pudo cargar.');
      const a = await r.json();

      // IDs a string para hacer match con los option.value (que son strings)
      const teacherId = String(a.teacher_id ?? '');
      const subjectId = String(a.subject_id ?? '');
      const salonId   = String(a.salon_id ?? '');

      document.getElementById('edit-asignacion-id').value = String(id);
      document.getElementById('edit-asignacion-teacher').value = teacherId;
      document.getElementById('edit-asignacion-subject').value = subjectId;
      document.getElementById('edit-asignacion-salon').value   = salonId;
      document.getElementById('edit-asignacion-year').value    = a.year ?? '';

      // (opcional) dispara change por si usas componentes que escuchan el evento
      document.getElementById('edit-asignacion-teacher').dispatchEvent(new Event('change'));
      document.getElementById('edit-asignacion-subject').dispatchEvent(new Event('change'));
      document.getElementById('edit-asignacion-salon').dispatchEvent(new Event('change'));
    } catch (e) { alert(e.message); }
  }

  // UPDATE: envía JSON correcto, sin el campo "id" del hidden
  document.getElementById('edit-asignacion-form').onsubmit = async (e) => {
    e.preventDefault();
    const id = document.getElementById('edit-asignacion-id').value;

    const fd = new FormData(e.target);
    fd.delete('id'); // <-- evita mandar "id" en el body (innecesario)
    const payload = Object.fromEntries(fd.entries());

    // fuerza tipos a número para evitar problemas de validación (opcional)
    payload.teacher_id = Number(payload.teacher_id);
    payload.subject_id = Number(payload.subject_id);
    payload.salon_id   = Number(payload.salon_id);
    payload.year       = Number(payload.year);

    try {
      const r = await fetch(`/asignaciones/${id}`, {
        method: 'PUT',
        headers: {'X-CSRF-TOKEN': csrf, 'Content-Type':'application/json', 'Accept':'application/json'},
        body: JSON.stringify(payload)
      });
      if (!r.ok) {
        const data = await r.json().catch(()=>({}));
        // Muestra primer error de validación si aplica
        if (r.status === 422 && data?.errors) {
          const first = Object.values(data.errors)[0];
          alert(Array.isArray(first) ? first[0] : first);
          return;
        }
        alert(data.message || 'No se pudo actualizar.');
        return;
      }
      location.reload();
    } catch (e) { alert(e.message); }
  };

        // Actualizar
        document.getElementById('edit-asignacion-form').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit-asignacion-id').value;
            try {
                const r = await fetch(`/asignaciones/${id}`, {
                    method: 'PUT',
                    headers: {'X-CSRF-TOKEN': csrf, 'Content-Type':'application/json', 'Accept':'application/json'},
                    body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
                });
                if (!r.ok) {
                    const data = await r.json().catch(()=>({}));
                    alert(data.message || 'No se pudo actualizar.');
                    return;
                }
                location.reload();
            } catch (e) { alert(e.message); }
        };

        // Eliminar
        async function deleteAsignacion(id) {
            if (!confirm('¿Eliminar asignación?')) return;
            try {
                const r = await fetch(`/asignaciones/${id}`, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': csrf, 'Accept':'application/json'}
                });
                if (!r.ok) {
                    const data = await r.json().catch(()=>({}));
                    alert(data.message || 'No se pudo eliminar.');
                    return;
                }
                location.reload();
            } catch (e) { alert(e.message); }
        }
        window.editAsignacion = editAsignacion;
        window.deleteAsignacion = deleteAsignacion;
    </script>
@endsection

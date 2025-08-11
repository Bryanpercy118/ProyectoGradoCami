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
                    <td>{{ $a->teacher->name ?? $a->teacher->nombre ?? '—' }}</td>
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
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body grid grid-cols-1 gap-3">
                    <div>
                        <label>Docente</label>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($docentes as $d)
                                <option value="{{ $d->id }}">{{ $d->name ?? $d->nombre }} ({{ $d->email }})</option>
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
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body grid grid-cols-1 gap-3">
                    <input type="hidden" id="edit-asignacion-id" name="id">
                    <div>
                        <label>Docente</label>
                        <select id="edit-asignacion-teacher" name="teacher_id" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            @foreach ($docentes as $d)
                                <option value="{{ $d->id }}">{{ $d->name ?? $d->nombre }} ({{ $d->email }})</option>
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
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div></div>
    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        // Crear
        document.getElementById('add-asignacion-form').onsubmit = e => {
            e.preventDefault();
            fetch('{{ route("asignaciones.store") }}', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json'},
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(r => {
                if(!r.ok) return r.json().then(err=>alert(JSON.stringify(err)));
                location.reload();
            });
        };

        // Cargar datos para editar
        function editAsignacion(id) {
            fetch(`/asignaciones/${id}`)
                .then(r=>r.json())
                .then(a => {
                    document.getElementById('edit-asignacion-id').value = id;
                    document.getElementById('edit-asignacion-teacher').value = a.teacher_id;
                    document.getElementById('edit-asignacion-subject').value = a.subject_id;
                    document.getElementById('edit-asignacion-salon').value = a.salon_id;
                    document.getElementById('edit-asignacion-year').value = a.year;
                });
        }

        // Actualizar
        document.getElementById('edit-asignacion-form').onsubmit = e => {
            e.preventDefault();
            const id = document.getElementById('edit-asignacion-id').value;
            fetch(`/asignaciones/${id}`, {
                method: 'PUT',
                headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json'},
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(r => {
                if(!r.ok) return r.json().then(err=>alert(JSON.stringify(err)));
                location.reload();
            });
        };

        // Eliminar
        function deleteAsignacion(id) {
            if (!confirm('¿Eliminar asignación?')) return;
            fetch(`/asignaciones/${id}`, { method: 'DELETE', headers: {'X-CSRF-TOKEN': csrf} })
                .then(()=>location.reload());
        }
    </script>
@endsection

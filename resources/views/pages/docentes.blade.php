@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Docentes</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10 uppercase">Docentes</h2>

    <div class="intro-y flex justify-end mt-5 mb-5">
        <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-teacher-modal">
            Nuevo Docente
        </button>
    </div>

    <div class="intro-y overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead><tr class="uppercase">
                <th>Nombre</th><th>Email</th><th>Teléfono</th><th>Salón</th><th class="text-center">Acciones</th>
            </tr></thead>
            <tbody>
                @foreach ($docentes as $t)
                    <tr class="intro-x">
                        <td>{{ $t->nombre }}</td><td>{{ $t->email }}</td><td>{{ $t->telefono }}</td>
                        <td>{{ $t->salon->nombre }} - {{ $t->salon->grado }}{{ $t->salon->seccion }}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center">
                                <button class="btn btn-warning mr-2" onclick="editTeacher({{ $t->id }})" data-tw-toggle="modal" data-tw-target="#edit-teacher-modal">Editar</button>
                                <button class="btn btn-danger" onclick="deleteTeacher({{ $t->id }})">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modales -->
    <div id="add-teacher-modal" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog"><div class="modal-content">
        <form id="add-teacher-form">
          @csrf
          <div class="modal-header"><h5 class="modal-title">Nuevo Docente</h5><button type="button" class="btn-close" data-dismiss="modal"></button></div>
          <div class="modal-body">
            <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label>Teléfono</label><input type="text" name="telefono" class="form-control" required></div>
            <div class="mb-3"><label>Salón</label>
              <select name="salon_id" class="form-select" required>
                <option value="">-- Seleccionar --</option>
                @foreach ($salones as $s)
                  <option value="{{ $s->id }}">{{ $s->nombre }} - {{ $s->grado }}{{ $s->seccion }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-primary">Guardar</button><button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button></div>
        </form>
      </div></div>
    </div>

    <div id="edit-teacher-modal" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog"><div class="modal-content">
        <form id="edit-teacher-form">
          @csrf @method('PUT')
          <div class="modal-header"><h5 class="modal-title">Editar Docente</h5><button type="button" class="btn-close" data-dismiss="modal"></button></div>
          <div class="modal-body">
            <input type="hidden" id="edit-teacher-id" name="id">
            <div class="mb-3"><label>Nombre</label><input type="text" id="edit-teacher-nombre" name="nombre" class="form-control" required></div>
            <div class="mb-3"><label>Email</label><input type="email" id="edit-teacher-email" name="email" class="form-control" required></div>
            <div class="mb-3"><label>Teléfono</label><input type="text" id="edit-teacher-telefono" name="telefono" class="form-control" required></div>
            <div class="mb-3"><label>Salón</label>
              <select id="edit-teacher-salon" name="salon_id" class="form-select" required>
                <option value="">-- Seleccionar --</option>
                @foreach ($salones as $s)
                  <option value="{{ $s->id }}">{{ $s->nombre }} - {{ $s->grado }}{{ $s->seccion }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-primary">Actualizar</button><button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button></div>
        </form>
      </div></div>
    </div>

    <script>
      const csrf = document.querySelector('meta[name="csrf-token"]').content;

      document.getElementById('add-teacher-form').onsubmit = e => {
        e.preventDefault();
        fetch('{{ route("docentes.store") }}', {
          method: 'POST',
          headers: {'X-CSRF-TOKEN': csrf,'Content-Type':'application/json'},
          body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
        }).then(()=>location.reload());
      };

      function editTeacher(id) {
        fetch(`/docentes/${id}`).then(r=>r.json()).then(t => {
          document.getElementById('edit-teacher-id').value = id;
          document.getElementById('edit-teacher-nombre').value = t.nombre;
          document.getElementById('edit-teacher-email').value = t.email;
          document.getElementById('edit-teacher-telefono').value = t.telefono;
          document.getElementById('edit-teacher-salon').value = t.salon_id;
        });
      }

      document.getElementById('edit-teacher-form').onsubmit = e => {
        e.preventDefault();
        const id = document.getElementById('edit-teacher-id').value;
        fetch(`/docentes/${id}`, {
          method: 'PUT',
          headers: {'X-CSRF-TOKEN': csrf,'Content-Type':'application/json'},
          body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
        }).then(()=>location.reload());
      };

      function deleteTeacher(id) {
        if (!confirm('¿Eliminar docente?')) return;
        fetch(`/docentes/${id}`, {
          method: 'DELETE',
          headers: {'X-CSRF-TOKEN': csrf}
        }).then(()=>location.reload());
      }
    </script>
@endsection

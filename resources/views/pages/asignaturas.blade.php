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

    <div class="intro-y overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead><tr class="uppercase">
                <th>Nombre</th><th>Descripción</th><th class="text-center">Acciones</th>
            </tr></thead>
            <tbody>
                @foreach ($asignaturas as $s)
                    <tr class="intro-x">
                        <td>{{ $s->nombre }}</td><td>{{ $s->descripcion }}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center">
                                <button class="btn btn-warning mr-2" onclick="editSubject({{ $s->id }})" data-tw-toggle="modal" data-tw-target="#edit-subject-modal">Editar</button>
                                <button class="btn btn-danger" onclick="deleteSubject({{ $s->id }})">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modales -->
    <div id="add-subject-modal" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog"><div class="modal-content">
        <form id="add-subject-form">
          @csrf
          <div class="modal-header"><h5 class="modal-title">Nueva Asignatura</h5><button type="button" class="btn-close" data-dismiss="modal"></button></div>
          <div class="modal-body">
            <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="mb-3"><label>Descripción</label><textarea name="descripcion" class="form-control"></textarea></div>
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-primary">Guardar</button><button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button></div>
        </form>
      </div></div>
    </div>

    <div id="edit-subject-modal" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog"><div class="modal-content">
        <form id="edit-subject-form">
          @csrf @method('PUT')
          <div class="modal-header"><h5 class="modal-title">Editar Asignatura</h5><button type="button" class="btn-close" data-dismiss="modal"></button></div>
          <div class="modal-body">
            <input type="hidden" id="edit-subject-id" name="id">
            <div class="mb-3"><label>Nombre</label><input type="text" id="edit-subject-nombre" name="nombre" class="form-control" required></div>
            <div class="mb-3"><label>Descripción</label><textarea id="edit-subject-descripcion" name="descripcion" class="form-control"></textarea></div>
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-primary">Actualizar</button><button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button></div>
        </form>
      </div></div>
    </div>

    <script>
      const csrf = document.querySelector('meta[name="csrf-token"]').content;

      document.getElementById('add-subject-form').onsubmit = e => {
        e.preventDefault();
        fetch('{{ route("asignaturas.store") }}', {
          method: 'POST',
          headers: {'X-CSRF-TOKEN': csrf,'Content-Type':'application/json'},
          body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
        }).then(()=>location.reload());
      };

      function editSubject(id) {
        fetch(`/asignaturas/${id}`).then(r=>r.json()).then(s => {
          document.getElementById('edit-subject-id').value = id;
          document.getElementById('edit-subject-nombre').value = s.nombre;
          document.getElementById('edit-subject-descripcion').value = s.descripcion;
        });
      }

      document.getElementById('edit-subject-form').onsubmit = e => {
        e.preventDefault();
        const id = document.getElementById('edit-subject-id').value;
        fetch(`/asignaturas/${id}`, {
          method: 'PUT',
          headers: {'X-CSRF-TOKEN': csrf,'Content-Type':'application/json'},
          body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
        }).then(()=>location.reload());
      };

      function deleteSubject(id) {
        if (!confirm('¿Eliminar asignatura?')) return;
        fetch(`/asignaturas/${id}`, {
          method: 'DELETE',
          headers: {'X-CSRF-TOKEN': csrf}
        }).then(()=>location.reload());
      }
    </script>
@endsection

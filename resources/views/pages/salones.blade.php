@extends('../layout/' . $layout)

@section('subhead')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Salones</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10 uppercase">Salones</h2>

    <div class="intro-y flex justify-end mt-5 mb-5">
        <button class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#add-salon-modal">
            Nuevo Salón
        </button>
    </div>

    <div class="intro-y overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="uppercase">
                    <th>Nombre</th>
                    <th>Grado</th>
                    <th>Sección</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salones as $salon)
                    <tr class="intro-x">
                        <td>{{ $salon->nombre }}</td>
                        <td>{{ $salon->grado }}</td>
                        <td>{{ $salon->seccion }}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center">
                                <button class="btn btn-warning mr-2" onclick="editSalon({{ $salon->id }})" data-tw-toggle="modal" data-tw-target="#edit-salon-modal">Editar</button>
                                <button class="btn btn-danger" onclick="deleteSalon({{ $salon->id }})">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal: Crear salón -->
    <div id="add-salon-modal" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog"><div class="modal-content">
        <form id="add-salon-form">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Nuevo Salón</h5>
            <button type="button" class="btn-close" data-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3"><label class="form-label">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Grado</label><input type="text" name="grado" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Sección</label><input type="text" name="seccion" class="form-control" required></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div></div>
    </div>

    <!-- Modal: Editar salón -->
    <div id="edit-salon-modal" class="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog"><div class="modal-content">
        <form id="edit-salon-form">
          @csrf @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title">Editar Salón</h5>
            <button type="button" class="btn-close" data-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit-salon-id">
            <div class="mb-3"><label class="form-label">Nombre</label><input type="text" name="nombre" id="edit-salon-nombre" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Grado</label><input type="text" name="grado" id="edit-salon-grado" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Sección</label><input type="text" name="seccion" id="edit-salon-seccion" class="form-control" required></div>
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
      document.getElementById('add-salon-form').onsubmit = e => {
        e.preventDefault();
        fetch('{{ route("salones.store") }}', {
          method: 'POST',
          headers: {'X-CSRF-TOKEN': csrf,'Content-Type':'application/json'},
          body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
        }).then(()=>location.reload());
      };

      function editSalon(id) {
        fetch(`/salones/${id}`).then(r=>r.json()).then(s=> {
          document.getElementById('edit-salon-id').value=id;
          document.getElementById('edit-salon-nombre').value=s.nombre;
          document.getElementById('edit-salon-grado').value=s.grado;
          document.getElementById('edit-salon-seccion').value=s.seccion;
        });
      }

      document.getElementById('edit-salon-form').onsubmit = e => {
        e.preventDefault();
        const id = document.getElementById('edit-salon-id').value;
        fetch(`/salones/${id}`, {
          method: 'PUT',
          headers: {'X-CSRF-TOKEN': csrf,'Content-Type':'application/json'},
          body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
        }).then(()=>location.reload());
      };

      function deleteSalon(id) {
        if (!confirm('¿Eliminar salón?')) return;
        fetch(`/salones/${id}`, {
          method: 'DELETE',
          headers: {'X-CSRF-TOKEN': csrf}
        }).then(()=>location.reload());
      }
    </script>
@endsection

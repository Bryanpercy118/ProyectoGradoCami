@extends('../layout/' . $layout)

@section('subhead')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Nueva Matrícula</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Nueva Matrícula</h2>

<div class="box p-5 mt-5">
  @if($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form id="matricula-form" class="grid gap-4">
    @csrf
    <input type="hidden" name="aspirante_id" value="{{ $aspirante->id ?? '' }}">
    <input type="hidden" name="preinscripcion_id" value="{{ $aspirante->preinscripcion_id ?? '' }}">

    <div>
      <label class="form-label">Nombre del estudiante</label>
      <input type="text" name="nombre_estudiante" class="form-control"
             value="{{ $aspirante->nombre_estudiante ?? '' }}" required>
    </div>

    <div>
      <label class="form-label">Email del estudiante</label>
      <input type="email" name="email" class="form-control"
             value="{{ $aspirante->correo_acudiente ?? '' }}" placeholder="correo@colegio.edu" required>
      <small class="text-slate-500">Puedes usar el correo institucional del alumno.</small>
    </div>

    <div class="grid grid-cols-12 gap-4">
      <div class="col-span-12 md:col-span-6">
        <label class="form-label">Salón</label>
        <select name="salon_id" class="form-select" required>
          <option value="">-- Seleccionar --</option>
          @foreach($salones as $s)
            <option value="{{ $s->id }}"
              @if(isset($aspirante) && $aspirante->salon_id == $s->id) selected @endif>
              {{ $s->nombre }} — {{ $s->grado }}{{ $s->seccion }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-span-12 md:col-span-3">
        <label class="form-label">Año</label>
        <input type="number" name="year" class="form-control" value="{{ $year }}" required>
      </div>
      <div class="col-span-12 md:col-span-3">
        <label class="form-label">Folio (opcional)</label>
        <input type="text" name="folio" class="form-control" placeholder="Folio/Acta">
      </div>
    </div>

    <div>
      <label class="form-label">Observaciones</label>
      <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas internas"></textarea>
    </div>

    <div class="flex justify-end gap-2 mt-4">
      <a href="{{ route('matriculas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary">Confirmar Matrícula</button>
    </div>
  </form>
</div>

<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;
document.getElementById('matricula-form').addEventListener('submit', function(e){
  e.preventDefault();
  const payload = Object.fromEntries(new FormData(this));

  fetch('{{ route("matriculas.store") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    body: JSON.stringify(payload)
  })
  .then(async r => { if(!r.ok){ const err=await r.text(); throw err; } return r.json(); })
  .then(data => {
    window.location.href = `/matriculas/${data.id}`;
  })
  .catch(err => { alert('Error al matricular: ' + err); });
});
</script>
@endsection

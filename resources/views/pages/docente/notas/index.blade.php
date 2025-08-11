@extends('../layout/' . $layout)

@section('subhead')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Gestión de Notas</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Gestión de Notas</h2>

<div class="box p-5 mt-5">
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-12 md:col-span-6">
      <label class="form-label">Mi asignación ({{ $year }})</label>
      <select id="asignacion_id" class="form-select" required>
        <option value="">-- Seleccionar --</option>
        @foreach($asignaciones as $a)
          <option value="{{ $a->id }}">
            {{ $a->salon->nombre }} — {{ $a->salon->grado }}{{ $a->salon->seccion }} | {{ $a->subject->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-span-12 md:col-span-4">
      <label class="form-label">Periodo</label>
      <select id="periodo_id" class="form-select" required>
        <option value="">-- Seleccionar --</option>
        @foreach($periodos as $p)
          <option value="{{ $p->id }}">
            {{ $p->nombre }} ({{ \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m') }}–{{ \Carbon\Carbon::parse($p->fecha_fin)->format('d/m') }})
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-span-12 md:col-span-2 flex items-end">
      <button id="btn-ir" class="btn btn-primary w-full">Continuar</button>
    </div>
  </div>
</div>

<script>
document.getElementById('btn-ir').addEventListener('click', function(){
  const a = document.getElementById('asignacion_id').value;
  const p = document.getElementById('periodo_id').value;
  if(!a || !p){ alert('Seleccione asignación y periodo'); return; }
  window.location.href = `{{ route('docente.notas.cargar') }}?asignacion_id=${a}&periodo_id=${p}`;
});
</script>
@endsection

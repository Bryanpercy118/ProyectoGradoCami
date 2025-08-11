@extends('../layout/' . $layout)

@section('subhead')
<title>Matrícula #{{ $matricula->id }}</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Matrícula #{{ $matricula->id }}</h2>

<div class="grid grid-cols-12 gap-6 mt-5">
  <div class="col-span-12 md:col-span-6">
    <div class="box p-5">
      <div class="text-slate-500 mb-2">Alumno</div>
      <div class="text-xl font-semibold">{{ $matricula->alumno->name }}</div>
      <div class="text-slate-600">{{ $matricula->alumno->email }}</div>
    </div>
  </div>

  <div class="col-span-12 md:col-span-6">
    <div class="box p-5">
      <div class="text-slate-500 mb-2">Salón / Año</div>
      <div class="text-xl font-semibold">{{ $matricula->salon->nombre }} — {{ $matricula->salon->grado }}{{ $matricula->salon->seccion }}</div>
      <div class="text-slate-600">Año: {{ $matricula->year }}</div>
    </div>
  </div>

  <div class="col-span-12 md:col-span-4">
    <div class="box p-5">
      <div class="text-slate-500">Estado</div>
      <div class="text-xl font-semibold mt-1">
        <span class="badge {{ $matricula->estado==='matriculado'?'badge-success':'badge-warning' }}">{{ $matricula->estado }}</span>
      </div>
    </div>
  </div>

  <div class="col-span-12 md:col-span-4">
    <div class="box p-5">
      <div class="text-slate-500">Folio</div>
      <div class="text-xl font-semibold mt-1">{{ $matricula->folio ?? '—' }}</div>
    </div>
  </div>

  <div class="col-span-12 md:col-span-4">
    <div class="box p-5">
      <div class="text-slate-500">Origen</div>
      <div class="mt-1">
        @if($matricula->aspirante)
          Aspirante #{{ $matricula->aspirante->id }} ({{ $matricula->aspirante->nombre_estudiante }})
        @else
          — 
        @endif
      </div>
    </div>
  </div>

  <div class="col-span-12">
    <div class="box p-5">
      <div class="text-slate-500 mb-2">Observaciones</div>
      <div class="whitespace-pre-wrap">{{ $matricula->observaciones ?? '—' }}</div>
    </div>
  </div>
</div>

<div class="mt-6">
  <a href="{{ route('matriculas.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>
@endsection

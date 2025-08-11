@extends('../layout/' . $layout)

@section('subhead')
<title>Mis Notas</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Mis Notas</h2>

<div class="box p-5 mt-5">
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-12 md:col-span-6">
      <div class="text-slate-500">Año</div>
      <div class="font-semibold">{{ $year }}</div>
    </div>
    <div class="col-span-12 md:col-span-6">
      <div class="text-slate-500">Salón</div>
      <div class="font-semibold">
        {{ $matricula->salon->nombre }} — {{ $matricula->salon->grado }}{{ $matricula->salon->seccion }}
      </div>
    </div>
  </div>
</div>

<div class="box p-5 mt-5">
  <div class="intro-y overflow-auto">
    <table class="table table-report">
      <thead>
        <tr class="uppercase">
          <th>Asignatura</th>
          @foreach ($periodos as $p)
            <th class="text-center">
              {{ $p->nombre }}
              <div class="text-xs text-slate-500">
                {{ \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m') }}–{{ \Carbon\Carbon::parse($p->fecha_fin)->format('d/m') }}
              </div>
            </th>
          @endforeach
          <th class="text-center">Promedio</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($subjects as $s)
          <tr>
            <td class="font-medium">{{ $s->nombre }}</td>

            @foreach ($periodos as $p)
              @php
                $valor = $notasMap[$s->id][$p->id] ?? null;
                $esActual = $periodoActualId === $p->id;
              @endphp
              <td class="text-center {{ $esActual ? 'bg-slate-50 font-semibold' : '' }}">
                @if ($valor !== null)
                  {{ number_format($valor, 2) }}
                @else
                  <span class="text-slate-400">—</span>
                @endif
              </td>
            @endforeach

            <td class="text-center font-semibold">
              @if (!is_null($promedios[$s->id]))
                {{ number_format($promedios[$s->id], 2) }}
              @else
                <span class="text-slate-400">—</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="{{ 2 + $periodos->count() }}" class="text-center text-slate-500 py-6">
              No hay asignaturas configuradas para tu salón.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

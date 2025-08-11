@extends('../layout/' . $layout)

@section('subhead')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Matrículas</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Matrículas</h2>

<div class="intro-y flex justify-end mt-5 mb-5">
  <a href="{{ route('matriculas.create') }}" class="btn btn-primary">Nueva Matrícula</a>
</div>

<div class="intro-y overflow-auto">
  <table class="table table-report">
    <thead>
      <tr class="uppercase">
        <th>Alumno</th>
        <th>Email</th>
        <th>Salón</th>
        <th>Año</th>
        <th>Estado</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($matriculas as $m)
        <tr>
          <td>{{ $m->alumno->name }}</td>
          <td>{{ $m->alumno->email }}</td>
          <td>{{ $m->salon->nombre }} — {{ $m->salon->grado }}{{ $m->salon->seccion }}</td>
          <td>{{ $m->year }}</td>
          <td><span class="badge {{ $m->estado === 'matriculado' ? 'badge-success' : 'badge-warning' }}">{{ $m->estado }}</span></td>
          <td class="text-center">
            <a href="{{ route('matriculas.show', $m->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-slate-500 py-6">Sin matrículas aún.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

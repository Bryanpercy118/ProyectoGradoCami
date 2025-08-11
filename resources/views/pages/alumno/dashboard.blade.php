{{-- resources/views/pages/alumno/dashboard.blade.php --}}
@extends('../layout/' . $layout)

@section('subhead')
    <title>Mi Panel</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Mi Panel</h2>

<div class="grid grid-cols-12 gap-6 mt-5">
    {{-- Tarjeta de salón --}}
    <div class="col-span-12 lg:col-span-4">
        <div class="box p-5">
            <div class="text-slate-500">Mi salón ({{ $year }})</div>
            <div class="text-2xl font-semibold mt-1">
                {{ $matricula->salon->nombre }}
            </div>
            <div class="text-slate-600">
                {{ $matricula->salon->grado }}{{ $matricula->salon->seccion }}
            </div>
        </div>
    </div>

    {{-- Tarjeta de resumen --}}
    <div class="col-span-12 lg:col-span-8">
        <div class="box p-5">
            <div class="text-slate-500">Resumen</div>
            <div class="mt-2">
                <span class="font-semibold">{{ $asignaciones->count() }}</span> asignaturas asignadas
            </div>
        </div>
    </div>
</div>

{{-- Tabla: Asignaturas y docentes --}}
<div class="intro-y mt-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-medium">Mis asignaturas y docentes</h3>
    </div>

    <div class="intro-y overflow-auto">
        <table class="table table-report">
            <thead>
                <tr class="uppercase">
                    <th>Asignatura</th>
                    <th>Docente</th>
                    <th>Contacto</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($asignaciones as $a)
                    <tr>
                        <td class="font-medium">{{ $a->subject->nombre }}</td>
                        <td>{{ $a->teacher->name }}</td>
                        <td class="text-slate-600">{{ $a->teacher->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-slate-500 py-6">
                            Aún no hay asignaciones cargadas para tu salón en {{ $year }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

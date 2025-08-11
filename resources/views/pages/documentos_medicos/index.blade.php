@extends('../layout/' . $layout)

@section('subhead')
    <title>Gestión de Documentos Médicos</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10 uppercase">Gestión de Documentos Médicos</h2>

{{-- Alerts --}}
@if(session('success'))
  <div class="alert alert-success mt-4">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger mt-4">
      <ul class="ml-4 list-disc">
          @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
  </div>
@endif

<div class="grid grid-cols-12 gap-6 mt-6">
  {{-- Formulario de carga --}}
  <div class="intro-y col-span-12 lg:col-span-4">
    <div class="box p-5">
      <h3 class="font-medium mb-4">Subir nuevo documento (PDF)</h3>
      @include('pages/documentos_medicos.partials._form')
    </div>
  </div>

  {{-- Listado --}}
  <div class="intro-y col-span-12 lg:col-span-8">
    <div class="box p-5">
      <h3 class="font-medium mb-4">Mis documentos</h3>
      @include('pages/documentos_medicos.partials._table', ['docs' => $docs])
    </div>
  </div>
</div>

{{-- Modal opcional para ayuda / requisitos --}}
@include('pages/documentos_medicos.partials._modal_ayuda')

@endsection

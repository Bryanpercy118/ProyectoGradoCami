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
      <div class="text-slate-500">Asignación</div>
      <div class="font-semibold">{{ $asignacion->salon->nombre }} — {{ $asignacion->salon->grado }}{{ $asignacion->salon->seccion }}</div>
      <div class="text-slate-600">{{ $asignacion->subject->nombre }} | Año {{ $year }}</div>
    </div>
    <div class="col-span-12 md:col-span-6">
      <div class="text-slate-500">Periodo</div>
      <div class="font-semibold">{{ $periodo->nombre }}</div>
      <div class="text-slate-600">
        {{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }} –
        {{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}
        @if($abierto)
          <span class="badge badge-success ml-2">Abierto</span>
        @else
          <span class="badge badge-danger ml-2">Cerrado</span>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="box p-5 mt-5">
  <div id="alert-ventana" class="alert alert-danger mb-4" style="display: none;">
    El periodo está cerrado. No es posible cargar notas. Contacte al administrador.
  </div>

  <div class="intro-y overflow-auto">
    <table class="table table-report">
      <thead>
        <tr class="uppercase">
          <th>Estudiante</th>
          <th>Email</th>
          <th class="text-center">Nota (0–5)</th>
        </tr>
      </thead>
      <tbody id="tbody-alumnos"></tbody>
    </table>
  </div>

  <div class="flex justify-end mt-4">
    <button id="btn-guardar" class="btn btn-primary">Guardar Notas</button>
  </div>
</div>

<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;
const asignacion_id = {{ $asignacion->id }};
const periodo_id = {{ $periodo->id }};

const tbody = document.getElementById('tbody-alumnos');
const btnGuardar = document.getElementById('btn-guardar');
const alertVentana = document.getElementById('alert-ventana');

let escala = {min:0, max:5, step:0.1};
let abierto = false;

// Render con input disabled cuando ya existe nota
function render(alumnos, notas) {
  tbody.innerHTML = '';
  alumnos.forEach(a => {
    const existe = !!(notas[a.estudiante_id]?.nota ?? null);
    const valor  = existe ? Number(notas[a.estudiante_id].nota).toFixed(2) : '';

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="font-medium">${a.nombre}</td>
      <td class="text-slate-600">${a.email ?? ''}</td>
      <td class="text-center">
        <input
          type="number"
          class="form-control w-32 mx-auto text-center ${existe ? 'bg-slate-100' : ''}"
          name="nota_${a.estudiante_id}"
          value="${valor}"
          min="${escala.min}" max="${escala.max}" step="${escala.step}"
          ${existe ? 'disabled title="Ya cuenta con nota en este periodo"' : ''}
        >
      </td>
    `;
    tbody.appendChild(tr);
  });

  const hayHabilitados = !!tbody.querySelector('input[type="number"]:not([disabled])');
  btnGuardar.disabled = !abierto || !hayHabilitados;
}

function cargarData() {
  const url = `{{ route('docente.notas.data') }}?asignacion_id=${asignacion_id}&periodo_id=${periodo_id}`;
  fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json())
    .then(data => {
      escala = data.escala;
      abierto = data.abierto;
      alertVentana.style.display = abierto ? 'none' : 'block';
      render(data.alumnos, data.notas);
    })
    .catch(() => { alert('No se pudo cargar la información'); });
}

btnGuardar.addEventListener('click', () => {
  if (!abierto) return;

  // Solo recolectar inputs sin nota previa (no disabled)
  const inputs = tbody.querySelectorAll('input[type="number"]:not([disabled])');
  const items = [];
  inputs.forEach(inp => {
    const m = inp.name.match(/^nota_(\d+)$/);
    if (!m) return;
    const estudiante_id = parseInt(m[1], 10);
    const val = inp.value.trim();
    if (val !== '') items.push({estudiante_id, nota: parseFloat(val)});
  });

  if (items.length === 0) {
    alert('No hay notas nuevas para guardar.');
    return;
  }

  fetch(`{{ route('docente.notas.guardar') }}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrf,
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({ asignacion_id, periodo_id, items })
  })
  .then(async r => {
    if (!r.ok) throw new Error(await r.text());
    return r.json();
  })
  .then(() => {
    const toast = document.createElement('div');
    toast.className = 'fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow z-50';
    toast.innerText = 'Notas guardadas';
    document.body.appendChild(toast);
    setTimeout(()=>toast.remove(), 2500);
    cargarData(); // refresca y bloquea las recién creadas
  })
  .catch(err => alert('No se pudieron guardar las notas: ' + err.message));
});

cargarData();
</script>
@endsection

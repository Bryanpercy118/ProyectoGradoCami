<form action="{{ route('meddocs.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label for="titulo" class="form-label">Título del documento</label>
    <input type="text" id="titulo" name="titulo" class="form-control" maxlength="150" required
           placeholder="Ej: Certificado médico">
  </div>

  <div class="mb-3">
    <label for="categoria" class="form-label">Categoría (opcional)</label>
    <select id="categoria" name="categoria" class="form-select">
      <option value="">Selecciona una opción</option>
      <option value="certificado">Certificado</option>
      <option value="informe">Informe</option>
      <option value="receta">Receta</option>
      <option value="otro">Otro</option>
    </select>
  </div>

  <div class="mb-4">
    <label for="archivo" class="form-label">Archivo PDF</label>
    <input type="file" id="archivo" name="archivo" class="form-control" accept="application/pdf" required>
    <small class="form-help text-slate-500">Formato: PDF — Máx. 10 MB.</small>
  </div>

  <div class="flex items-center gap-3">
    <button type="submit" class="btn btn-primary">Subir documento</button>
    <button type="button" class="btn btn-outline-secondary" data-tw-toggle="modal" data-tw-target="#ayuda-docs">
      Requisitos
    </button>
  </div>
</form>

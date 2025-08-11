<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscripciones - Colegio Salomon del Norte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 font-sans text-gray-800">
    <!-- Navbar -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <i class="fas fa-graduation-cap text-2xl"></i>
                <span class="font-bold text-xl">Colegio Salomon del Norte</span>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="/" class="hover:text-blue-200">Inicio</a>
                <a href="/inscripcion" class="hover:text-blue-200 underline font-semibold">Admisiones</a>
            </div>
        </div>
    </nav>

    <!-- Intro Section -->
    <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-20">
        <div class="container mx-auto px-6 text-center max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                ¿Listo para inscribirte en una nueva experiencia educativa?
            </h1>
            <p class="text-lg md:text-xl mb-8">
                Únete al Colegio Salomon del Norte y forma parte de una comunidad académica comprometida con la excelencia.
            </p>
            <button onclick="openModal()"
                class="bg-white text-blue-800 font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition duration-300">
                Inscribirse Ahora
            </button>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Beneficios de Ingresar a Nuestra Escuela</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 mb-4"><i class="fas fa-star text-4xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3">Excelencia Académica</h3>
                    <p class="text-gray-600">Currículo sólido y actualizado que promueve el pensamiento crítico y el desarrollo integral.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 mb-4"><i class="fas fa-shield-alt text-4xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3">Ambiente Seguro y Acogedor</h3>
                    <p class="text-gray-600">Entorno seguro, inclusivo y respetuoso donde cada estudiante se siente valorado.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 mb-4"><i class="fas fa-users text-4xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3">Desarrollo Personal</h3>
                    <p class="text-gray-600">Fomentamos liderazgo y responsabilidad mediante actividades extracurriculares.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-gray-200">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-blue-800 mb-6">¿Por qué elegir el Colegio Salomon del Norte?</h2>
                <p class="text-lg text-gray-700 mb-10">Educación que potencia lo académico, emocional y social para afrontar el futuro con confianza.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="mb-4 text-blue-700"><i class="fas fa-book-open text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-2">Metodologías Innovadoras</h3>
                    <p class="text-gray-600">Aprendizaje activo, curiosidad y resolución de problemas.</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="mb-4 text-blue-700"><i class="fas fa-heart text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-2">Acompañamiento Personalizado</h3>
                    <p class="text-gray-600">Atención individual para necesidades y talentos.</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="mb-4 text-blue-700"><i class="fas fa-globe-americas text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-2">Formación Integral</h3>
                    <p class="text-gray-600">Valores, habilidades sociales y conciencia global.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative overflow-y-auto max-h-screen">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <h2 class="text-2xl font-bold text-blue-800 mb-6 text-center">Formulario de Inscripción</h2>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-50 text-red-700 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('aspirantes.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="preinscripcion_id" value="{{ $preinscripcion->id }}">

                <div>
                    <label class="font-semibold">Nombre del estudiante</label>
                    <input type="text" name="nombre_estudiante" value="{{ old('nombre_estudiante') }}" required class="w-full px-4 py-2 border rounded" />
                </div>

                <div>
                    <label class="font-semibold">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required class="w-full px-4 py-2 border rounded" />
                </div>

                <div>
                    <label class="font-semibold">¿El estudiante presenta alguna discapacidad?</label>
                    <select name="discapacidad" id="discapacidad" class="w-full px-4 py-2 border rounded">
                        <option value="">No</option>
                        <option value="Visual" {{ old('discapacidad')==='Visual'?'selected':'' }}>Visual</option>
                        <option value="Auditiva" {{ old('discapacidad')==='Auditiva'?'selected':'' }}>Auditiva</option>
                        <option value="Motora" {{ old('discapacidad')==='Motora'?'selected':'' }}>Motora</option>
                        <option value="Cognitiva" {{ old('discapacidad')==='Cognitiva'?'selected':'' }}>Cognitiva</option>
                        <option value="Otra" {{ old('discapacidad')==='Otra'?'selected':'' }}>Otra</option>
                    </select>
                </div>

                <div id="otra-discapacidad" class="hidden">
                    <label class="font-semibold">Describa la discapacidad</label>
                    <input type="text" id="otra_discapacidad_texto" placeholder="Especificar discapacidad" class="w-full px-4 py-2 border rounded" />
                </div>

                <!-- SALÓN (solicitud de cupo) -->
                <div>
                    <label class="font-semibold">Salón al que postula</label>
                    <select name="salon_id" id="salon_id" required class="w-full px-4 py-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach($cupos as $c)
                            @php
                                $label = "{$c->salon->nombre} - {$c->salon->grado}{$c->salon->seccion}";
                                $disabled = $c->disponibles <= 0 ? 'disabled' : '';
                                $selected = old('salon_id') == $c->salon_id ? 'selected' : '';
                            @endphp
                            <option value="{{ $c->salon_id }}"
                                    data-grado="{{ $c->salon->grado }}"
                                    data-seccion="{{ $c->salon->seccion }}"
                                    data-label="{{ $label }}"
                                    {{ $disabled }} {{ $selected }}>
                                {{ $label }} — Cupos disp.: {{ $c->disponibles }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Solo salones con cupos configurados para esta preinscripción.</p>
                </div>

                <!-- Grado solicitado (autocompletado y requerido por tu controlador) -->
                <div>
                    <label class="font-semibold">Grado solicitado</label>
                    <input type="text" id="grado_solicitado" name="grado_solicitado"
                           value="{{ old('grado_solicitado') }}"
                           class="w-full px-4 py-2 border rounded" readonly required
                           placeholder="Seleccione un salón arriba" />
                </div>

                <div>
                    <label class="font-semibold">Nombre del acudiente</label>
                    <input type="text" name="nombre_acudiente" value="{{ old('nombre_acudiente') }}" required class="w-full px-4 py-2 border rounded" />
                </div>

                <div>
                    <label class="font-semibold">Correo del acudiente</label>
                    <input type="email" name="correo_acudiente" value="{{ old('correo_acudiente') }}" required class="w-full px-4 py-2 border rounded" />
                </div>

                <div>
                    <label class="font-semibold">Teléfono del acudiente</label>
                    <input type="text" name="telefono_acudiente" value="{{ old('telefono_acudiente') }}" required class="w-full px-4 py-2 border rounded" />
                </div>

                <div>
                    <label class="font-semibold">Información adicional (opcional)</label>
                    <textarea name="datos_acudiente" rows="3" class="w-full px-4 py-2 border rounded" placeholder="Información relevante">{{ old('datos_acudiente') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-800 text-white py-3 rounded hover:bg-blue-900 transition">
                    Enviar Inscripción
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Colegio Salomon del Norte</h3>
                    <p class="text-gray-400 mb-4">123 Education Avenue<br> Springfield, ST 12345</p>
                    <p class="text-gray-400 mb-4">
                        <i class="fas fa-phone-alt mr-2"></i> (555) 123-4567<br>
                        <i class="fas fa-envelope mr-2"></i> info@colegiosalomon.edu
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Calendario</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Directorio</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Menú</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Padres</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Estudiantes</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Recursos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Biblioteca</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Atletismo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Clubes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Consejería</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Alumno</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Conéctate</h3>
                    <div class="flex space-x-4 mb-6">
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <h4 class="font-bold mb-2">Newsletter</h4>
                    <div class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l-lg text-gray-900 w-full">
                        <button class="bg-blue-600 px-4 py-2 rounded-r-lg hover:bg-blue-700">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; 2025 Colegio Salomon Norte. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function openModal() { document.getElementById('modal').classList.remove('hidden'); }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); }

        const selectDiscapacidad = document.getElementById('discapacidad');
        const otraDiscapacidad = document.getElementById('otra-discapacidad');
        const otraInput = document.getElementById('otra_discapacidad_texto');

        if (selectDiscapacidad) {
            const toggleOtra = () => {
                if (selectDiscapacidad.value === 'Otra') {
                    otraDiscapacidad.classList.remove('hidden');
                    otraInput.setAttribute('name', 'discapacidad');
                } else {
                    otraDiscapacidad.classList.add('hidden');
                    otraInput.removeAttribute('name');
                }
            };
            selectDiscapacidad.addEventListener('change', toggleOtra);
            toggleOtra();
        }

        const selectSalon = document.getElementById('salon_id');
        const inputGrado = document.getElementById('grado_solicitado');
        if (selectSalon && inputGrado) {
            const fillGrado = () => {
                const opt = selectSalon.options[selectSalon.selectedIndex];
                if (opt && opt.dataset) inputGrado.value = opt.dataset.label || '';
            };
            selectSalon.addEventListener('change', fillGrado);
            fillGrado();
        }
    </script>
</body>
</html>

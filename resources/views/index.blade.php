<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegio Salomon del Norte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap text-2xl mr-2"></i>
                        <span class="font-bold text-xl">Colegio Salomon del Norte</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="hover:text-blue-200">Inicio</a>
                    {{-- <a href="#" class="hover:text-blue-200">Acerca de</a>
                    <a href="#" class="hover:text-blue-200">Académicos</a> --}}
                    <a href="/inscripcion" class="hover:text-blue-200">Admisiones</a>
                    {{-- <a href="#" class="hover:text-blue-200">Eventos</a>
                    <a href="#" class="hover:text-blue-200">Contacto</a> --}}
                </div>
                <div class="md:hidden">
                    <button class="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Bienvenido a Colegio Salomon del Norte</h1>
            <p class="text-xl md:text-2xl mb-8">Excelencia en Educación Desde 2012</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <button class="bg-white text-blue-800 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-300">
                    Aplicar Ahora
                </button>
                <button class="border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-blue-800 transition duration-300">
                    Más Información
                </button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Acerca de Nuestro Colegio</h2>
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350" alt="School Building" class="rounded-lg shadow-xl w-full">
                </div>
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Nuestra Misión</h3>
                    <p class="text-gray-600 mb-6">
                        El Colegio Salomon del Norte se compromete a proporcionar un entorno de apoyo que fomente la excelencia académica,
                        el crecimiento personal y la responsabilidad social. Empoderamos a los estudiantes para que se conviertan en aprendices de por vida y ciudadanos globales responsables.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-800 mb-2">Establecido</h4>
                            <p>1985</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-800 mb-2">Estudiantes</h4>
                            <p>1,200+</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-800 mb-2">Personal</h4>
                            <p>85+</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-800 mb-2">Cursos</h4>
                            <p>15+</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Academics Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nuestra Academia</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Elementary -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-pencil-alt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Escuela Primaria</h3>
                    <p class="text-gray-600 mb-4">
                        Nuestro programa de educación primaria se centra en las habilidades fundamentales en lectura, escritura y matemáticas, al tiempo que fomenta la curiosidad y la creatividad.
                    </p>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Más Información →</a>
                </div>
                
                <!-- Middle School -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-book text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Escuela Secundaria</h3>
                    <p class="text-gray-600 mb-4">
                        Nuestro plan de estudios de escuela secundaria desafía a los estudiantes académicamente mientras proporciona sistemas de apoyo sólidos durante estos años de transición.
                    </p>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Más Información →</a>
                </div>
                
                <!-- High School -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-graduation-cap text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Escuela Secundaria</h3>
                    <p class="text-gray-600 mb-4">
                        Nuestro programa integral de escuela secundaria incluye cursos AP, trayectorias profesionales y preparación universitaria para garantizar el éxito de los estudiantes.
                    </p>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Más Información →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Próximos Eventos</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Event 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24" alt="Science Fair" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Ciencia</span>
                            <span class="text-sm text-gray-500">15 de mayo de 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Feria Anual de Ciencias</h3>
                        <p class="text-gray-600 mb-4">
                            Los estudiantes muestran sus proyectos innovadores en nuestra feria anual de ciencias. Abierto al público.
                        </p>
                        <button class="text-blue-600 font-semibold hover:underline">Más Información →</button>
                    </div>
                </div>
                
                <!-- Event 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87" alt="Sports Day" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Deportes</span>
                            <span class="text-sm text-gray-500">2 de junio de 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Día de Deportes</h3>
                        <p class="text-gray-600 mb-4">
                            Competencia anual de deportes entre casas. ¡Ven a animar a tu equipo favorito!
                        </p>
                        <button class="text-blue-600 font-semibold hover:underline">Más Información →</button>
                    </div>
                </div>
                
                <!-- Event 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173" alt="Graduation" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Graduación</span>
                            <span class="text-sm text-gray-500">15 de junio de 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Graduación de la Clase de 2023</h3>
                        <p class="text-gray-600 mb-4">
                            Celebra los logros de nuestros estudiantes de último año en esta ceremonia especial.
                        </p>
                        <button class="text-blue-600 font-semibold hover:underline">Más Información →</button>
                    </div>
                </div>
            </div>
            <div class="text-center mt-10">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Ver Todos los Eventos
                </button>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-blue-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Lo que dicen los padres y estudiantes</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-6">
                        "Greenwood High ha brindado a mi hijo una educación excepcional y numerosas oportunidades 
                        para el crecimiento personal. Los maestros son dedicados y realmente se preocupan por el éxito de cada estudiante."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold">Sarah Johnson</h4>
                            <p class="text-gray-500 text-sm">Padre de un estudiante de 8º grado</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-6">
                        "El programa AP en Greenwood me preparó extremadamente bien para la universidad. Entré a la universidad con 
                        15 créditos y me sentí por delante de muchos de mis compañeros. Los maestros te desafían pero también te apoyan."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold">Michael Chen</h4>
                            <p class="text-gray-500 text-sm">Clase de 2022</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-blue-800 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">¿Listo para unirte a nuestra comunidad?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Programa una visita o comienza el proceso de admisión hoy. Nuestro equipo de admisiones está listo para responder tus preguntas.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <button class="bg-white text-blue-800 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-300">
                    Aplicar Ahora
                </button>
                <button class="border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-blue-800 transition duration-300">
                    Contáctanos
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- School Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Colegio Salomon del Norte</h3>
                    <p class="text-gray-400 mb-4">
                        123 Education Avenue<br>
                        Springfield, ST 12345<br>
                        United States
                    </p>
                    <p class="text-gray-400 mb-4">
                        <i class="fas fa-phone-alt mr-2"></i> (555) 123-4567<br>
                        <i class="fas fa-envelope mr-2"></i> info@colegiosalomon.edu
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Calendario</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Directorio de Personal</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Menú del Almuerzo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Portal de Padres</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Portal de Estudiantes</a></li>
                    </ul>
                </div>
                
                <!-- Resources -->
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
                
                <!-- Social Media -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Conéctate con Nosotros</h3>
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
        // Mobile menu toggle functionality
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
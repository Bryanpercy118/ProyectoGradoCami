<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegio Salomon del Norte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Agrega esto en tu layout (head) o en esta vista -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />


</head>
<body class="font-sans bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white text-black shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <img alt="Logo Colegio Salomón" class="w-28" src="{{ asset('build/assets/images/col.png') }}">
                        <span class="font-bold text-xl ml-4">Colegio Salomon del Norte</span>
                    </div>
                </div>
               <div class="hidden md:flex items-center space-x-4 text-black ml-10">
                    <a href="/colsanor/home" class="px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white hover:font-bold transition">
                        Inicio
                    </a>
                    <a href="/inscripcion" class="px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white hover:font-bold transition">
                        Admisiones
                    </a>
                    <a href="/login" class="px-4 py-2 rounded-md hover:bg-red-600 hover:text-white hover:font-bold transition">
                        Iniciar Sesión
                    </a>
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
    <!-- Carrusel a ancho completo -->
    <section class="w-full bg-white">
        <div class="swiper mySwiper w-full">
            <div class="swiper-wrapper">
                <!-- Imagen 1 -->
                <div class="swiper-slide relative">
                    <!-- Imagen -->
                    <img src="{{ asset('build/assets/images/img-1.jpeg') }}" alt="Bienvenida 1"
                        class="w-full h-[500px] object-cover">

                    <!-- Overlay oscuro -->
                    <div class="absolute inset-0 bg-black/50"></div>

                    <!-- Texto centrado -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-6">
                        <h2 class="text-4xl md:text-5xl font-bold">Colegio Salomón del Norte</h2>
                        <p class="mt-4 text-lg md:text-xl max-w-2xl">
                            Inspirando excelencia académica y valores que trascienden.
                        </p>
                    </div>
                </div>

                <!-- Imagen 2 -->
                <div class="swiper-slide relative">
                    <img src="{{ asset('build/assets/images/img-2.jpeg') }}" alt="Bienvenida 2"
                        class="w-full h-[500px] object-cover">

                    <!-- Overlay oscuro -->
                    <div class="absolute inset-0 bg-black/50"></div>

                    <!-- Texto -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-6">
                        <h2 class="text-4xl md:text-5xl font-bold">Aprendizaje Integral</h2>
                        <p class="mt-4 text-lg md:text-xl max-w-2xl">
                            Fomentamos el desarrollo académico, social y humano de cada estudiante.
                        </p>
                    </div>
                </div>

                <!-- Imagen 3 -->
                <div class="swiper-slide relative">
                    <img src="{{ asset('build/assets/images/img-3.jpeg') }}" alt="Bienvenida 3"
                        class="w-full h-[500px] object-cover">

                    <!-- Overlay oscuro -->
                    <div class="absolute inset-0 bg-black/50"></div>

                    <!-- Texto -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-6">
                        <h2 class="text-4xl md:text-5xl font-bold">Valores que Inspiran</h2>
                        <p class="mt-4 text-lg md:text-xl max-w-2xl">
                            Educamos con principios sólidos para formar líderes con propósito.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Controles -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next text-blue-800"></div>
            <div class="swiper-button-prev text-blue-800"></div>
        </div>
    </section>

    <section class="py-2 bg-blue-300 text-white">
        <div class="container mx-auto px-6 text-center">
         
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
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Misión</h3>
                    <p class="text-gray-600 mb-6">
                        El Colegio Salomon del Norte se compromete a proporcionar un entorno de apoyo que fomente la excelencia académica,
                        el crecimiento personal y la responsabilidad social. Empoderamos a los estudiantes para que se conviertan en aprendices de por vida y ciudadanos globales responsables.
                    </p>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Visión</h3>
                    <p class="text-gray-600 mb-6">
                        El Colegio Salomon del Norte se compromete a proporcionar un entorno de apoyo que fomente la excelencia académica,
                        el crecimiento personal y la responsabilidad social. Empoderamos a los estudiantes para que se conviertan en aprendices de por vida y ciudadanos globales responsables.
                    </p>
                    
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
                </div>
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
                        "Estamos muy agradecidos con el Colegio Salomón. Mi hija ha crecido en confianza, responsabilidad y amor por el aprendizaje. ¡100% recomendado!"
                    </p>
                    <div class="flex items-center">
                        {{-- <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4"> --}}
                        <div>
                            <h4 class="font-semibold">Maria Rosado</h4>
                            <p class="text-gray-500 text-sm">Padre de una estudiante de 3º grado</p>
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
                        "El Colegio Salomón ha sido una bendición para mi hijo. La formación académica y los valores que promueven hacen la diferencia. ¡Excelente institución!"
                    </p>
                    <div class="flex items-center">
                        {{-- <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen" class="w-12 h-12 rounded-full mr-4"> --}}
                        <div>
                            <h4 class="font-semibold">Michael Gonzales</h4>
                            <p class="text-gray-500 text-sm">Padre de un estudiante de 1º grado</p>
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
            {{-- <div class="flex flex-col md:flex-row justify-center gap-4">
                <button class="bg-white text-blue-800 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-300">
                    Aplicar Ahora
                </button>
                <button class="border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-blue-800 transition duration-300">
                    Contáctanos
                </button>
            </div> --}}
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
                        <li><a href="/inscripcion" class="text-gray-400 hover:text-white">Adminisiones</a></li>
                        <li><a href="/login" class="text-gray-400 hover:text-white">Nuestra Plataforma</a></li>
                    </ul>
                </div>
                
                <!-- Resources -->
                {{-- <div>
                    <h3 class="text-xl font-bold mb-4">Recursos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Biblioteca</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Atletismo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Clubes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Consejería</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Alumno</a></li>
                    </ul>
                </div> --}}
                
                <!-- Social Media -->
                {{-- <div>
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
                </div> --}}
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
    <!-- CDN Swiper (Head) -->

    <!-- Swiper Script (final del body o @section('script')) -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
    const swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
        delay: 3500,
        disableOnInteraction: false,
        },
        pagination: {
        el: ".swiper-pagination",
        clickable: true,
        },
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },
    });
    </script>


</body>
</html>
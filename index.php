<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BELLAVISTA</title>
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
            integrity="sha512-dN6zFz9i4G43F/xnX5E4CDZ2/v8H2U/ZhZ7NRp9ZXfyE4hNptZbW6bzzdCJuNBzHU94kTn5at3ZrjtX3cBfXCA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="stylesheet" href="Styles/Quienes.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <script>
        // Esta función la llama automáticamente el script de Google al inicializarse
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'es',
                includedLanguages: 'es,en,it,fr,ru,ar,ja,ko,hi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');

            // Re-aplicar el idioma guardado (si existe)
            const savedLang = localStorage.getItem('selectedLanguage');
            if (savedLang) {
                // Esperamos un breve tiempo para que se cargue el traductor
                setTimeout(() => {
                    const combo = document.querySelector('.goog-te-combo');
                    if (combo) {
                        combo.value = savedLang;
                        combo.dispatchEvent(new Event('change'));
                    }
                }, 500);
            }
        }
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('goog-te-combo')) {
                const selectedLang = e.target.value;
                localStorage.setItem('selectedLanguage', selectedLang);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('session.php')
                .then(response => response.json())
                .then(user => {
                    if (user) {
                        document.getElementById('usuario_id').value = user.id;
                        document.getElementById('nombre_cliente').value = user.nombre;
                        document.getElementById('apellidos_cliente').value = user.apellidos;
                        document.getElementById('email').value = user.email;
                        document.getElementById('numero_telefono').value = user.telefono;
                    }
                })
                .catch(error => console.error('Error al recuperar sesión:', error));
        });
    </script>
    <script type="text/javascript">
        function ocultarBarraGoogle() {
            let frame = document.querySelector(".goog-te-banner-frame");
            if (frame) {
                frame.style.display = "none";
            }
            document.body.style.top = "0px";
        }

        // Espera a que la traducción se cargue y oculta la barra
        setInterval(ocultarBarraGoogle, 1000);
    </script>
    <!-- Script oficial de Google Translate -->
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<body>

<header class="hidden-header">
    <div class="logo">
        <h1>
            <a href="index.php">
                <img src="Multimedia/logo_BELLAVIST_blanco.png" alt="LogoMenu">
            </a>
        </h1>
    </div>

        <div id="google_translate_element"></div>

    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="servicios.html">Servicios</a></li>
            <li><a href="Habitaciones.html">Habitaciones</a></li>
            <li><a href="Contacto.html">Contáctanos</a></li>
            <li><a href="#" onclick="mostrarTexto(event)">Quiénes somos </a><li>
            <li>
                <button><span><a href="Reservar.php">Reservar</a></span></button>
            </li>

            <?php if (isset($_SESSION['usuario'])): ?>
                <li>
                    <form action="usuario.php" method="post">
                        <button type="submit" style="
                background: none;
                border: none;
                cursor: pointer;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            ">
                            <img src="Multimedia/usuario.png" alt="Usuario" style="
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                ">
                        </button>
                    </form>
                </li>
                <li>
                    <a href="Logout.php">Cerrar Sesión</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="Login.html">Iniciar Sesión</a>
                </li>
            <?php endif; ?>
        </ul>

    </nav>
    <script>
        function mostrarTexto(e) {
            e.preventDefault();
            let formQuienes = document.getElementById("Quienes");
            formQuienes.style.display = (formQuienes.style.display === "none" || formQuienes.style.display === "") ? "block" : "none";
        }
    </script>
    <div id="Quienes" style="display: none;">

        <h2>¿Quiénes somos?</h2    >
        <p>En nuestro hotel, estamos comprometidos con el planeta y el futuro el lujo y la sostenibilidad.
            Creemos firmemente en un modelo de hospitalidad que respeta el entorno y las comunidades locales,
            ofreciendo a nuestros huéspedes una experiencia única, responsable y consciente con el medio ambiente.</p>
    </div>
</header>

<!-- Resto de la página -->
<main>
    <section class="hero">
        <div class="logo-container">
            <div class="background"></div>
            <img src="Multimedia/BELLAVISTA_LOGO_BLANCO.png" alt="logoHero">
        </div>
        <button class="putobotonreservar"><span><a href="Reservar.php">Reservar</a></span></button>
    </section>
    <section>
        <!-- Contenido adicional -->
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-1/2">
                <img alt="A table with a sandwich, fries, a blue cocktail, and an orange drink" class="w-full h-full object-cover" src="Multimedia/FOTO_CACERES.jpg"/>
            </div>
            <div class="lg:w-1/2 p-8 lg:p-16">
                <h2 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-2">
                    Vista General
                </h2>
                <div class="textoexplicacion">
                    <h1 class="text-4xl font-bold mb-4">
                        La Belleza de la Naturaleza
                    </h1>
                    <p class="text-lg mb-4">
                        Sumérgete en la tranquilidad de nuestro hotel rural, un paraíso diseñado para quienes buscan desconectar en un entorno exclusivo y lleno de encanto. Rodeado de paisajes impresionantes y detalles cuidadosamente pensados, combinamos la calidez de lo rústico con el confort de instalaciones de lujo.</p>
                    <p class="text-lg mb-4">
                        Aquí, cada amanecer es un espectáculo y cada experiencia está hecha a tu medida. Relájate, explora y déjate llevar por la magia de lo natural elevado al máximo nivel</p>

                </div>

                <h3 class="text-xl font-bold mb-4">
                    Principales servicios y amenities
                </h3>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <i class="fas fa-swimming-pool mr-2"></i>
                        Piscina
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-spa mr-2"></i>
                        Spa
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-glass-martini-alt mr-2"></i>
                        Bar
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-dumbbell mr-2"></i>
                        Gimnasio
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-utensils mr-2"></i>
                        Buffet
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-parking mr-2"></i>
                        Parking
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-theater-masks mr-2"></i>
                        Espectáculos al aire libre
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section id="fotos_imagenes">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-light">
                    HABITACIONES
                </h1>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="relative">
                    <img  src="Multimedia/Habitacion-Queen1.jpeg"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                        <div class="flex items-center text-white mb-2">
                            <i class="fas fa-user mr-2">
                            </i>
                            <span>
                     2 HUESPEDES
                    </span>
                        </div>
                        <h2 class="text-white text-xl font-bold">
                            SUITE QUEEN DE LUJO
                        </h2>
                        <div class="flex space-x-2 mt-2">
                            <button class="bg-transparent border border-white text-white py-1 px-4">
                                <a href="suitQueen.html" id="foto-Vista-Rapida">Vista rápida</a>

                            </button>
                            <button id="foto-Reservar-ahora" class="bg-white text-black py-1 px-4">
                                <a href="Reservar.php" >Reservar ahora</a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="Multimedia/Habitacion-King1.jpg"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                        <div class="flex items-center text-white mb-2">
                            <i class="fas fa-users mr-2">
                            </i>
                            <span>
                     3 HUESPEDES
                    </span>
                        </div>
                        <h2 class="text-white text-xl font-bold">
                            SUITE KING DE LUJO
                        </h2>
                        <div class="flex space-x-2 mt-2">
                            <button class="bg-transparent border border-white text-white py-1 px-4">
                                <a href="SuitKing.html" id="foto-Vista-Rapida">Vista rápida</a>

                            </button>
                            <button id="foto-Reservar-ahora" class="bg-white text-black py-1 px-4">
                                <a href="Reservar.php">Reservar ahora</a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="Multimedia/Habitacion-Suite-king1.jpeg"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                        <div class="flex items-center text-white mb-2">
                            <i class="fas fa-users mr-2">
                            </i>
                            <span>
                        3 HUESPEDES
                    </span>
                        </div>
                        <h2 class="text-white text-xl font-bold">
                            SUITE KING DE LUJO + BALCÓN
                        </h2>
                        <div class="flex space-x-2 mt-2">
                            <button class="bg-transparent border border-white text-white py-1 px-4">
                                <a href="SUITEKINGBALCÓN.html" id="foto-Vista-Rapida">Vista rápida</a>
                            </button>
                            <button id="foto-Reservar-ahora" class="bg-white text-black py-1 px-4">
                                <a href="Reservar.php">Reservar ahora</a>
                            </button>
                        </div>
                    </div>
                </div>
    </section>
    <?php include 'mostrarReseñas.php'; ?>
    <!-- Botón "Gracias" -->
    <a
            aria-label="Thanks"
            class="h-button centered"
            data-text="Dejar reseña"
            href="reseñas.html">
        <span>G</span>
        <span>R</span>
        <span>A</span>
        <span>C</span>
        <span>I</span>
        <span>A</span>
        <span>S</span>
    </a>

</main>


<footer class="py-8" style="background-color: #0c1401;">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-between">
            <!-- Quick Links Section -->
            <div class="w-full md:w-1/4 mb-6 md:mb-0">
                <h2 class="text-xl font-bold mb-4">
                    Enlaces
                </h2>
                <ul>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"  href="index.php">
                            Inicio
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white" href="servicios.html">
                            Servicios
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"href="Contacto.html">
                            Contacto
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"href="Habitaciones.html">
                            Habitaciones
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Latest News Section -->
            <div class="w-full md:w-1/4 mb-6 md:mb-0">
                <h2 class="text-xl font-bold mb-4">
                    Bella Vista
                </h2>
                <ul>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"  href="Reservar.php">
                            Reservar
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"  href="suitQueen.html">
                            Suite Queen
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"  href="SuitKing.html">
                            Suite King
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="text-gray-400 hover:text-white"  href="SUITEKINGBALCÓN.html">
                            Suite King De lujo
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Contact Us Section -->
            <div class="w-full md:w-1/4 mb-6 md:mb-0">
                <h2 class="text-xl font-bold mb-4">
                    Contact Us
                </h2>
                <p class="text-gray-400 hover:text-white"ver:text-white" >
                <i class="fas fa-map-marker-alt mr-2">
                </i>
                1234 Street Name, City, State, 12345
                </p>
                <p class="text-gray-400 hover:text-white"ver:text-white"  >
                <i class="fas fa-phone-alt mr-2">
                </i>
                (+34) 666-666-666
                </p>
                <p class="text-gray-400 hover:text-white"ver:text-white" >
                <i class="fas fa-envelope mr-2">
                </i>
                BellaVista@info.com
                </p>
            </div>
        </div>
        <div class="flex justify-between items-center mt-8">
            <!-- Social Media Links -->
            <div>
                <a class="text-gray-400 hover:text-white" href="#">
                    <i class="fab fa-facebook-f">
                    </i>
                </a>
                <a class="text-gray-400 hover:text-white" href="#">
                    <i class="fab fa-twitter">
                    </i>
                </a>
                <a class="text-gray-400 hover:text-white" href="#">
                    <i class="fab fa-instagram">
                    </i>
                </a>
                <a class="text-gray-400 hover:text-white" href="#">
                    <i class="fab fa-linkedin-in">
                    </i>
                </a>
            </div>
            <!-- Logo -->
            <div>
                <img width="140px" height="70px" alt="Company logo with a simple and elegant design" src="Multimedia/BELLAVISTA_LOGO_BLANCO.png"/>
            </div>
        </div>
    </div>
</footer>


<script src="WEB-INF/js/menu.js"></script>
<script >
    document.addEventListener('scroll', () => {
        const header = document.querySelector('.hidden-header');
        if (window.scrollY > 725) {
            header.classList.add('visible');
        } else {
            header.classList.remove('visible');
        }
    });
</script>
</script>
</body>
</html>
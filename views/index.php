<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octava Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Pangolin&family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/diseno.css">
</head>

<body>
    <input type="checkbox" id="about-toggle" hidden>


    <!-- <audio id="bgMusic" autoplay loop>
        <source src="../assets/img/Ratatouilmp3le Ambient Music   PIXAR   Relax, Study, Sleep and Cook."
            type="audio/mpeg">
    </audio> -->


    <div id="menu_flotante">
        <button class="boton_inicial">☰</button>
        <nav class="opciones">
            <a href="#" class="item">Inicio</a>
            <a href="https://www.google.com/maps/place/Octava+caf%C3%A9/@20.7488147,-105.3885314,17z/data=!3m1!4b1!4m6!3m5!1s0x842141cc5eac6c8d:0x385c2032efa74cd4!8m2!3d20.7488098!4d-105.3836605!16s%2Fg%2F11p15l5w2g?entry=ttu&g_ep=EgoyMDI2MDIwOS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank" class="item">Ubicación</a>
            <a href="https://www.google.com/maps/place/Octava+caf%C3%A9/@20.7488432,-105.3837222,3a,75y,90t/data=!3m8!1e2!3m6!1sCIHM0ogKEICAgIC_zbicwAE!2e10!3e12!6shttps:%2F%2Flh3.googleusercontent.com%2Fgps-cs-s%2FAHVAweqbOKQgvdSZtOed-r-tMQ16PcjWgYXgoRCj8umd-GELBnXgHZBndtachh1QZfkIGhiOsSyHd5OV96vKTDWFSKWZefG6IvyNylStb8_1dpmF1FKPL33nrtRQPUnfNEyoOwU3qLmC2w%3Dw195-h146-k-no!7i4080!8i3072!4m7!3m6!1s0x842141cc5eac6c8d:0x385c2032efa74cd4!8m2!3d20.7488098!4d-105.3836605!10e9!16s%2Fg%2F11p15l5w2g?entry=ttu&g_ep=EgoyMDI2MDIwOS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank" class="item">Productos</a>
        </nav>
    </div>

    <main class="principal">

        <div class="contenedor_about">
            <section class="texto_principal">
                <h1>¡Algo delicioso se está horneando!</h1>
                <h2>Déjate envolver <br>
                    por el aroma <br>
                    de nuestro café recién tostado hoy.</h2>
                <img src="" alt="">
            </section>
            <div class="panel_about">
                <h2>Nuestra Historia</h2>
                <p>
                    Octava Café nació de una amistad que comenzó entre libros,
                    madrugadas de estudio y tazas interminables de café.
                    Edgar y Josué compartían algo más que clases:
                    compartían el sueño de crear un espacio donde las personas
                    pudieran sentirse en casa.
                    <br><br>
                    Entre risas, errores, recetas fallidas y muchas pruebas,
                    descubrieron que el café no solo despierta el cuerpo,
                    también une corazones.
                    <br><br>
                    Así nació Octava Café:
                    un rincón donde cada taza es un abrazo,
                    cada aroma cuenta una historia,
                    y cada visitante se convierte en parte de la familia.
                    <br><br>
                    Porque más que café…
                    servimos momentos. ☕🤎
                </p>
            </div>

        </div>
        <div class="carrusel">

            <input type="radio" name="slider" id="img1" checked>
            <input type="radio" name="slider" id="img2">
            <input type="radio" name="slider" id="img3">
            <input type="radio" name="slider" id="img4">

            <div class="slides">
                <div class="slide s1"><img src="../assets/img/carr1.jpeg"></div>
                <div class="slide s2"><img src="../assets/img/carr2.jpeg"></div>
                <div class="slide s3"><img src="../assets/img/carr3.jpeg"></div>
                <div class="slide s4"><img src="../assets/img/carr5.jpeg"></div>
            </div>

            <!-- Flechas por estado -->
            <div class="flechas f1">
                <label for="img4" class="prev">❮</label>
                <label for="img2" class="next">❯</label>
            </div>

            <div class="flechas f2">
                <label for="img1" class="prev">❮</label>
                <label for="img3" class="next">❯</label>
            </div>

            <div class="flechas f3">
                <label for="img2" class="prev">❮</label>
                <label for="img4" class="next">❯</label>
            </div>

            <div class="flechas f4">
                <label for="img3" class="prev">❮</label>
                <label for="img1" class="next">❯</label>
            </div>

        </div>



        </div>


        <header class="header_principal">
            <div class="header_marca">
                <img src="../assets/img/Gemini_Generated_Image_gcpjwjgcpjwjgcpj-removebg-preview.png" alt="logo" class="logotipo">
                <span class="header_nombre">OCTAVA <span>CAFÉ</span></span>
            </div>

            <nav class="header_nav">
                <a href="https://www.google.com/maps/place/Octava+caf%C3%A9/@20.7488147,-105.3885314,17z/data=!3m1!4b1!4m6!3m5!1s0x842141cc5eac6c8d:0x385c2032efa74cd4!8m2!3d20.7488098!4d-105.3836605!16s%2Fg%2F11p15l5w2g?entry=ttu&g_ep=EgoyMDI2MDIwOS4wIKXMDSoASAFQAw%3D%3D"
                    target="_blank" class="nav_enlace">Ubicación</a>
                <label for="about-toggle" class="nav_enlace">Sobre Nosotros</label>
                <a href="productos.php" class="nav_enlace">Productos</a>
                <a href="#informacion" class="nav_enlace">Información</a>
            </nav>

            <div class="header_usuario">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <div class="header_dropdown">
                        <button class="btn_usuario_header">
                            <span class="avatar_mini"><?php echo strtoupper(substr($_SESSION['usuario'], 0, 1)); ?></span>
                            Hola, <?php echo explode(" ", $_SESSION['usuario'])[0]; ?> <span class="chevron">▾</span>
                        </button>
                        <div class="header_dropdown_menu">
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                <a href="dashboard.php" class="menu_item_destacado">⚙ Panel de Control</a>
                            <?php else: ?>
                                <a href="mis_pedidos.php" class="menu_item">☕ Mis Pedidos</a>
                            <?php endif; ?>
                            <a href="cuenta.php" class="menu_item">👤 Mi Cuenta</a>
                            <a href="../controllers/logout.php" class="menu_item menu_salir">Cerrar Sesión</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.html" class="btn_login_header">Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </header>
        <div class="imagenes_cafe">

            <div class="diseño">
                <img src="../assets/img/IMG-20260115-WA0002.jpg" alt="">
                <div class="overlay">
                    <p>
                        Con este clima, el cuerpo pide café… y el corazón también. 🤍 <br><br>
                        En La Octava te espera ese abrazo calientito que calma el frío y reconforta el alma. <br><br>
                        Ven por el tuyo ☕
                    </p>
                </div>
            </div>

            <div class="diseño">
                <img src="../assets/img/IMG-20260122-WA0054.jpg" alt="">
                <div class="overlay">
                    <p>
                        Cada taza cuenta una historia… deja que la tuya comience aquí ☕
                    </p>
                </div>
            </div>

            <div class="diseño">
                <img src="../assets/img/IMG-20260204-WA0002.jpg" alt="">
                <div class="overlay">
                    <p>
                        Un rincón acogedor, un café perfecto y un momento solo para ti 🤎
                    </p>
                </div>
            </div>

            <div class="diseño">
                <img src="../assets/img/IMG-20251213-WA0009.jpg" alt="">
                <div class="overlay">
                    <p>
                        Respira profundo… huele el café recién hecho y disfruta el instante ✨
                    </p>
                </div>
            </div>

        </div>


    </main>

    <footer class="footer-horizontal" id="informacion">
        <div class="footer-izq">
            <h3>Horario:</h3>
            <span>Lunes a Sábado: </span>
            <ul>
                <li><span>7:00 am a </li>
                <li>1:00 pm</span></li>
            </ul>

            <span class="pais">📍 México</span>

            <span>© 2026 Octava Café</span>
            <h3>Contáctanos</h3>
            <a href="">Octavacafe@gmail.com</a>
            <a href="#">322-138-1733</a>
        </div>

        <div class="footer-centro">
            <div class="promo_box">
                <h3>Recibe promociones </h3>
                <p>Déjanos tu correo y entérate de nuestras ofertas especiales.</p>

                <form class="form_promo">
                    <input type="email" placeholder="Ingresa tu correo" required>
                    <button type="submit">Suscribirme</button>
                </form>
            </div>
            <h3>Empleo</h3>
            <a href="https://www.empleo.gob.mx/assets/solicitud_empleo/SNE_SOLICITUD_DE_EMPLEO_PLANTILLA_PDF.pdf"
                target="_blank">Forma Parte De Nuestro Equipo</a> <br>
            <a href="#">Factura Electronica ↗</a>

            <div class="redes">
                <div class="redes_container">
                    <p>Edgar</p>
                    <div class="redes_iconos">
                        <a href="https://www.linkedin.com/in/edgar-garcia-luna/" target="_blank"><svg
                                preserveAspectRatio="xMidYMid" viewBox="0 0 256 256" class="iconos">
                                <path
                                    d="M218.123 218.127h-37.931v-59.403c0-14.165-.253-32.4-19.728-32.4-19.756 0-22.779 15.434-22.779 31.369v60.43h-37.93V95.967h36.413v16.694h.51a39.907 39.907 0 0 1 35.928-19.733c38.445 0 45.533 25.288 45.533 58.186l-.016 67.013ZM56.955 79.27c-12.157.002-22.014-9.852-22.016-22.009-.002-12.157 9.851-22.014 22.008-22.016 12.157-.003 22.014 9.851 22.016 22.008A22.013 22.013 0 0 1 56.955 79.27m18.966 138.858H37.95V95.967h37.97v122.16ZM237.033.018H18.89C8.58-.098.125 8.161-.001 18.471v219.053c.122 10.315 8.576 18.582 18.89 18.474h218.144c10.336.128 18.823-8.139 18.966-18.474V18.454c-.147-10.33-8.635-18.588-18.966-18.453"
                                    fill="#0A66C2" />
                            </svg></a>

                        <a href="https://github.com/edggclu" target="_blank"><svg viewBox="0 0 1024 1024" fill="none"
                                class="iconos">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8 0C3.58 0 0 3.58 0 8C0 11.54 2.29 14.53 5.47 15.59C5.87 15.66 6.02 15.42 6.02 15.21C6.02 15.02 6.01 14.39 6.01 13.72C4 14.09 3.48 13.23 3.32 12.78C3.23 12.55 2.84 11.84 2.5 11.65C2.22 11.5 1.82 11.13 2.49 11.12C3.12 11.11 3.57 11.7 3.72 11.94C4.44 13.15 5.59 12.81 6.05 12.6C6.12 12.08 6.33 11.73 6.56 11.53C4.78 11.33 2.92 10.64 2.92 7.58C2.92 6.71 3.23 5.99 3.74 5.43C3.66 5.23 3.38 4.41 3.82 3.31C3.82 3.31 4.49 3.1 6.02 4.13C6.66 3.95 7.34 3.86 8.02 3.86C8.7 3.86 9.38 3.95 10.02 4.13C11.55 3.09 12.22 3.31 12.22 3.31C12.66 4.41 12.38 5.23 12.3 5.43C12.81 5.99 13.12 6.7 13.12 7.58C13.12 10.65 11.25 11.33 9.47 11.53C9.76 11.78 10.01 12.26 10.01 13.01C10.01 14.08 10 14.94 10 15.21C10 15.42 10.15 15.67 10.55 15.59C13.71 14.53 16 11.53 16 8C16 3.58 12.42 0 8 0Z"
                                    transform="scale(64)" fill="#ffff" />
                            </svg></a>
                    </div>
                </div>

                <div class="redes_container">
                    <p>Josue</p>
                    <div class="redes_iconos">
                        <a href="https://www.linkedin.com/in/josu%C3%A9-gallo-258330377/" target="_blank"><svg
                                preserveAspectRatio="xMidYMid" viewBox="0 0 256 256" class="iconos">
                                <path
                                    d="M218.123 218.127h-37.931v-59.403c0-14.165-.253-32.4-19.728-32.4-19.756 0-22.779 15.434-22.779 31.369v60.43h-37.93V95.967h36.413v16.694h.51a39.907 39.907 0 0 1 35.928-19.733c38.445 0 45.533 25.288 45.533 58.186l-.016 67.013ZM56.955 79.27c-12.157.002-22.014-9.852-22.016-22.009-.002-12.157 9.851-22.014 22.008-22.016 12.157-.003 22.014 9.851 22.016 22.008A22.013 22.013 0 0 1 56.955 79.27m18.966 138.858H37.95V95.967h37.97v122.16ZM237.033.018H18.89C8.58-.098.125 8.161-.001 18.471v219.053c.122 10.315 8.576 18.582 18.89 18.474h218.144c10.336.128 18.823-8.139 18.966-18.474V18.454c-.147-10.33-8.635-18.588-18.966-18.453"
                                    fill="#0A66C2" />
                            </svg></a>

                        <a href="https://github.com/JosueGrcc" target="_blank"><svg viewBox="0 0 1024 1024" fill="none"
                                class="iconos">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8 0C3.58 0 0 3.58 0 8C0 11.54 2.29 14.53 5.47 15.59C5.87 15.66 6.02 15.42 6.02 15.21C6.02 15.02 6.01 14.39 6.01 13.72C4 14.09 3.48 13.23 3.32 12.78C3.23 12.55 2.84 11.84 2.5 11.65C2.22 11.5 1.82 11.13 2.49 11.12C3.12 11.11 3.57 11.7 3.72 11.94C4.44 13.15 5.59 12.81 6.05 12.6C6.12 12.08 6.33 11.73 6.56 11.53C4.78 11.33 2.92 10.64 2.92 7.58C2.92 6.71 3.23 5.99 3.74 5.43C3.66 5.23 3.38 4.41 3.82 3.31C3.82 3.31 4.49 3.1 6.02 4.13C6.66 3.95 7.34 3.86 8.02 3.86C8.7 3.86 9.38 3.95 10.02 4.13C11.55 3.09 12.22 3.31 12.22 3.31C12.66 4.41 12.38 5.23 12.3 5.43C12.81 5.99 13.12 6.7 13.12 7.58C13.12 10.65 11.25 11.33 9.47 11.53C9.76 11.78 10.01 12.26 10.01 13.01C10.01 14.08 10 14.94 10 15.21C10 15.42 10.15 15.67 10.55 15.59C13.71 14.53 16 11.53 16 8C16 3.58 12.42 0 8 0Z"
                                    transform="scale(64)" fill="#ffff" />
                            </svg></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-der">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3731.064184721224!2d-105.38257285503909!3d20.748192429404394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842141cc5eac6c8d%3A0x385c2032efa74cd4!2sOctava%20caf%C3%A9!5e0!3m2!1ses!2smx!4v1770768382752!5m2!1ses!2smx"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade" class="mapa"></iframe>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function () {
            const menu = document.getElementById('menu_flotante');

            if (window.scrollY > 120) {
                menu.classList.add('show');
            } else {
                menu.classList.remove('show');
            }
        });
    </script>
</body>

</html>


</body>

</html>
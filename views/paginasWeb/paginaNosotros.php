<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./photo/logoPesta.ico" type="image/x-icon">
    <title>Minimarket Variedades JYK</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css?v=1.0">
    <link rel="stylesheet" href="./css/DesingBody.css?v=1.0">
    <link rel="stylesheet" href="./css/DesingLogin2.css?v=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/paginanosotross.css?v=1.0">
</head>

<body>
    <div class="container-fluid" id="barra_navegacion">
        <div class="row p-3">
            <div class="col-2 mt-2">
                <!--Inicio Barra Navegacion-->
                <nav class="img-fluid d-block text-center" id="inicio">
                    <a class="navbar-brand">
                        <img src="./photo/logoPrin1.1.jpeg" alt="Logo" width="90" height="80" class="rounded-3">
                    </a>
                </nav>
            </div>
            <div class="col-10">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                            <nav class="navbar navbar-light">
                                <div class="container-fluid">
                                    <a class="navbar-brand text-white">Menu</a>
                                </div>
                            </nav>
                        </button>
                        <div class="collapse navbar-collapse mt-2" id="navbarTogglerDemo01">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item me-5">
                                    <a class="nav-link text-white m-1 fs-5" href='index.php?action=Principal' role="button">Inicio</a>
                                </li>
                                <li class="nav-item me-5">
                                    <a class="nav-link text-white m-1 fs-5" href='index.php?action=Nosotros' role="button">Nosotros</a>
                                </li>
                                <li class="nav-item me-5">
                                    <a class="nav-link text-white m-1 fs-5" href='index.php?action=Servicios' role="button">Servicios</a>
                                </li>
                                <li class="nav-item me-5">
                                    <a class="nav-link text-white m-1 fs-5" href="#Ubicacion">Ubicación y Contacto</a>
                                </li>
                            </ul>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a id="login_inic" class="nav-link text-white fs-5" href="javascript:void(0)">Login</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!--Final Barra Navegacion-->



    <!-- Sección Nosotros -->
    <section class="about-section">
        <div class="container position-relative">
            <!-- Historia -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="timeline-card p-5 position-relative">
                        <div class="timeline-marker"></div>
                        <h2 class="about-title text-center">Nuestra Historia</h2>
                        <div class="about-text">
                            <p>Hace 11 años, en el corazón de Montecarlos 2 (Ibagué, Tolima), nació un sueño que se convertiría en el alma del barrio. Comenzamos como una humilde panadería artesanal, donde cada producto llevaba el sello de calidad y dedicación que nos caracteriza.</p>

                            <div class="highlight-box">
                                <p>El crecimiento del barrio nos impulsó a transformarnos en el minimarket de referencia, ampliando nuestra oferta para satisfacer todas las necesidades de la comunidad, siempre manteniendo nuestra esencia familiar.</p>
                            </div>

                            <p>Hoy somos más que un comercio: somos el punto de encuentro donde los vecinos compran, conversan y crean lazos. Nuestro compromiso con la atención personalizada sigue siendo nuestro mayor orgullo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-img-container h-100">
                        <img src="./photo/fotolocalenfrente" alt="Nuestros inicios" class="about-img">
                    </div>
                </div>
            </div>

            <!-- Misión -->
            <div class="row align-items-center mb-5 flex-lg-row-reverse">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="timeline-card p-5 position-relative">
                        <div class="timeline-marker"></div>
                        <h2 class="about-title text-center">Nuestra Misión</h2>
                        <div class="about-text">
                            <p>En Variedades JYK nos dedicamos a:</p>
                            <ul class="mt-3">
                                <li class="mb-2">Ofrecer productos esenciales de máxima calidad a precios justos</li>
                                <li class="mb-2">Brindar una experiencia de compra cálida y personalizada</li>
                                <li class="mb-2">Ser el corazón comercial de Montecarlos 2</li>
                                <li>Mantener viva la tradición del comercio de barrio con valores familiares</li>
                            </ul>

                            <div class="highlight-box mt-4">
                                <p>Queremos que cada cliente se sienta como en casa, encontrando no solo lo que necesita, sino también una sonrisa y atención que hacen la diferencia.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-img-container h-100">
                        <img src="./photo/fotolocalinterior" alt="Nuestro local hoy" class="about-img">
                    </div>
                </div>
            </div>

            <!-- Visión -->
            <div class="row align-items-center">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="timeline-card p-5 position-relative">
                        <div class="timeline-marker"></div>
                        <h2 class="about-title text-center">Visión 2025</h2>
                        <div class="about-text">
                            <p>Nos proyectamos como:</p>

                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3" style="font-size: 24px; color: #ffffff;">➤</div>
                                <div>El establecimiento comercial líder en Montecarlos 2, ampliando nuestra variedad de productos y servicios</div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3" style="font-size: 24px; color: #ffffff;">➤</div>
                                <div>Un espacio que integre tecnología manteniendo el trato humano que nos caracteriza</div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="me-3" style="font-size: 24px; color: #ffffff;">➤</div>
                                <div>El modelo de comercio de barrio que combina tradición e innovación</div>
                            </div>

                            <div class="highlight-box mt-4">
                                <p>Nuestro compromiso es crecer sin perder la esencia que nos hizo queridos por la comunidad durante más de una década.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-img-container h-100">
                        <img src="./photo/fotoslocal1" alt="Nuestro futuro" class="about-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Inicio de Footer-->
    <div class="row" id="Ubicacion">
        <div class="col-12 justify-content-around aling-item-center">
            <div class="mt-2 text-white">
                <div class="text-center mt-1 p-2">
                    <p class="text-center mt-3">Cra. 16 Sur # 96-48 Ibagué - Tolima
                        <a class="navbar-brand" target="_blank" href="https://g.co/kgs/WpQrABT">
                            <img src="./photo/ubicacion.ico" alt="Ubicacion" width="35" height="35">
                        </a>
                    </p>
                </div>
                <div id="Contacto" class="text-center">
                    <p>Cel: 320 338 4589</p>
                </div>
            </div>
        </div>
    </div>
    <!--Iconos de Redes Sociales-->
    <div class="row">
        <div class="col-12 justify-content-evenly aling-item-center text-center">
            <div class="text-white mt-1">
                <h3 class="text-center">Redes Sociales</h3>
            </div>
            <div class="d-flex mt-4 justify-content-evenly aling-item-center">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="navbar-brand" target="_blank" href="https://es-es.facebook.com/">
                            <img src="./photo/facebook.ico" alt="Facebook" width="40" height="40">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" target="_blank" href="https://www.instagram.com/">
                            <img src="./photo/instagam.ico" alt="instagram" width="40" height="40">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" target="_blank" href="https://www.youtube.com/">
                            <img src="./photo/youtube.ico" alt="youtube" width="40" height="40">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" target="_blank" href="https://www.whatsapp.com/">
                            <img src="./photo/whatsapp.ico" alt="whatsapp" width="40" height="40">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="text-white text-center mt-4">
                <h3>Síguenos</h3>
            </div>
        </div>
    </div>
    <!--Final de Footer-->

    <!--Inicio de Pie de Pagina-->
    <div class="row">
        <div class="col-12 text-center text-white mt-3">
            <p>© 2024 - VariedadesJyk® / Minimarket Variedades S.A.S. NIT. 110.370.428-1 - Todos los Derechos Reservados.</p>
        </div>
    </div>
    <!--Fin de Pie de Pagina-->
    </div>

    <!--Fin ??--->

    <!--Formulario de login-->
    <div id="login_form" class="contenedor_loginG">
        <div class="contenedor-login mt-2">
            <h2>Inicio de sesión</h2>
            <form action="index.php?action=login" method="post">
                <div class="formulario1">
                    <div class="campo mt-3">
                        <label for="usuarioL">Usuario:</label>
                        <input type="text" id="usuario" name="usuarioL" placeholder="Ingrese su usuario" required>
                    </div>
                    <div class="campo">
                        <label for="contraseñaL">Contraseña:</label>
                        <div class="input-con-icono">
                            <input type="password" id="contrasena" name="contraseñaL" placeholder="Ingrese su contraseña" required>
                            <button type="button" id="togglePassword" class="icono-ojo">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="campo">
                        <button type="submit" class="btn btn-outline-secondary m-2 text-white text-center">Iniciar sesión</button>
                    </div>
                    <button id="cerrarL">X</button>
                </div>
            </form>
        </div>
    </div>



    <script src="./js/muestraContraseñaLogin.js?v=1.0"></script>
    <script src="./js/bootstrap.bundle.min.js?v=1.0"></script>
    <script src="./js/LoginInicio.js?v=1.0"></script>
    <script src="./js/recargaPagina.js?v=1.0"></script>
</body>

</html>
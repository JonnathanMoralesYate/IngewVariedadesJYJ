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
    <link rel="stylesheet" href="./css/DesingServicios.css?v=1.0">
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

    <!--Inicio -->
    <!-- Hero Section -->
    <section class="hero-services text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Nuestros Servicios</h1>
            <p class="lead mb-5">Descubre todo lo que podemos ofrecerte para hacer tu vida más fácil</p>
            <a href="#Ubicacion" class="btn btn-outline-light btn-lg px-4">Contáctanos</a>
        </div>
    </section>

    <!-- Servicios Principales -->
    <section id="servicios" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Servicios Destacados</h2>
            <div class="row text-light">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card p-4 text-center h-100">
                        <div class="service-icon">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <h3>Venta de Abarrotes</h3>
                        <p>Amplia variedad de productos de primera necesidad con la mejor calidad y precios competitivos.</p>
                        <ul class="text-start mt-3">
                            <li>Productos alimenticios básicos</li>
                            <li>Marcas reconocidas</li>
                            <li>Precios accesibles</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="service-card p-4 text-center h-100">
                        <div class="service-icon">
                            <i class="fas fa-bread-slice"></i>
                        </div>
                        <h3>Panadería Artesanal</h3>
                        <p>Pan fresco diario elaborado con recetas tradicionales y ingredientes de primera calidad.</p>
                        <ul class="text-start mt-3">
                            <li>Panadería tradicional</li>
                            <li>Productos horneados diariamente</li>
                            <li>Variedad de panes y dulces</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="service-card p-4 text-center h-100">
                        <div class="service-icon">
                            <i class="fas fa-broom"></i>
                        </div>
                        <h3>Productos de Limpieza</h3>
                        <p>Todos los artículos necesarios para mantener tu hogar impecable y desinfectado.</p>
                        <ul class="text-start mt-3">
                            <li>Detergentes y desinfectantes</li>
                            <li>Artículos de limpieza para el hogar</li>
                            <li>Marcas de calidad</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Características Especiales -->
    <section class="py-5 ">
        <div class="container">
            <div class="row align-items-center bg-#1E1E1ECC">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Servicio a domicilio" class="img-fluid rounded">
                    </div>
                </div>
                <div class="col-lg-6 text-white">
                    <h2 class="mb-4 text-light text-center">Servicio a Domicilio</h2>
                    <p>Llevamos tus compras hasta la puerta de tu casa con nuestro servicio de entrega rápido y confiable.</p>
                    <div class="row mt-4 bg-#1E1E1ECC">
                        <div class="col-md-6 mb-3">
                            <div class="service-feature text-center h-100">
                                <div class="feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h4>Entrega Rápida</h4>
                                <p>Recibe tus productos en menos de 2 horas dentro de nuestra zona de cobertura.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="service-feature text-center h-100">
                                <div class="feature-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h4>Pedidos por Teléfono</h4>
                                <p>Realiza tu pedido fácilmente con una simple llamada telefónica.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner de Promoción -->
    <section class="service-banner text-center">
        <div class="container">
            <h2 class="display-5 mb-4">¡Descuentos Especiales para Clientes Frecuentes!</h2>
            <p class="lead mb-4">Regístrate en nuestro programa de fidelidad y obtén beneficios exclusivos</p>
    </section>


    <!-- Servicios Adicionales -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Otros Servicios</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card p-4 text-light text-center h-100">
                        <div class="service-icon">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <h4>Pago de Servicios</h4>
                        <p>Realiza el pago de tus servicios públicos sin salir de tu barrio.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card p-4 text-light text-center h-100">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Recargas</h4>
                        <p>Recargas para todos los operadores móviles al instante.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card p-4 text-center text-light h-100">
                        <div class="service-icon">
                            <i class="fas fa-gifts"></i>
                        </div>
                        <h4>Regalos</h4>
                        <p>Variedad de artículos para regalo para todas las ocasiones.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card p-4 text-light text-center h-100">
                        <div class="service-icon">
                            <i class="fas fa-ice-cream"></i>
                        </div>
                        <h4>Productos Congelados</h4>
                        <p>Amplia selección de productos congelados de calidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Inicio de Footer-->
    <div class="row" id="Ubicacion">
        <div class="col-12 justify-content-around aling-item-center">
            <div class="mt-5 text-white">
                <div class="text-center mt-1 p-2">
                    <p class="text-center">Cra. 16 Sur # 96-48 Ibagué - Tolima
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js?v=1.0"></script>
    <script src="./js/LoginInicio.js?v=1.0"></script>
    <script src="./js/recargaPagina.js"></script>
</body>

</html>
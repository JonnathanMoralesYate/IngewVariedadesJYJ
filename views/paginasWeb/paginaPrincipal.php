<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./photo/logoPesta.ico" type="image/x-icon">
    <title>Minimarket Variedades JYK</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css?v=1.0">
    <link rel="stylesheet" href="./css/DesingBody.css">
    <link rel="stylesheet" href="./css/DesingLogin2.css?v=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <div class="container-fluid" id="barra_navegacion">
        <!--Inicio Barra Navegacion-->
        <div class="row p-3">
            <div class="col-2 mt-2">
                <nav class="img-fluid d-block text-center" id="inicio">
                    <a class="navbar-brand" href='index.php?action=Principal'>
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
                        <!-- Contenido del menú -->
                        <div class="collapse navbar-collapse mt-2" id="navbarTogglerDemo01">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item me-3">
                                    <a class="nav-link text-white m-1 fs-5" href="index.php?action=Nosotros">Nosotros</a>
                                </li>
                                <li class="nav-item me-3">
                                    <a class="nav-link text-white m-1 fs-5" href="index.php?action=Servicios">Servicios</a>
                                </li>
                                <li class="nav-item me-3">
                                    <a class="nav-link text-white m-1 fs-5" href="#Ubicacion">Ubicación y Contacto</a>
                                </li>
                                <li class="nav-item me-3">
                                    <form id="formBuscarProducto" class="d-flex" action="index.php?action=consultaProductoNombre" method="POST" role="search">
                                        <input id="inputNombreProducto" class="form-control m-2 me-3" type="search" placeholder="Buscar Producto" name="Nombre" aria-label="Search">
                                        <button class="btn btn-outline-secondary text-white m-2" type="submit">Buscar</button>
                                    </form>
                                </li>
                            </ul>
                            <!-- Sección Login alineada a la derecha -->
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

    <!--Inicio Carrusel-->
    <div id="carouselExampleControls" class="carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-inner text-center">

            <!-- Slide fijo: Nuestra Sede -->
            <div class="carousel-item active">
                <div class="card mx-auto" style="max-width: 30rem;">
                    <img src="./photo/variedadesJyK.jpg" class="img-fluid mx-auto rounded" alt="Sede">
                    <div class="card-body container-fluid">
                        <h5 class="card-title">Nuestra Sede</h5>
                    </div>
                </div>
            </div>

            <!-- Slides dinámicos agrupados de 3 en 3 -->
            <?php
            $grupos = array_chunk($promociones, 3); // Agrupa de 3 en 3
            foreach ($grupos as $index => $grupo):
            ?>
                <div class="carousel-item<?= $index === 0 ? '' : '' ?>"> <!-- sin active, ya lo tiene la sede -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 d-flex justify-content-evenly">
                        <?php foreach ($grupo as $promo): ?>
                            <div class="col">
                                <div class="card mx-auto" style="width: 16rem;">
                                    <img src="./photo/<?= htmlspecialchars($promo['Foto']) ?>" class="img-fluid mx-auto" alt="<?= htmlspecialchars($promo['Producto']) ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($promo['Producto']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($promo['Descripcion']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Controles del carrusel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Atrás</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Adelante</span>
            </button>
        </div>
        <!--Fin Carrusel -->

        <!--Inicio de Barra Categorias -->
        <div class="row container-fluid mt-5 text-center d-flex flex-column flex-md-row">
            <!-- Sección de Categorías -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="text-center text-white">
                    <span class="fs-3">Categorías</span>
                </div>
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                    <div class="overflow-auto" style="max-height: 500px;">
                        <?php foreach ($clases as $clase): ?>
                            <div class="mt-1">
                                <div class="btn-group dropend w-100">
                                    <button type="button" class="btn btn-outline-secondary text-white w-100" aria-expanded="false" onclick="obtenerInforProductoPorClase(<?= $clase['idClase']; ?>)">
                                        <?= $clase['Clase']; ?>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Vista de Productos por Categoría -->
            <div class="col-12 col-md-8 col-lg-9 mt-3">
                <div id="productos-container" class="row row-cols-1 row-cols-md-3 g-4"></div>
                <div id="paginacion-container" class="mt-3 d-flex justify-content-center"></div>
            </div>
        </div>
        <!--Fin Barra Categorias -->

        <!--Inicio de Footer-->
        <div class="row" id="Ubicacion">
            <!--Imagen-->
            <div class="col-12 col-lg-3 mt-5">
                <div class="img-fluid d-block text-center">
                    <a class="navbar-brand" href="index.php"><img src="./photo/logopest2.ico" alt="Logo" class="img-fluid text-center rounded-3"></a>
                </div>
            </div>
            <!--Informacion general de VariedadesJYK-->
            <div class="col-12 col-lg-3">
                <div class="text-start">
                    <div class="d-block mt-5 text-white">
                        <div>
                            <p>Línea de Servicio al Cliente</p>
                        </div>
                        <div id="Contacto" class="mt-1">
                            <p>Cel: 320 338 4589</p>
                        </div>
                        <div class="d-flex mt-1">
                            <div class="aling-item-center mt-1  me-auto">
                                <p>Cra. 16 Sur # 96-48</p>
                            </div>
                            <div class=""><a class="navbar-brand" target="_blank" href="https://g.co/kgs/WpQrABT"><img src="./photo/ubicacion.ico" alt="Ubicacion" width="35" height="35"></a></div>
                        </div>
                        <div class="mt-1">
                            <p>Ibagué - Tolima</p>
                        </div>
                        <div class="mt-1">
                            <p>Servicioalcliente@Variedades.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="text-start">
                    <div class="d-block mt-5 text-white">
                        <div class="mt-1">
                            <p>INFORMACIÓN LEGAL</p>
                        </div>
                        <div class="mt-1">
                            <p>Términos y Condiciones de Cambio </p>
                        </div>
                        <div class="mt-1">
                            <p>Política Tratamiento de Datos Personales</p>
                        </div>
                        <div class="mt-1">
                            <p><a href="./util/Manual_de_Usuario_INGEW.pdf" target="_blank" class="text-white text-decoration-none">Manual del Usuario</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--Iconos de Redes Sociales-->
            <div class="col-12 col-sm-3">
                <div class="text-white mt-5">
                    <h3 class="text-center">Redes Sociales</h3>
                </div>
                <div class="d-flex mt-4 justify-content-evenly aling-item-center">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="navbar-brand" target="_blank" href="https://es-es.facebook.com/">
                                <img src="./photo/facebook.ico" alt="Facebook" width="50" height="50">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand" target="_blank" href="https://www.instagram.com/">
                                <img src="./photo/instagam.ico" alt="instagram" width="50" height="50">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand" target="_blank" href="https://www.youtube.com/">
                                <img src="./photo/youtube.ico" alt="youtube" width="50" height="50">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand" target="_blank" href="https://www.whatsapp.com/">
                                <img src="./photo/whatsapp.ico" alt="whatsapp" width="50" height="50">
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
            <div class="col-12 text-center text-white">
                <p>© 2024 - VariedadesJyk® / Minimarket Variedades S.A.S. NIT. 110.370.428-1 - Todos los Derechos Reservados.</p>
            </div>
        </div>
        <!--Fin de Pie de Pagina-->
    </div>


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
    <script src="./js/agregaProductosPaginaP.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/LoginInicio.js?v=1.0"></script>
    <script src="./js/recargaPagina.js?v=1.0"></script>

</body>

</html>
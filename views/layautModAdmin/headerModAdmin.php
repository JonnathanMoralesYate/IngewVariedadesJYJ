<?php
    require_once ('util/middleware.php');
    permisoAdministardor();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/img/logoPesta.ico" type="image/x-icon">
    <title>Modulo Administrativo JYK</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css?v=1.0">
    <link rel="stylesheet" href="./css/DesingBody.css">
    <link rel="stylesheet" href="./css/DesingExtraModulo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!--Inicio-->
    <main class="container-fluid flex-grow-1">
        <div class="container-fluid">
            <div class="row p-3 mt-1">
                <div class="text-center text-white mt-1">
                    <h2>MINIMARKET VARIEDADES JYK</h2>
                </div>
                <div class="text-center text-white mt-2">
                    <h3> Modulo Administrativo</h3>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-white mt-3">
                    <div class="text-center text-md-start">
                        <h6>Bienvenido: <?= $_SESSION['nombre'] ?> <?= $_SESSION['apellido'] ?></h6>
                    </div>
                    <div class="text-center text-md-end">
                        <?php
                        date_default_timezone_set('America/Bogota');
                        $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                        echo $formatter->format(new DateTime());
                        ?>
                    </div>
                </div>
            </div>
            <!--Fin-->

            <!--Inicio Barra de Navegacion Administrativo-->
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <!-- Botón para menú en móviles -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-white">MENU</span>
                    </button>

                    <!-- Contenedor del menú -->
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <a class="navbar-brand text-white" href="index.php?action=vistaAdmin">Inicio</a>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <!-- Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown">Productos</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroProductos">Registrar Producto</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaProductos">Consultar Producto</a></li>
                                </ul>
                            </li>

                            <!-- Entradas Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="entradasDropdown" role="button" data-bs-toggle="dropdown">Entrada de Productos</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroEntProductos">Registrar Entrada</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaEntProductos">Consultar Entrada</a></li>
                                </ul>
                            </li>

                            <!-- Salidas Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="salidasDropdown" role="button" data-bs-toggle="dropdown">Salida de Productos</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroSalProductos">Registrar Salida</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=registroSalProductosP">Registrar Salidas</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaSalProductos">Consultar Salida</a></li>
                                </ul>
                            </li>

                            <!-- Clientes -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="clientesDropdown" role="button" data-bs-toggle="dropdown">Clientes</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroCliente">Registrar Cliente</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaCliente">Consultar Cliente</a></li>
                                </ul>
                            </li>

                            <!-- Proveedores -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="proveedoresDropdown" role="button" data-bs-toggle="dropdown">Proveedores</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroProveedor">Registrar Proveedor</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaProveedor">Consultar Proveedor</a></li>
                                </ul>
                            </li>

                            <!-- Reportes -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown">Reportes</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=reporteEntProducto">Entradas Productos</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=reporteSalProducto">Salidas Productos</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=reporteInventario">Inventario</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=reporteSinStock">Stock Agotado</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=productosAvencer">Productos a Vencer</a></li>
                                </ul>
                            </li>

                            <!-- Empleados -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="empleadosDropdown" role="button" data-bs-toggle="dropdown">Empleados</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroUsuario">Registrar Empleado</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaUsuarios">Consultar Empleado</a></li>
                                </ul>
                            </li>

                            <!-- Promociones -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="empleadosDropdown" role="button" data-bs-toggle="dropdown">Promociones</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroPromocion">Registrar Promocion</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaPromociones">Consultar Promociones</a></li>
                                </ul>
                            </li>

                            <!-- Propiedades -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="propiedadesDropdown" role="button" data-bs-toggle="dropdown">Propiedades</a>
                                <ul class="dropdown-menu">
                                    <!-- Clase Producto -->
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="claseProductoDropdown" role="button" data-bs-toggle="dropdown">Clase Producto</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="index.php?action=registroClase">Registrar Clase</a></li>
                                            <li><a class="dropdown-item" href="index.php?action=consultaClase">Consultar Clase</a></li>
                                        </ul>
                                    </li>

                                    <!-- Formato Venta -->
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="formatoVentaDropdown" role="button" data-bs-toggle="dropdown">Formato Venta</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="index.php?action=registroFormatoVenta">Registrar Formato</a></li>
                                            <li><a class="dropdown-item" href="index.php?action=consultaFormatoVenta">Consultar Formato</a></li>
                                        </ul>
                                    </li>

                                    <!-- Presentación Producto -->
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="presentacionProductoDropdown" role="button" data-bs-toggle="dropdown">Presentación Producto</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="index.php?action=registroPresentacion">Registrar Presentación</a></li>
                                            <li><a class="dropdown-item" href="index.php?action=consultaPresentacion">Consultar Presentación</a></li>
                                        </ul>
                                    </li>

                                    <!-- Unidad Base -->
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="#" id="unidadBaseDropdown" role="button" data-bs-toggle="dropdown">Unidad Base</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="index.php?action=registroUndBase">Registrar Unidad</a></li>
                                            <li><a class="dropdown-item" href="index.php?action=consultaUndBasen">Consultar Unidad</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <!-- Botón de Logout -->
                        <form action="index.php?action=cerrarSesion" method="POST">
                            <input type="hidden" name="action" value="cerrarSesion">
                            <button type="submit" class="btn btn-outline-secondary text-white">Log Out</button>
                        </form>
                    </div>
                </div>
            </nav>
            <!--Fin Barra de Navegacion Administrativo-->
<?php
    require_once ('util/middleware.php');
    permisoEmpleado();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/img/logoPesta.ico" type="image/x-icon">
    <title>Modulo Empleado JYK</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css?v=1.0">
    <link rel="stylesheet" href="./css/DesingBody.css?v=1.0">
    <link rel="stylesheet" href="./css/DesingExtraModulo.css?v=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid">
            <div class="row p-3 mt-1">
                <div class="text-center text-white mt-1">
                    <h2>MINIMARKET VARIEDADES JYK</h2>
                </div>
                <div class="text-center text-white mt-2">
                    <h3> Modulo Empleado</h3>
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
            <!--fin-->

            <!--Inicio Barra de Navegacion Empleado-->

            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <!-- Botón para menú en móviles -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-white">MENU</span>
                    </button>

                    <!-- Contenedor del menú -->
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <a class="navbar-brand text-white" href="index.php?action=vistaEmple">Inicio</a>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <!-- Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown">Productos</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroProductosEmp">Registrar Producto</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaProductosEmp">Consultar Producto</a></li>
                                </ul>
                            </li>

                            <!-- Entradas Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="entradasDropdown" role="button" data-bs-toggle="dropdown">Entrada de Productos</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroEntProductosEmp">Registrar Entrada</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaEntProductosEmp">Consultar Entrada</a></li>
                                </ul>
                            </li>

                            <!-- Salidas Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="salidasDropdown" role="button" data-bs-toggle="dropdown">Salida de Productos</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroSalProductosEmp">Registrar Salida</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=registroSalProductosEmpP">Registrar Salidas</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaSalProductosEmp">Consultar Salida</a></li>
                                </ul>
                            </li>

                            <!-- Clientes -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="clientesDropdown" role="button" data-bs-toggle="dropdown">Clientes</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroClienteEmp">Registrar Cliente</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaClienteEmp">Consultar Cliente</a></li>
                                </ul>
                            </li>

                            <!-- Proveedores -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="proveedoresDropdown" role="button" data-bs-toggle="dropdown">Proveedores</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=registroProveedorEmp">Registrar Proveedor</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=consultaProveedorEmp">Consultar Proveedor</a></li>
                                </ul>
                            </li>

                            <!-- Reportes -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown">Reportes</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?action=reporteEntProductoEmp">Entradas Productos</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=reporteSalProductoEmp">Salidas Productos</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=reporteInventarioEmp">Inventario</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=reporteSinStockEmp">Stock Agotado</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=productosAvencerEmp">Productos a Vencer</a></li>
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
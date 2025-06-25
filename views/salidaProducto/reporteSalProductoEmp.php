<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Reporte de Salida de Producto-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Reporte de Salida de Productos</h4>
            </div>
            <div class="text-center text-white mt-3">
                <p>Fecha de Inicio: <?= htmlspecialchars($data['fechaInc']); ?></p>
                <p>Fecha de Fin: <?= htmlspecialchars($data['fechaFin']); ?></p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8 col-10">
            <div class="d-flex justify-content-center">
                <a class="btn btn-outline-secondary text-white mt-3 w-50 text-center"
                    href="index.php?action=reporteSalProductosPDF&fechaInc=<?= htmlspecialchars($data['fechaInc']); ?>&fechaFin=<?= htmlspecialchars($data['fechaFin']); ?>"
                    target="_blank">
                    Generar PDF
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-5">
                <h4>Filtro de Producto Nombre</h4>
            </div>
            <!-- Buscar por Nombre -->
            <form class="mt-3" action="index.php?action=consultaSalProductosNombreEmp" method="get">
                <input type="hidden" name="action" value="consultaSalProductosNombreEmp">
                <input type="hidden" name="fechaInc" value="<?= htmlspecialchars($data['fechaInc']); ?>">
                <input type="hidden" name="fechaFin" value="<?= htmlspecialchars($data['fechaFin']); ?>">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre Producto" name="nombre" required>
                    <button class="btn btn-outline-secondary text-white" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Fin de consultar-->

<!--Inicio para mostrar datos para buscar y consultar-->
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <div class="text-center">
                <?php if (isset($data['reporteSalProductos']) && count($data['reporteSalProductos']) > 0): ?>
                    <!-- Tabla responsiva-->
                    <div class="table-responsive mt-5">
                        <table class="table table-hover text-white text-center">
                            <thead>
                                <tr>
                                    <th>Fecha Salida</th>
                                    <th>Cliente</th>
                                    <th>Codigo Producto</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Descripcion</th>
                                    <th>Contenido</th>
                                    <th>Cantidad Salida</th>
                                    <th>Total Venta</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php foreach ($data['reporteSalProductos'] as $salProducto): ?>
                                    <tr>
                                        <td class="text-white align-middle"><?= $salProducto['FechaSalida']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['NumIdentificacion']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['CodProducto']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['Nombre']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['Marca']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['Descripcion']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['Contenido Neto']; ?></td>
                                        <td class="text-white align-middle"><?= $salProducto['CantSalida']; ?></td>
                                        <td class="text-white align-middle"><?= '$' . number_format($salProducto['PrecioVenta'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <?php
                    $totalPaginas = $data['totalPaginas'];
                    $paginaActual = $data['pagina'];
                    $tipo = $data['tipo']; // 'codigo' o 'nombre'
                    $filtro = urlencode($data['filtro']);
                    $param = "nombre=$filtro";
                    $action = 'consultaSalProductosNombreEmp';

                    $maxPaginasVisibles = 7;
                    $inicio = max(1, $paginaActual - intval($maxPaginasVisibles / 2));
                    $fin = min($inicio + $maxPaginasVisibles - 1, $totalPaginas);
                    if (($fin - $inicio + 1) < $maxPaginasVisibles) {
                        $inicio = max(1, $fin - $maxPaginasVisibles + 1);
                    }
                    ?>

                    <!-- Paginación PHP -->
                    <?php if ($totalPaginas > 1): ?>
                        <?php if ($totalPaginas > 1): ?>
                            <nav>
                                <ul class="pagination justify-content-center flex-wrap mt-3">
                                    <!-- Anterior -->
                                    <li class="page-item <?= $paginaActual <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&fechaInc=<?= urlencode($data['fechaInc']) ?>&fechaFin=<?= urlencode($data['fechaFin']) ?>&pagina=<?= max(1, $paginaActual - 1) ?>">
                                            Anterior
                                        </a>
                                    </li>

                                    <!-- Numeración -->
                                    <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                                        <li class="page-item <?= $paginaActual == $i ? 'active' : '' ?>">
                                            <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&fechaInc=<?= urlencode($data['fechaInc']) ?>&fechaFin=<?= urlencode($data['fechaFin']) ?>&pagina=<?= $i ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Siguiente -->
                                    <li class="page-item <?= $paginaActual >= $totalPaginas ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&fechaInc=<?= urlencode($data['fechaInc']) ?>&fechaFin=<?= urlencode($data['fechaFin']) ?>&pagina=<?= min($totalPaginas, $paginaActual + 1) ?>">
                                            Siguiente
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                        <?php endif; ?>
                    <?php endif; ?>

                <?php else: ?>
                    <p class="text-white text-center">No se encontraron productos con ese criterio de búsqueda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    </main>

    <?php include('./views/layautModEmple/footerModEmplea.php');  ?>
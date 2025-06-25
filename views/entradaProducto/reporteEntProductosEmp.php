<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Inicio de Formulario Reporte de Entradas Producto-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Reporte de Entradas de Productos</h4>
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
                    href="index.php?action=reporteEntProductosPDF&fechaInc=<?= htmlspecialchars($data['fechaInc']); ?>&fechaFin=<?= htmlspecialchars($data['fechaFin']); ?>"
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
            <form class="mt-3" action="index.php?action=consultaEntProductosNombreEmp" method="get">
                <input type="hidden" name="action" value="consultaEntProductosNombreEmp">
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
                <?php if (isset($data['reporteEntProductos']) && count($data['reporteEntProductos']) > 0): ?>
                    <h4 class="text-white">Resultados de la Búsqueda:</h4>
            </div>
            <div class="table-responsive">
                <table class="table text-white text-center">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Fecha Entrada</th>
                            <th>Proveedor</th>
                            <th>Codigo Producto</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Descripcion</th>
                            <th>Contenido</th>
                            <th>Fecha Vencimiento</th>
                            <th>Precio Compra</th>
                            <th>Cantidad Entrada</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['reporteEntProductos'] as $entProducto): ?>
                            <tr>
                                <!-- <td class="text-white align-middle"><?= $entProducto['idEntProducto']; ?></td> -->
                                <td class="text-white align-middle"><?= $entProducto['FechaEnt']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['NombreProveedor']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['CodProducto']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['Nombre']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['Marca']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['Descripcion']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['Contenido Neto']; ?></td>
                                <td class="text-white align-middle"><?= $entProducto['FechaVencimiento']; ?></td>
                                <td class="text-white align-middle"><?= '$' . number_format($entProducto['PrecioCompra'], 0, ',', '.'); ?></td>
                                <td class="text-white align-middle"><?= $entProducto['CantEnt']; ?></td>
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
                    $action = 'consultaEntProductosNombreEmp';

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
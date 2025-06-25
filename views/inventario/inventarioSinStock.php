<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Reporte de Inventario de Productos-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Reporte de Productos Agotados en Inventario</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8 col-10">
            <div class="d-flex justify-content-center">
                <a class="btn btn-outline-secondary text-white mt-3 w-50 text-center"
                    href="index.php?action=reporteSinStockPDF"
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
                <h4>Filtrode Producto Nombre</h4>
            </div>
            <!-- Buscar por Nombre -->
            <form class="mt-3" action="index.php?action=consultaProductosNombreSinStock" method="get">
                <input type="hidden" name="action" value="consultaProductosNombreSinStock">
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
                <?php if (isset($data['productoSinStock']) && count($data['productoSinStock']) > 0): ?>
                    <h4 class="text-white">Resultados de la Búsqueda:</h4>
            </div>
            <div class="table-responsive">
                <table class="table text-white text-center">
                    <thead>
                        <tr>
                            <th>Codigo Producto</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Descripcion</th>
                            <th>Presentacion</th>
                            <th>Formato Venta</th>
                            <th>Cantidad Actual</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['productoSinStock'] as $inventario): ?>
                            <tr>
                                <td class="text-white align-middle"><?= $inventario['CodProducto']; ?></td>
                                <td class="text-white align-middle"><?= $inventario['Nombre']; ?></td>
                                <td class="text-white align-middle"><?= $inventario['Marca']; ?></td>
                                <td class="text-white align-middle"><?= $inventario['Descripcion']; ?></td>
                                <td class="text-white align-middle"><?= $inventario['Contenido Neto']; ?></td>
                                <td class="text-white align-middle"><?= $inventario['FormatoVenta']; ?></td>
                                <td class="text-white align-middle"><?= $inventario['CantActual']; ?></td>
                                <td><img src="photo/<?= $inventario['Foto']; ?>" width="100" alt="foto"></td>
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
                    $action = 'consultaProductosNombreSinStock';

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
                                <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&pagina=<?= $paginaActual - 1 ?>">Anterior</a>
                            </li>

                            <!-- Numeración -->
                            <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                                <li class="page-item <?= $paginaActual == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&pagina=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Siguiente -->
                            <li class="page-item <?= $paginaActual >= $totalPaginas ? 'disabled' : '' ?>">
                                <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
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


<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
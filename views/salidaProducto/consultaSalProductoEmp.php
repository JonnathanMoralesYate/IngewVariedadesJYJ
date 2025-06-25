<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Consultar ESalida Producto-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Consulta Salida de Productos</h4>
            </div>
            <form class=" mt-4" action="index.php?action=consultaSalProductoCodigoEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaSalProductoCodigoEmp">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Codigo Producto" name="codProducto" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>

            <form class=" mt-2" action="index.php?action=consultaSalProductoFechaEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaSalProductoFechaEmp">
                <div class="input-group mb-3">
                    <input type="date" class="form-control" placeholder="Fecha salida Producto" name="fechaSal" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Fin de consultar-->

<!--Inicio para mostrar datos para buscar y consultar-->
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1"> <!-- Ocupa toda la pantalla en móviles, con margen en pantallas grandes -->
            <!-- Inicio de tabla -->
            <div class="text-center">
                <?php if (isset($data['salProductos']) && count($data['salProductos']) > 0): ?>
                    <h4 class="text-white">Resultados de la Búsqueda:</h4>
            </div>
            <!-- Tabla responsiva -->
            <div class="table-responsive">
                <table class="table table-hover text-white text-center">
                    <thead>
                        <tr>
                            <th>Fecha Salida</th>
                            <th>Cliente</th>
                            <th>Código Producto</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Descripción</th>
                            <th>Contenido</th>
                            <th>Precio Venta</th>
                            <th>Cantidad Salida</th>
                            <th>Forma de Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['salProductos'] as $salProducto): ?>
                            <tr>
                                <td class="text-white align-middle"><?= $salProducto['FechaSalida']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['NumIdentificacion']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['CodProducto']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['Nombre']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['Marca']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['Descripcion']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['Contenido Neto']; ?></td>
                                <td class="text-white align-middle"><?= '$' . number_format($salProducto['PrecioVenta'], 0, ',', '.'); ?></td>
                                <td class="text-white align-middle"><?= $salProducto['CantSalida']; ?></td>
                                <td class="text-white align-middle"><?= $salProducto['ModoPago']; ?></td>
                                <td>
                                    <a href="index.php?action=actualizarSalProductosIdEmp&idSalProducto=<?= $salProducto['idSalProducto']; ?>" class="btn btn-outline-secondary text-white m-2 w-100">Actualizar</a>
                                </td>
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
                    $action = $tipo === 'codigo' ? 'consultaSalProductoCodigoEmp' : 'consultaSalProductoFechaEmp';
                    $param = $tipo === 'codigo' ? "codProducto=$filtro" : "fechaSal=$filtro";

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

<?php include('./views/layautModEmple/footerModEmplea.php');  ?>
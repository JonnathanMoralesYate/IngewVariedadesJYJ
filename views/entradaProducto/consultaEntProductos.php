<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Consultar Entradas Producto-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Consulta Entrada de Productos</h4>
            </div>
            <form class=" mt-4" action="index.php?action=consultaEntProductoCodigo" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaEntProductoCodigo">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Codigo del Producto" name="codProducto" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>

            <form class=" mt-2" action="index.php?action=consultaEntProductoFecha" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaEntProductoFecha">
                <div class="input-group mb-3">
                    <input type="date" class="form-control" placeholder="Fecha Entrada Producto" name="fechaEnt" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
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
        <div class="col-12 col-md-10 offset-md-1">
            <div class="text-center">
                <?php if (isset($data['entProductos']) && count($data['entProductos']) > 0): ?>
                    <h4 class="text-white">Resultados de la Busqueda:</h4>
            </div>
            <!-- Tabla responsiva-->
            <div class="table-responsive">
                <table class="table table-hover text-white text-center">
                    <thead>
                        <tr>
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['entProductos'] as $entProducto): ?>
                            <tr>
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
                                <td>
                                    <a href="index.php?action=actualizarEntProductosId&idEntProducto=<?= $entProducto['idEntProducto']; ?>" class="btn btn-outline-secondary text-white m-2 w-100" role="button">Actualizar</a>
                                    <a href="index.php?action=eliminarEntProductoId&idEntProducto=<?= $entProducto['idEntProducto']; ?>" class="btn btn-outline-secondary text-white m-2 w-100" role="button">Eliminar</a>
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
                    $action = $tipo === 'codigo' ? 'consultaEntProductoCodigo' : 'consultaEntProductoFecha';
                    $param = $tipo === 'codigo' ? "codProducto=$filtro" : "fechaEnt=$filtro";

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
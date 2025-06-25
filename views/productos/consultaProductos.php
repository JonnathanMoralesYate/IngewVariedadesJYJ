<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Inicio de Formulario Consultar Producto-->

<!-- Formulario de búsqueda -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Consulta de Productos</h4>
            </div>
            <!-- Buscar por Código -->
            <form class="mt-4" action="index.php?action=consultaProductosCodigo" method="get">
                <input type="hidden" name="action" value="consultaProductosCodigo">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Código Producto" name="codProduc" required>
                    <button class="btn btn-outline-secondary text-white" type="submit">Buscar</button>
                </div>
            </form>
            <!-- Buscar por Nombre -->
            <form class="mt-2" action="index.php?action=consultaProductosNombre" method="get">
                <input type="hidden" name="action" value="consultaProductosNombre">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre Producto" name="nombre" required>
                    <button class="btn btn-outline-secondary text-white" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mostrar resultados -->
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <div class="text-center">
                <?php if (isset($data['productos']) && count($data['productos']) > 0): ?>
                    <h4 class="text-white">Resultados de la Búsqueda:</h4>
            </div>
            <div class="table-responsive">
                <table class="table text-white text-center">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Clase</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Descripción</th>
                            <th>Presentación</th>
                            <th>Contenido Neto</th>
                            <th>Formato Venta</th>
                            <th>Precio Venta</th>
                            <th>Foto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['productos'] as $producto): ?>
                            <tr>
                                <td><?= $producto['CodProducto']; ?></td>
                                <td><?= $producto['Clase']; ?></td>
                                <td><?= $producto['Nombre']; ?></td>
                                <td><?= $producto['Marca']; ?></td>
                                <td><?= $producto['Descripcion']; ?></td>
                                <td><?= $producto['Presentacion']; ?></td>
                                <td><?= $producto['Contenido']; ?></td>
                                <td><?= $producto['FormatoVenta']; ?></td>
                                <td><?= '$' . number_format($producto['PrecioVenta'], 0, ',', '.'); ?></td>
                                <td><img src="photo/<?= $producto['Foto']; ?>" width="100"></td>
                                <td>
                                    <a href="index.php?action=actualizarProductosCodigo&codProduc=<?= $producto['CodProducto']; ?>" class="btn btn-outline-secondary text-white m-2 w-100">Actualizar</a>
                                    <a href="index.php?action=eliminarProductoCodigo&codProduc=<?= $producto['CodProducto']; ?>" class="btn btn-outline-secondary text-white m-2 w-100">Eliminar</a>
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
                    $param = $tipo === 'codigo' ? "codProduc=$filtro" : "nombre=$filtro";
                    $action = $tipo === 'codigo' ? 'consultaProductosCodigo' : 'consultaProductosNombre';

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
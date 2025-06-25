<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Consultar Proveedores-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Consulta de Proveedores</h4>
            </div>
            <form class=" mt-4" action="index.php?action=consultaProveedorNitEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaProveedorNitEmp">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nit Proveedor" name="nitProveedor" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>

            <form class=" mt-2" action="index.php?action=consultaProveedorNombreEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaProveedorNombreEmp">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre Proveedor" name="nomProveedor" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>

            <form class=" mt-2" action="index.php?action=consultaVendedorNombreEmp" method="get">
                <div class="input-group mb-3">
                    <input type="hidden" class="form-control" name="action" value="consultaVendedorNombreEmp">
                    <input type="text" class="form-control" placeholder="Nombre Vendedor" name="nomVendedor" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
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
                <?php if (isset($data['proveedores']) && count($data['proveedores']) > 0): ?>
                    <h4 class="text-white">Resultados de la Busqueda:</h4>
            </div>
            <!-- Tabla responsiva-->
            <div class="table-responsive">
                <table class="table table-hover text-white text-center">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Nit</th>
                            <th>Nombre Empresa</th>
                            <th>Correo</th>
                            <th>Contacto de Empresa</th>
                            <th>Nombre Vendedor</th>
                            <th>Contacto Vendedor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['proveedores'] as $proveedor): ?>
                            <tr>
                                <!-- <td class="text-white align-middle"><?= $proveedor['idProveedor']; ?></td> -->
                                <td class="text-white align-middle"><?= $proveedor['NitProveedor']; ?></td>
                                <td class="text-white align-middle"><?= $proveedor['NombreProveedor']; ?></td>
                                <td class="text-white align-middle"><?= $proveedor['Email']; ?></td>
                                <td class="text-white align-middle"><?= $proveedor['CelularProveedor']; ?></td>
                                <td class="text-white align-middle"><?= $proveedor['NombreVendedor']; ?></td>
                                <td class="text-white align-middle"><?= $proveedor['CelularVendedor']; ?></td>
                                <td class="text-white align-middle">
                                    <a href="index.php?action=actualizarProveedorIdEmp&idProveedor=<?= $proveedor['idProveedor']; ?>" class="btn btn-outline-secondary text-white m-2 w-100" role="button">Actualizar</a>
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

                    $action =        match ($tipo) {
                        'codigo' => 'consultaProveedorNitEmp',
                        'nombreP' => 'consultaProveedorNombreEmp',
                        'nombreV' => 'consultaVendedorNombreEmp',
                        default => 'consultaProveedorEmp'
                    };

                    $param = match ($tipo) {
                        'codigo' => "nitProveedor=" . urlencode($filtro),
                        'nombreP' => "nomProveedor=" . urlencode($filtro),
                        'nombreV'  => "nomVendedor=" . urlencode($filtro),
                        default => '',
                    };


                    $maxPaginasVisibles = 7;
                    $inicio = max(1, $paginaActual - intval($maxPaginasVisibles / 2));
                    $fin = min($inicio + $maxPaginasVisibles - 1, $totalPaginas);
                    if (($fin - $inicio + 1) < $maxPaginasVisibles) {
                        $inicio = max(1, $fin - $maxPaginasVisibles + 1);
                    }
            ?>

            <!-- Paginación PHP -->
            <?php if ($totalPaginas > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center flex-wrap mt-3">
                        <li class="page-item <?= $paginaActual <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&tipo=<?= urlencode($tipo) ?>&filtro=<?= urlencode($filtro) ?>&pagina=<?= $paginaActual - 1 ?>">Anterior</a>
                        </li>

                        <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                            <li class="page-item <?= $paginaActual == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&tipo=<?= urlencode($tipo) ?>&filtro=<?= urlencode($filtro) ?>&pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= $paginaActual >= $totalPaginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=<?= $action ?>&<?= $param ?>&tipo=<?= urlencode($tipo) ?>&filtro=<?= urlencode($filtro) ?>&pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>
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
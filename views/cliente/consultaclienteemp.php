<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Consultar Clientes-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Consulta Clientes</h4>
            </div>
            <form class=" mt-4" action="index.php?action=consultaClienteCedulaEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaClienteCedulaEmp">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Numero de Cedula" name="documCliente" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>

            <form class=" mt-2" action="index.php?action=consultaClienteNombreEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaClienteNombreEmp">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre Cliente" name="nomCliente" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
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
                <?php if (isset($data['clientes']) && count($data['clientes']) > 0): ?>
                    <h4 class="text-white">Resultados de la Consulta:</h4>
            </div>
            <!-- Tabla responsiva-->
            <div class="table-responsive">
                <table class="table table-hover text-white text-center">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Numero Documento</th>
                            <th>Tipo Documento</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Contacto</th>
                            <th>Correo</th>
                            <th>Puntos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['clientes'] as $cliente): ?>
                            <tr>
                                <!-- <td class="text-white align-middle"><?= $cliente['idCliente']; ?></td> -->
                                <td class="text-white align-middle"><?= $cliente['NumIdentificacion']; ?></td>
                                <td class="text-white align-middle"><?= $cliente['tipoDocum']; ?></td>
                                <td class="text-white align-middle"><?= $cliente['Nombres']; ?></td>
                                <td class="text-white align-middle"><?= $cliente['Apellidos']; ?></td>
                                <td class="text-white align-middle"><?= $cliente['NumCelular']; ?></td>
                                <td class="text-white align-middle"><?= $cliente['Email']; ?></td>
                                <td class="text-white align-middle"><?= $cliente['Puntos']; ?></td>
                                <td>
                                    <a href="index.php?action=actualizarClienteIdEmp&idCliente=<?= $cliente['idCliente']; ?>" class="btn btn-outline-secondary text-white m-2 w-100" role="button">Actualizar</a>
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
                    $action = $tipo === 'codigo' ? 'consultaClienteCedulaEmp' : 'consultaClienteNombreEmp';
                    $param = $tipo === 'codigo' ? "documCliente=$filtro" : "nomCliente=$filtro";

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
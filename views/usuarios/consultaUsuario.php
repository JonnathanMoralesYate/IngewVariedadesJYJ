<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Consultar Usuario-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Consulta de Empleado</h4>
            </div>
            <form class=" mt-4" action="index.php?action=consultaUsuarioDocumento" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaUsuarioDocumento">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Identificacion Usuario" name="numIdentUsuario" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary text-white" type="submit" id="button-addon2">Buscar</button>
                </div>
            </form>

            <form class=" mt-2" action="index.php?action=consultaUsuarioNombre" method="get">
                <input type="hidden" class="form-control" name="action" value="consultaUsuarioNombre">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre de Usuario" name="nombre" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
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
                <?php if (isset($data['usuarios']) && count($data['usuarios']) > 0): ?>
                    <h4 class="text-white">Resultados de la Busqueda:</h4>
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
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Usuario</th>
                            <!-- <th>Contraseña</th> -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['usuarios'] as $usuario): ?>
                            <tr>
                                <!-- <td class="text-white align-middle"><?= $usuario['idUsuario']; ?></td> -->
                                <td class="text-white align-middle"><?= $usuario['NumIdentificacion']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['tipoDocum']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['Nombres']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['Apellidos']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['NumCelular']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['Email']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['Rol']; ?></td>
                                <td class="text-white align-middle"><?= $usuario['Usuario']; ?></td>
                                <!-- <td class="text-white align-middle"><?= $usuario['Contraseña']; ?></td> -->
                                <td class="text-white align-middle">
                                    <a href="index.php?action=actualizarUsuarioId&idUsuario=<?= $usuario['idUsuario']; ?>" class="btn btn-outline-secondary text-white m-2 w-100" role="button">Actualizar</a>
                                    <a href="index.php?action=eliminarUsuarioId&idUsuario=<?= $usuario['idUsuario']; ?>" class="btn btn-outline-secondary text-white m-2 w-100" role="button">Eliminar</a>
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
                    $action = $tipo === 'codigo' ? 'consultaUsuarioDocumento' : 'consultaUsuarioNombre';
                    $param = $tipo === 'codigo' ? "numIdentUsuario=$filtro" : "nombre=$filtro";

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
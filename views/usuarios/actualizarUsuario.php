<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Actualizar Usuario-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                <h4>Actualizar Empleado</h4>
            </div>
            <form class=" mt-2" action="index.php?action=actualizarUsuario" method="post">
                <?php foreach ($usuarios as $usuario): ?>
                    <div class="">
                        <input type="hidden" class="form-control" name="idUsuario" value="<?= $usuario['idUsuario']; ?>" required>
                    </div>
                    <div class=" mt-2">
                        <label for="tipoDocum" class="form-label text-white mt-3">Tipo Documento:</label>
                        <?php $tipoDoc = $usuario['idTipoDocum']; ?>
                        <select id="tipoDocum" name="tipoDocum" class="form-control" required>
                            <option value="">Seleccione Tipo Documento</option>
                            <?php foreach ($tipoDocum as $tipos): ?>
                                <option value="<?= $tipos['idTipoDocum']; ?>" <?= $tipos['idTipoDocum'] == $tipoDoc ? 'selected' : '' ?>>
                                    <?= $tipos['tipoDocum']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class=" mt-2">
                        <label for="documUsu" class="form-label text-white mt-3">Numero de Cedula:</label>
                        <input type="text" class="form-control" name="documUsu" value="<?= $usuario['NumIdentificacion']; ?>" required>
                    </div>
                    <div class="mt-2">
                        <label for="nomUsu" class="form-label text-white mt-3">Nombres:</label>
                        <input type="text" class="form-control" name="nomUsu" value="<?= $usuario['Nombres']; ?>" required>
                    </div>
                    <div class="mt-2">
                        <label for="apellUsu" class="form-label text-white mt-3">Apellidos:</label>
                        <input type="text" class="form-control" name="apellUsu" value="<?= $usuario['Apellidos']; ?>" required>
                    </div>
                    <div class=" mt-2">
                        <label for="numCel" class="form-label text-white mt-3">Numero Celular:</label>
                        <input type="text" class="form-control" name="numCel" value="<?= $usuario['NumCelular']; ?>" pattern="3[0-9]{9}" maxlength="10" title="Ingresa un número de celular válido (10 dígitos, inicia en 3)" required>
                    </div>
                    <div class="mt-2">
                        <label for="correoUsu" class="form-label text-white mt-3">Email:</label>
                        <input type="email" class="form-control" id="correo" name="correoUsu" value="<?= $usuario['Email']; ?>" required>
                        <small id="correoError" class="text-danger" style="display:none;">Correo no válido</small>
                    </div>
                    <div class="mb-3">
                        <label for="seleccionRol" class="form-label text-white mt-3">Rol:</label>
                        <?php $tipoRol = $usuario['idRol']; ?>
                        <select id="seleccionRol" name="seleccionRol" class="form-control" required>
                            <option value="">Seleccione el Rol</option>
                            <?php foreach ($tipoRoles as $tipoRole): ?>
                                <option value="<?= $tipoRole['idRol']; ?>" <?= $tipoRole['idRol'] == $tipoRol ? 'selected' : '' ?>>
                                    <?= $tipoRole['Rol']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class=" mt-2">
                        <label for="usuario" class="form-label text-white mt-3">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" value="<?= $usuario['Usuario']; ?>" required>
                    </div>
                    <div class="mt-2">
                        <label for="contraseña" class="form-label text-white mt-3">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="contraseña" id="contrasena">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash icon-white"></i> </button>
                        </div>
                        <small id="passwordError" class="text-danger" style="display:none;">La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.</small>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-outline-secondary text-white">Actualizar</button>
                    </div>
                <?php endforeach; ?>
            </form>
        </div>
    </div>
</div>
</div>
</main>

<script src="./js/verificacionContraseña.js"></script>
<script src="./js/validarCorreo.js?v=1.0"></script>
<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Registro de Cliente-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                <h4>Registro Cliente</h4>
            </div>
            <form class=" mt-2" action="index.php?action=registroClienteEmp" method="post">
                <div class=" mt-2">
                    <label for="tipoDocum" class="form-label text-white mt-3">Tipo Documento:</label>
                    <select id="tipoDocum" name="tipoDocum" class="form-control" required>
                        <option value="">Seleccione Tipo Documento</option>
                        <?php foreach ($tipoDocum as $tipos): ?>
                            <option value="<?= $tipos['idTipoDocum']; ?>">
                                <?= $tipos['tipoDocum']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class=" mt-2">
                    <label for="documCliente" class="form-label text-white mt-3">Numero Cedula:</label>
                    <input type="text" class="form-control" id="documCliente" name="documCliente" placeholder="" required>
                </div>
                <div class="mt-2">
                    <label for="nomCliente" class="form-label text-white mt-3">Nombres:</label>
                    <input type="text" class="form-control" name="nomCliente" placeholder="" required>
                </div>
                <div class="mt-2">
                    <label for="apellCliente" class="form-label text-white mt-3">Apellidos:</label>
                    <input type="text" class="form-control" name="apellCliente" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="numCel" class="form-label text-white mt-3">No. Celular:</label>
                    <input type="text" class="form-control" name="numCel" pattern="3[0-9]{9}" maxlength="10" title="Ingresa un número de celular válido (10 dígitos, inicia en 3)" required>
                </div>
                <div class="mt-2">
                    <label for="correoCliente" class="form-label text-white mt-3">Email:</label>
                    <input type="email" class="form-control" id="correo" name="correoCliente" placeholder="" required>
                    <small id="correoError" class="text-danger" style="display:none;">Correo no válido</small>
                </div>
                <div class="mt-2">
                    <label for="puntos" class="form-label text-white mt-3">Puntos Acumulados:</label>
                    <input type="number" class="form-control" name="puntos" placeholder="" value="0" required readonly>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>

    <script src="./js/verificarCliente.js?v=1.0"></script>
    <script src="./js/validarCorreo.js?v=1.0"></script>
<?php include('./views/layautModEmple/footerModEmplea.php');  ?>
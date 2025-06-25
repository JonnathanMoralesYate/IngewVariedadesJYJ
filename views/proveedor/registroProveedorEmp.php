<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Registro de Proveedor-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                <h4>Registro Proveedor</h4>
            </div>
            <form class=" mt-2" action="index.php?action=registroProveedorEmp" method="post">
                <div class=" mt-2">
                    <label for="nitProveedor" class="form-label text-white mt-3">Codigo Empresa:</label>
                    <input type="text" class="form-control" id="nitProveedor" name="nitProveedor" placeholder="Nit" required>
                </div>
                <div class="mt-2">
                    <label for="nomProveedor" class="form-label text-white mt-3">Nombre Empresa:</label>
                    <input type="text" class="form-control" name="nomProveedor" placeholder="" required>
                </div>
                <div class="mt-2">
                    <label for="correoProv" class="form-label text-white mt-3">Email Empresa:</label>
                    <input type="email" class="form-control" id="correo" name="correoProv" placeholder="" required>
                    <small id="correoError" class="text-danger" style="display:none;">Correo no válido</small>
                </div>
                <div class=" mt-2">
                    <label for="celProveedor" class="form-label text-white mt-3">No. Celular Empresa:</label>
                    <input type="text" class="form-control" name="celProveedor" pattern="3[0-9]{9}" maxlength="10" title="Ingresa un número de celular válido (10 dígitos, inicia en 3)" required>
                </div>
                <div class="mt-2">
                    <label for="nomVendedor" class="form-label text-white mt-3">Nombre Vendedor:</label>
                    <input type="text" class="form-control" name="nomVendedor" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="celVendedor" class="form-label text-white mt-3">No. Celular Vendedor:</label>
                    <input type="text" class="form-control" name="celVendedor" pattern="3[0-9]{9}" maxlength="10" title="Ingresa un número de celular válido (10 dígitos, inicia en 3)" required>
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
        <script src="./js/verificarProveedor.js?v=1.0"></script>
        <script src="./js/validarCorreo.js?v=1.0"></script>
<?php include('./views/layautModEmple/footerModEmplea.php');  ?>
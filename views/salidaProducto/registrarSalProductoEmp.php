<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<!--Incio de Formulario Registro de Salida Producto-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                    <h4>Registro de Salida Producto</h4>
            </div>
            <form class=" mt-2" action="index.php?action=registroSalProductosEmp" method="post">
                <div class="mt-2">
                    <label for="codProducto" class="form-label text-white mt-3">Código Producto:</label>
                <div class="contenedor">
                    <input type="text" class="form-control" id="codProducto" name="codProducto" placeholder="Código de barras" required>
                    <p id="resultado"></p>
                </div>
                </div>
                <div class=" mt-2">
                    <label for="precioProducto" class="form-label text-white mt-3">Precio Producto:</label>
                    <input type="number" class="form-control" id="precioProducto" name="precioProducto" placeholder="" required readonly>
                </div>
                <div class="mt-2">
                    <label for="numIdentCliente" class="form-label text-white mt-3">Cliente:</label>
                <div class="contenedor">
                    <input type="text" class="form-control" id="numIdentCliente" name="numIdentCliente" placeholder="Numero de Cedula" required>
                    <p id="resultado1"></p>
                </div>
                </div>
                <div class="mt-2">
                    <label for="fechaSal" class="form-label text-white mt-3">Fecha Salida:</label>
                    <input type="datetime-local" class="form-control" id="fechaSal" name="fechaSal" placeholder="" required>
                </div>
                <div class="mt-2">
                    <label for="cantSal" class="form-label text-white mt-3">Cantidad de Salida:</label>
                    <input type="number" class="form-control" id="cantSal" name="cantSal" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="precioVenta" class="form-label text-white mt-3">Precio Venta:</label>
                    <input type="text" class="form-control" id="precioVenta" name="precioVenta" placeholder="" required readonly>
                </div>
                <div class=" mt-2">
                <label for="tipoPago" class="form-label text-white mt-3">Modo de Pago:</label>
                        <select id="tipoPago" name="tipoPago" class="form-control" required>
                            <?php foreach($formaPagos as $formaPago): ?>
                            <option value="<?= $formaPago['idModoPago']; ?>">
                            <?= $formaPago['ModoPago']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white">Registrar Salida</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>

        <script src="./js/agregarPrecioProducto.js"></script>
<?php include('./views/layautModEmple/footerModEmplea.php');  ?>
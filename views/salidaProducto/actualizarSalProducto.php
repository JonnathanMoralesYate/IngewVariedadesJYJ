<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Registro de Salida Producto-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                    <h4>Actualizar Salida Producto</h4>
                </div>
                <form class=" mt-2" action="index.php?action=actualizarSalProductos" method="post">
                <?php foreach ($salProductos as $salProducto): ?>
                    <div class=" mt-2">
                    <input type="hidden" class="form-control" name="idSalProducto" value="<?= $salProducto['idSalProducto']; ?>" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="codProducto" class="form-label text-white mt-3">Codigo Producto:</label>
                    <input type="text" class="form-control" id="codProducto" name="codProducto" value="<?= $salProducto['CodProducto']; ?>" placeholder="Codigo de barras" required>
                </div>
                <div class=" mt-2">
                    <label for="precioProducto" class="form-label text-white mt-3">Precio Producto:</label>
                    <input type="number" class="form-control" id="precioProducto" name="precioProducto" placeholder="" required readonly>
                </div>
                <div class="mt-2">
                    <label for="numIdentCliente" class="form-label text-white mt-3">Cliente:</label>
                    <input type="text" class="form-control" name="numIdentCliente" value="<?= $salProducto['NumIdentificacion']; ?>" placeholder="Numero de Cedula" required>
                </div>
                <div class="mt-2">
                    <label for="fechaSal" class="form-label text-white mt-3">Fecha Salida:</label>
                    <input type="datetime-local" class="form-control" name="fechaSal" value="<?= $salProducto['FechaSalida']; ?>" placeholder="" required>
                </div>
                <div class="mt-2">
                    <label for="cantSal" class="form-label text-white mt-3">Cantidad de Salida:</label>
                    <input type="number" class="form-control" name="cantSal" value="<?= $salProducto['CantSalida']; ?>" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="precioVenta" class="form-label text-white mt-3">Precio Venta:</label>
                    <input type="text" class="form-control" id="precioVenta" name="precioVenta" value="<?= $salProducto['PrecioVenta']; ?>" placeholder="" required readonly>
                </div>
                <div class=" mt-2">
                <label for="tipoPago" class="form-label text-white mt-3">Modo de Pago:</label>
                <?php $formaDePago= $salProducto['ModoPago']; ?>
                        <select id="tipoPago" name="tipoPago" class="form-control" required>
                            <option value="">Seleccione la Forma de Pago</option>
                            <?php foreach($formaPagos as $formaPago): ?>
                            <option value="<?= $formaPago['idModoPago']; ?>" <?= $formaPago['ModoPago'] == $formaDePago ? 'selected' : '' ?>>
                            <?= $formaPago['ModoPago']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white">Actualizar Salida</button>
                </div>
                <?php endforeach; ?>
            </form>
        </div>
    </div>
</div>
</div>
</main>

        <script src="./js/agregaPrecioProductoAct.js?v=1.0"></script>
<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Actualizar Entrada Producto-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                    <h4>Actualizar Entrada de Productos</h4>
                </div>
                <form class=" mt-2" action="index.php?action=actualizarEntProductos" method="post">
                <?php foreach ($entProductos as $entProducto): ?>
                <div class=" mt-2">
                    <input type="hidden" class="form-control" name="idEntProducto" value="<?= $entProducto['idEntProducto']; ?>" placeholder="Codigo de barras" required>
                </div>
                <div class=" mt-2">
                    <label for="idProducto" class="form-label text-white mt-3">Codigo Producto:</label>
                    <input type="text" class="form-control" name="codProducto" value="<?= $entProducto['CodProducto']; ?>" placeholder="Codigo de barras" required>
                </div>
                <div class="mt-2">
                    <label for="idProveedor" class="form-label text-white mt-3">Codigo Proveedor:</label>
                    <input type="text" class="form-control" name="nitProveedor" value="<?= $entProducto['NitProveedor']; ?>" placeholder="Nit" required>
                </div>
                <div class="mt-2">
                    <label for="fechaEnt" class="form-label text-white mt-3">Fecha de Entrada:</label>
                    <input type="datetime-local" class="form-control" name="fechaEnt" value="<?= $entProducto['FechaEnt']; ?>" placeholder="" required>
                </div>
                <div class="mt-2">
                    <label for="fechaVencim" class="form-label text-white mt-3">Fecha de Vencimiento:</label>
                    <input type="date" class="form-control" name="fechaVencim" value="<?= $entProducto['FechaVencimiento']; ?>" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="precioCompra" class="form-label text-white mt-3">Precio de Compra:</label>
                    <input type="number" class="form-control" name="precioCompra" value="<?= $entProducto['PrecioCompra']; ?>" placeholder="" required>
                </div>
                <div class=" mt-2">
                    <label for="cantidadEnt" class="form-label text-white mt-3">Cantidad:</label>
                    <input type="number" class="form-control" name="cantidadEnt" value="<?= $entProducto['CantEnt']; ?>" placeholder="" required>
                </div>             
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white">Actualizar Entrada</button>
                </div>
                <?php endforeach; ?>
            </form>
        </div>
    </div>
</div>
</div>
</main>


<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
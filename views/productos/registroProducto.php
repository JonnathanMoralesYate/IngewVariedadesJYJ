<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>
<!--Incio de formulario de registro de productos-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                <h4>Registro de Producto</h4>
            </div>
            <form class="mt-2" action="index.php?action=registroProductos" method="post" enctype="multipart/form-data">
                <div class="mt-2">
                    <label for="codProduc" class="form-label text-white mt-3">Código Producto:</label>
                    <input type="text" class="form-control" id="codProduc" name="codProduc" placeholder="Código de barras" required>
                </div>
                <div class="mt-3 text-center">
                    <label class="form-check-label text-white" for="codigoGenerado">Generar Código</label>
                    <input class="form-check-input ms-2" type="checkbox" name="codigoGenerado" value="true" id="codigoGenerado">
                </div>
                <div class="mt-2">
                    <label for="tiposClase" class="form-label text-white mt-3">Clase:</label>
                    <select id="tiposClase" name="tiposClase" class="form-select" required>
                        <option value="">Seleccione Clase del Producto</option>
                        <?php foreach($clases as $clase): ?>
                            <option value="<?= $clase['idClase']; ?>">
                                <?= $clase['Clase']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="nombreProduc" class="form-label text-white mt-3">Nombre:</label>
                    <input type="text" class="form-control" name="nombreproduc" required>
                </div>
                <div class="mt-2">
                    <label for="marcaProduc" class="form-label text-white mt-3">Marca:</label>
                    <input type="text" class="form-control" name="marcaProduc" required>
                </div>
                <div class="mt-2">
                    <label for="descriProduc" class="form-label text-white mt-3">Descripción:</label>
                    <input type="text" class="form-control" name="descriProduc" required>
                </div>
                <div class="mt-2">
                    <label for="tiposPresenta" class="form-label text-white mt-3">Presentación:</label>
                    <select id="tiposPresenta" name="tiposPresenta" class="form-select" required>
                        <option value="">Seleccione presentación del Producto</option>
                        <?php foreach($presentaciones as $presentacion): ?>
                            <option value="<?= $presentacion['idPresentacion']; ?>">
                                <?= $presentacion['Presentacion']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="tiposUnd" class="form-label text-white mt-3">Unidad Base:</label>
                    <select id="tiposUnd" name="tiposUnd" class="form-select" required>
                        <option value="">Seleccione Unidad Base</option>
                        <?php foreach($undBases as $undBase): ?>
                            <option value="<?= $undBase['idUndBase']; ?>">
                                <?= $undBase['UndBase']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="contNeto" class="form-label text-white mt-3">Contenido Neto:</label>
                    <input type="number" class="form-control" name="contNeto" required>
                </div>
                <div class="mt-2">
                    <label for="formatoVent" class="form-label text-white mt-3">Formato Venta:</label>
                    <select id="formatoVent" name="formatovent" class="form-select" required>
                        <option value="">Seleccione Formato Venta</option>
                        <?php foreach($formatoVents as $formatoVent): ?>
                            <option value="<?= $formatoVent['idFormatoVenta']; ?>">
                                <?= $formatoVent['FormatoVenta']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="precioVenta" class="form-label text-white mt-3">Precio de Venta:</label>
                    <input type="number" class="form-control" name="precioVenta" required>
                </div>
                <div class="mt-2">
                    <label for="fotoProduc" class="form-label text-white mt-3">Foto:</label>
                    <input type="file" class="form-control" name="fotoProduc">
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white">Registrar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>

    <script src="./js/verificarCodProducto.js?v=1.0"></script>
    <script src="./js/generarCodigoProducto.js?v=1.0"></script>
<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>




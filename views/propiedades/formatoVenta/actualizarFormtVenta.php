<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Registro de Clase-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                    <h4>Actualizar Formato Venta</h4>
                </div>
            <form class=" mt-2" action="index.php?action=actualizarFormatoVenta" method="post">
                <?php foreach($formatoVentas as $formatoVenta): ?>
                <div class=" mt-2">
                    <input type="hidden" class="form-control" name="idFormatoVenta" value="<?= $formatoVenta['idFormatoVenta']; ?>" required>
                </div>
                <div class=" mt-2">
                    <label for="nomFormatoVenta" class="form-label text-white mt-3">Formato de Venta:</label>
                    <input type="text" class="form-control" name="nomFormatoVenta" value="<?= $formatoVenta['FormatoVenta']; ?>" required>
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

<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
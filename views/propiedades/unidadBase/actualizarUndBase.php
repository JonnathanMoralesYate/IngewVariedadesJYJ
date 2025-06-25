<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Registro de Clase-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                    <h4>Registro Unidad Base</h4>
                </div>
            <form class=" mt-2" action="index.php?action=actualizarUndBase" method="post">
            <?php foreach($undBases as $undBase): ?>
            <div class=" mt-2">
                    <input type="hidden" class="form-control" name="idUndBase" value="<?= $undBase['idUndBase']; ?>" required>
                </div>
                <div class=" mt-2">
                    <label for="nomUndBase" class="form-label text-white mt-3">Unidad Base:</label>
                    <input type="text" class="form-control" name="nomUndBase" value="<?= $undBase['UndBase']; ?>" required>
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
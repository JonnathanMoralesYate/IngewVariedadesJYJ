<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de Formulario Registro de Clase-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-3">
                <h4>Registro Formato Venta</h4>
            </div>
            <form class=" mt-2" action="index.php?action=registroFormatoVenta" method="post">
                <div class=" mt-2">
                    <label for="nomFormatoVenta" class="form-label text-white mt-3">Formato de Venta:</label>
                    <input type="text" class="form-control" name="nomFormatoVenta" required>
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

<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
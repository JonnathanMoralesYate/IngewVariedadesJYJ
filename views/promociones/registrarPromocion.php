<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<!--Incio de formulario de registro de productos-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="text-center text-white mt-4">
                <h4>Registro de Promocion</h4>
            </div>
            <form class="mt-2" action="index.php?action=registroPromocion" method="post">
                <div class="mt-2">
                    <label for="codProduc" class="form-label text-white mt-3">Código Producto:</label>
                    <input type="text" class="form-control" id="codProduc" name="codProduc" placeholder="Código de barras" required>
                </div>
                <div class="mt-2">
                    <label for="descriPromo" class="form-label text-white mt-3">Descripción Promocion:</label>
                    <input type="text" class="form-control" name="descriPromo" required>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white">Registrar Promocion</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>

    <script src="./js/verificarCodProductoPromo.js?v=1.0"></script>
<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
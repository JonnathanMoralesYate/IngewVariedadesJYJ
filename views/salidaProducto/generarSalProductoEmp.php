<?php include('./views/layautModEmple/headerModEmplea.php');  ?>


<!--Incio de Formulario Consultar Entradas Producto-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="text-center text-white mt-3">
                <h4>Reporte de Salida de Productos</h4>
            </div>
            <form class=" mt-5" id="formReporte" action="index.php?action=reporteSalProductoFechaEmp" method="get">
                <input type="hidden" class="form-control" name="action" value="reporteSalProductoFechaEmp">
                <div class=" mt-2">
                    <label for="fechaInc" class="form-label text-white mt-3">Fecha Inicial:</label>
                    <input type="date" class="form-control" placeholder="Fecha Inicial" name="fechaInc" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                </div>
                <div class=" mt-2">
                    <label for="fechaFin" class="form-label text-white mt-3">Fecha Final:</label>
                    <input type="date" class="form-control" placeholder="Fecha final" name="fechaFin" aria-label="Recipient's usernam" aria-describedby="button-addon2" required>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-secondary text-white" id="button-addon2">Generar Reporte</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>

<script src="./js/verificacionFechaInicialyFin.js?v=1.0"></script>
<?php include('./views/layautModEmple/footerModEmplea.php');  ?>
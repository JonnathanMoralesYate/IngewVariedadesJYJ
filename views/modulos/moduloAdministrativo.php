<?php include('./views/layautModAdmin/headerModAdmin.php'); ?>

<div class="row">

    <!-- Contenedor para la alerta -->
    <div id="alerta" class="alerta"></div>

</div>

<div class="container-fluid mt-3">
    <div class="row mt-3">
        <div class="col-12 col-sm-5 mt-3">
            <div class="container-fluid text-center text-white">
                <h5 class="">Productos Con Mayor Entrada</h5>
            </div>
            <div class="mt-2">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
        <div class="col-2">
        </div>
        <div class="col-12 col-sm-5 mt-3">
            <div class="container-fluid text-center text-white">
                <h5 class="">Ventas Por Dia</h5>
            </div>
            <div class="mt-2">
                <canvas id="myChart1"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-sm-5 mt-3">
            <div class="container-fluid text-center text-white mt-3">
                <h5 class="">Productos Mas vendidos</h5>
            </div>
            <div class="mt-2">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="col-2">
        </div>
        <div class="col-12 col-sm-5 mt-3">
            <div class="container-fluid text-center text-white mt-3">
                <h5 class="">Productos Con Menor Stock</h5>
            </div>
            <div class="mt-2">
                <canvas id="myChart3"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</main>

<script src="./js/verificaProductosAvencer.js?v=1.0"></script>
<script src="./js/graficasModuloAdm.js?v=1.0"></script>
<?php include('./views/layautModAdmin/footerModAdmin.php'); ?>
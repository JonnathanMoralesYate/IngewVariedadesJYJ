<?php include('./views/layautModEmple/headerModEmplea.php');  ?>

<div class="row mt-5">
    <div class="col-12 col-sm-5 mt-1">
        <div class="container-fluid text-center text-white">
            <h5 class="">Productos Mas vendidos</h5>
        </div>
        <div class="mt-2">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-2">
    </div>
    <div class="col-12 col-sm-5 mt-1">
        <div class="container-fluid text-center text-white">
            <h5 class="">Productos Con Menor Stock</h5>
        </div>
        <div class="mt-2">
            <canvas id="myChart3"></canvas>
        </div>
    </div>
</div>
</div>
</main>

        <script src="./js/verificaProductosAvencer.js?v=1.0"></script>
        <script src="./js/graficaModuloEmp.js?v=1.0"></script>
<?php include('./views/layautModEmple/footerModEmplea.php');  ?>
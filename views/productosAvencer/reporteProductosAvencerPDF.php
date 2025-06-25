<?php

// Verifica si $_SESSION está vacío (no tiene ninguna variable)
if (empty($_SESSION)) {
    header("Location: index.php?action=Principal");
    exit;
}

ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="/img/logoPesta.ico" type="image/x-icon">
    <title>Reporte Productos Proximos a Vencer PDF JYK</title>

    <style>
/* Configurar el tamaño de la página para PDF */
@page {
    size: A4 landscape;
    margin: 20px;
}

/* Estilos generales */
body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    margin: 0;
    padding: 20px;
    background: white;
}

/* Tabla optimizada para PDF */
.table-container {
    width: 100%;
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;  /* Reducimos el tamaño de la fuente */
}

thead {
    background-color: #004080;
    color: white;
    font-weight: bold;
}

th, td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
    word-wrap: break-word;
}

/* Alternar colores de filas */
tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Pie de página */
footer {
    text-align: center;
    font-size: 10px;
    padding: 5px;
    margin-top: 10px;
    /*border-top: 2px solid #004080;*/
}

.no-data {
    text-align: center;
    font-size: 16px;
    color: red;
    margin-top: 10px;
}

.titulo {
    text-align: center;
    font-size: 18px;
    /*color: red;*/
    margin-top: 5px;
}

/* Estilos para la imagen */
.logo {
    width: 80px; /* Tamaño más controlado */
    height: auto;
}

.img {
    border-radius: 5px;
}

/* Encabezado estructurado con tabla */
.header {
    width: 100%;
    background-color: #004080;
    color: white;
    padding: 10px;
    border-radius: 5px;
}

/* Tabla para organizar logo e información */
.header-table {
    width: 100%;
    border-collapse: collapse;
    border: none; /* Elimina cualquier borde */
}

.header-table td {
    padding: 5px;
    vertical-align: middle;
    border: none; /* Asegura que no haya bordes en las celdas */
}

/* Estilos para la información del encabezado */
.header-content {
    text-align: center;
    font-size: 14px;
}

.header-content h2 {
    margin: 0;
    font-size: 18px;
}

.header-content p {
    margin: 2px 0;
    font-size: 16px;
}

/* Contenedor principal */
.report-container {
    width: 100%;
    background-color: #f2f2f2;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
}

/* Estilos para la tabla dentro del contenedor */
.report-container-table {
    width: 100%;
    font-size: 14px; /* Ajusta el tamaño de la letra según necesidad */
    border-collapse: collapse;
    border: none; /* Elimina los bordes de la tabla */
}

/* Alinear el contenido de las celdas a la izquierda */
.report-container-table td {
    padding: 5px;
    vertical-align: middle;
    text-align: left; /* Alineación a la izquierda */
    border: none; /* Asegura que no haya bordes */
}

/* Aplica negrilla a las etiquetas <strong> */
strong {
    font-size: 15px; /* Negrita más grande */
    font-weight: bold;
}

/* Aplica color azul a las etiquetas <span> */
    .report-container-table span {
    font-size: 15px; /* Texto azul más grande */
    color: #004080;
    font-weight: bold;
}

.imagen {
    width: 80px;  /* Ajusta el ancho según lo necesites */
    height: 80px; /* Ajusta la altura según lo necesites */
    object-fit: cover; /* Mantiene la imagen centrada y recortada */
    border-radius: 10px; /* Ajusta el redondeo de las esquinas */
    /*border: 2px solid #ddd; /* Borde opcional */
    padding: 5px; /* Espaciado opcional */
    background-color: #fff; /* Fondo opcional */
}
</style>
</head>
<body>
<!-- Encabezado con Logo -->
<div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 100px;">
                    <img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/CRUDvariedadesJYK/photo/logoPrin1.1.jpeg" alt="Logo" class="logo">
                </td>
                <td class="header-content">
                    <h2>MINIMARKET VARIEDADES JYK S.A.S</h2>
                    <p>NIT: 110.370.428-1</p>
                    <p>Cra. 16 Sur # 96-48, Ibagué - Tolima</p>
                    <p>Cel: 320 338 4589</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Contenedor principal para los datos generales -->
    <div class="report-container">
        <table class="report-container-table">
            <tr>
                <td>
                    <div><p><strong>Generado por:</strong> <span><?= htmlspecialchars($_SESSION['nombre']); ?> <?= htmlspecialchars($_SESSION['apellido']); ?></span></p></div>
                <td class="report-container-content">
                <div><p><strong>Fecha de generación:</strong> <span><?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d H:i:s'); ?></span></p></div>
            </tr>
        </table>
    </div>

    <!--Titulo de reporte-->
    <div class="titulo">
        <h4><strong>Reporte de Productos Proximos a Vencer</strong></h4>
    </div>

    <!-- Tabla de Productos Proximos a Vencer-->
    <div class="table-container">
        <?php if (isset($productosAvencer) && count($productosAvencer) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Codigo Producto</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Descripcion</th>
                        <th>Presentacion</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Proveedor</th>
                        <th>Cantidad Actual</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody class="">
                    <?php foreach ($productosAvencer as $productosVence): ?>
                        <tr>
                            <td class="text-white align-middle"><?= $productosVence['CodProducto']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['Nombre']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['Marca']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['Descripcion']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['Contenido Neto']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['FechaVencimiento']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['NombreProveedor']; ?></td>
                            <td class="text-white align-middle"><?= $productosVence['CantActual']; ?></td>
                            <td><img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/CRUDvariedadesJYK/photo/<?=$productosVence['Foto'];?>" width="100" alt="foto"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-white">No se Encontro Productos Proximos a Vencer</p>
        <?php endif; ?>
    </div>

    <!-- Inicio de Pie de Página -->
    <footer class="text-center">
        <p>© 2024 - VariedadesJyk® / Minimarket Variedades S.A.S. NIT. 110.370.428-1</p>
    </footer>
    <!-- Fin de Pie de Página -->
</div>

</body>
</html>

<?php

$html=ob_get_clean();
//echo $html;

require('./library/dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
use Dompdf\Options;

// Crear una nueva instancia de Dompdf
$dompdf = new Dompdf();

// Configurar las opciones para permitir el uso de recursos remotos
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

// Cargar el HTML y renderizar el PDF
$dompdf->loadHtml($html);

//(Opcional) Establecer tamaño y orientación de la página
//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('letter', 'landscape');

// Renderizar el PDF
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream("ReperteProductosAvencer.pdf", array("Attachment" => false));

?>
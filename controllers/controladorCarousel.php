<?php

require_once('./models/modeloCarousel.php');
require_once('./models/modeloProducto.php');
require_once('./config/conexionBDJYK.php');

class ControladorCarousel
{
    private $db;
    private $modeloCarousel;
    private $modeloProducto;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloCarousel = new ModeloCarousel($this->db);
        $this->modeloProducto = new ModeloProducto($this->db);
    }

    //Registro de Promociones
    public function registroPromociones()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $codProducto = $_POST['codProduc'];
            $descrpcion = $_POST['descriPromo'];

            $ProductoId = $this->modeloProducto->consultaProducto($codProducto);
            $idProducto = $ProductoId['idProducto'];

            $this->modeloCarousel->registroCarousel($idProducto, $descrpcion);

            echo "
                <script>
                    alert('Registro Promocion Exitoso!');
                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroPromocion';
                </script>
                ";
            exit;
        }
    }


    //Consulta general muestra productos en promocion carousel
    public function consultarCarousel()
    {
        return $this->modeloCarousel->consultGenCarousel();
    }


    //Consulta general muestra productos en promocion vista
    public function listaCarouselVista($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $promociones = $this->modeloCarousel->ConsultaCarouselVista($inicio, $limite);
        $totalProductos = $this->modeloCarousel->obtenerTotalProductos();
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'promociones' => $promociones,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //Consulta filtrada por codigo y nombre del producto consulta promociones
    public function listaPromocionesFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $promociones = $this->modeloCarousel->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $totalProductos = $this->modeloCarousel->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'promociones' => $promociones,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //Consulta por id para actualizar promociones
    public function consultarPromocionId()
    {
        $idPromocion = $_GET['idPromocion'] ?? '';
        return $this->modeloCarousel->consultarPromocionId($idPromocion);
    }


    //Actualizar promociones
    public function actualizarPromocion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idPromocion = $_POST['idPromocion'];
            $codProducto = $_POST['codProduc'];
            $descrpcion = $_POST['descriPromo'];

            $ProductoId = $this->modeloProducto->consultaProducto($codProducto);
            $idProducto = $ProductoId['idProducto'];

            $this->modeloCarousel->actualizarPromocion($idProducto, $descrpcion, $idPromocion);

            echo "
                <script>
                    alert('Actualización Promocion Exitosa!');
                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaPromociones';
                </script>
                ";
            exit;
        }
    }


    //Eliminar promociones
    public function eliminarPromocion()
    {
        $idPromocion = $_GET['idPromocion'] ?? '';
        $this->modeloCarousel->eliminarPromocion($idPromocion);

        echo "
            <script>
                alert('Eliminación Promoción Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaPromociones';
            </script>
            ";
        exit;
    }
}

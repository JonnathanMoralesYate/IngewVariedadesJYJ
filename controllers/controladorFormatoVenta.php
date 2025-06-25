<?php

require_once('./models/modeloFormatoVenta.php');
require_once('./config/conexionBDJYK.php');

class ControladorFormatoVenta
{

    private $db;
    private $modeloFormatoVenta;

    public function __construct()
    {

        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloFormatoVenta = new ModeloFormatoVenta($this->db);
    }


    //registro de Formato Venta
    public function RegistroFormatoVenta()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $nombreIn = $_POST['nomFormatoVenta'];
            $nombre = ucwords(strtolower(trim($nombreIn)));

            $this->modeloFormatoVenta->registrarFormatoVenta($nombre);

            echo "
                <script>
                    alert('Registro Exitoso!');
                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroFormatoVenta';
                </script>
                ";
            exit;
        }
    }


    //Lista de Formato Venta
    public function listaFormatoVenta()
    {
        return $this->modeloFormatoVenta->consultGenFormatoVenta();
    }

    //Lista de formato venta para la vista consulta
    public function listaFormatoVentas($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $formatoVenta = $this->modeloFormatoVenta->listaFormatoVenta($inicio, $limite);
        $totalFormatoVenta = $this->modeloFormatoVenta->obtenerTotalFormatoVenta();
        $totalPaginas = ceil($totalFormatoVenta / $limite);

        return
            [
                'formatoVenta' => $formatoVenta,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta de formato venta filtrado poor id y nombre
    public function listaFormatoVentaFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $formatoVenta = $this->modeloFormatoVenta->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloFormatoVenta->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'formatoVenta' => $formatoVenta,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //consulta de Formato Venta por ID
    public function ConsultFormatoVentaId()
    {
        $idFormatoVenta = $_GET['idFormatoVenta'] ?? '';
        return $this->modeloFormatoVenta->consultFormatoVentaId($idFormatoVenta);
    }


    //consulta de Formato Venta por nombre
    public function ConsultFormatoVentaNombre()
    {
        $nombre = $_GET['nomFormatoVenta'] ?? '';
        return $this->modeloFormatoVenta->consultFormatoVentaNombre($nombre);
    }


    //Actualizar Formato Venta
    public function ActualizarFormatoVenta()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $nombreIn = $_POST['nomFormatoVenta'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $idFormatoVenta = $_POST['idFormatoVenta'];

            $this->modeloFormatoVenta->actualizarFormatoVenta($nombre, $idFormatoVenta);

            echo "
                    <script>
                        alert('Actualizacion Exitosa!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaFormatoVenta';
                    </script>
                    ";
            exit;
        }
    }


    //Eliminar Formato Venta
    public function EliminarFormatoVenta()
    {
        $idFormatoVenta = $_GET['idFormatoVenta'] ?? '';
        $this->modeloFormatoVenta->eliminarPresentacion($idFormatoVenta);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaFormatoVenta';
            </script>
            ";
        exit;
    }
}

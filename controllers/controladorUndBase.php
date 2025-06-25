<?php

require_once('./models/modeloUndBase.php');
require_once('./config/conexionBDJYK.php');

class ControladorUndBase
{

    private $db;
    private $modeloUndBase;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloUndBase = new ModeloUndBase($this->db);
    }


    //registro de clase
    public function RegistroUndBase()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombreIn = $_POST['nomUndBase'];
            $nombre = ucwords(strtolower(trim($nombreIn)));

            $this->modeloUndBase->registrarUndBase($nombre);

                echo "
                    <script>
                        alert('Registro Exitoso!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroUndBase';
                    </script>
                    ";
                exit;
        }
    }


    //Lista unidad base select
    public function listaUndBase()
    {
        return $this->modeloUndBase->consultGenUndBase();
    }


    //Listado de unidad base vista consulta
    public function listaUndBases($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $undBases = $this->modeloUndBase->listaUndBase($inicio, $limite);
        $totalClases = $this->modeloUndBase->obtenerTotalUndBase();
        $totalPaginas = ceil($totalClases / $limite);

        return
            [
                'undBases' => $undBases,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta filtro unidad base por id y nombre consulta
    public function listaUndBaseFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $undBases = $this->modeloUndBase->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloUndBase->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'undBases' => $undBases,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //consulta de Unidad Base por ID
    public function consultUndBaseId()
    {
        $idUndBase = $_GET['idUndBase'] ?? '';
        return $this->modeloUndBase->consultUndBaseId($idUndBase);
    }


    //consulta de Unidad Base por nombre
    public function consultUndBaseNombre()
    {
        $nombre = $_GET['nomUndBase'] ?? '';
        return $this->modeloUndBase->consultUndBaseNombre($nombre);
    }


    //Actualizar Unidad Base
    public function ActualizarUndBase()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombreIn = $_POST['nomUndBase'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $idUndBase = $_POST['idUndBase'];

            $this->modeloUndBase->actualizarUndBase($nombre, $idUndBase);

                echo "
                    <script>
                        alert('Actualizacion Exitosa!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaUndBasen';
                    </script>
                    ";
                exit;
        }
    }


    //Eliminar Unidad Base
    public function EliminarUndBase()
    {
        $idUndBase = $_GET['idUndBase'] ?? '';
        $this->modeloUndBase->eliminarUndBase($idUndBase);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaUndBasen';
            </script>
            ";
        exit;
    }
}
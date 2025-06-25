<?php

require_once('./models/modeloPresentacion.php');
require_once('./config/conexionBDJYK.php');

class ControladorPresentacion
{

    private $db;
    private $modeloPresentacion;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloPresentacion = new ModeloPresentacion($this->db);
    }


    //registro de presentacion
    public function RegistroPresentacion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombreIn = $_POST['nomPresentacion'];
            $nombre = ucwords(strtolower(trim($nombreIn)));

            $this->modeloPresentacion->registrarPresentacion($nombre);

            echo "
                <script>
                    alert('Registro Exitoso!');
                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroPresentacion';
                </script>
                ";
            exit;
        }
    }


    //Lista de presentacion
    public function listaPresentacion()
    {
        return $this->modeloPresentacion->consultGenPresentacion();
    }


    //lista de presentacion producto vista consulta
    public function listaPresentaciones($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $presentaciones = $this->modeloPresentacion->listaPresentacion($inicio, $limite);
        $totalPresentaciones = $this->modeloPresentacion->obtenerTotalPresentacion();
        $totalPaginas = ceil($totalPresentaciones / $limite);

        return
            [
                'presentaciones' => $presentaciones,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //consulta de presentacion por nombre filtro
    public function listaPresentacionFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $presentaciones = $this->modeloPresentacion->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloPresentacion->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'presentaciones' => $presentaciones,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //consulta de presentacion por ID
    public function ConsultPresentacionId()
    {
        $idPresentacion = $_GET['idPresentacion'] ?? '';
        return $this->modeloPresentacion->consultPresentacionId($idPresentacion);
    }


    //consulta de presentacion por nombre
    public function ConsultPresentacionNombre()
    {
        $nombre = $_GET['nomPresentacion'] ?? '';
        return $this->modeloPresentacion->consultPresentacionNombre($nombre);
    }


    //Actualizar presentacion
    public function ActualizarPresentacion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombreIn = $_POST['nomPresentacion'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $idPresentacion = $_POST['idPresentacion'];

            $this->modeloPresentacion->actualizarPresentacion($nombre, $idPresentacion);

            echo "
                <script>
                    alert('Actualizacion Exitosa!');
                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaPresentacion';
                </script>
                ";
            exit;
        }
    }


    //Eliminar presentacion
    public function EliminarPresentacion()
    {
        $idPresentacion = $_GET['idPresentacion'] ?? '';
        $this->modeloPresentacion->eliminarPresentacion($idPresentacion);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaPresentacion';
            </script>
            ";
        exit;
    }
}

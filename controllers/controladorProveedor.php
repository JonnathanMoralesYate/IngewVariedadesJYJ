<?php

require_once('./models/modeloProveedor.php');
require_once('./config/conexionBDJYK.php');

class ControladorProveedor
{

    private $db;
    private $modeloProveedor;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloProveedor = new ModeloProveedor($this->db);
    }


    //Registro de producto
    public function RegistroProveedor()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nitProve = $_POST['nitProveedor'];
            $nomProveIn = $_POST['nomProveedor'];
            $nomProve = ucwords(strtolower(trim($nomProveIn)));
            $correoProve = strtolower($_POST['correoProv']);
            $celProve = $_POST['celProveedor'];
            $nomVendeIn = $_POST['nomVendedor'];
            $nomVende = ucwords(strtolower(trim($nomVendeIn)));
            $celVende = $_POST['celVendedor'];

            $this->modeloProveedor->registroProveedor($nitProve, $nomProve, $correoProve, $celProve, $nomVende, $celVende);

            if ($_SESSION['rol'] == 1) {
                echo "
                        <script>
                            alert('Registro del Proveedor Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProveedor';
                        </script>
                        ";
                exit;
            } elseif ($_SESSION['rol'] == 2) {
                echo "
                        <script>
                            alert('Registro del Proveedor Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProveedorEmp';
                        </script>
                        ";
                exit;
            }
        }
    }


    //lista de proveedores vista consulta 
    public function listaProveedores($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $proveedores = $this->modeloProveedor->consultGenProveedores($inicio, $limite);
        $totalProveedores = $this->modeloProveedor->obtenerTotalProveedores();
        $totalPaginas = ceil($totalProveedores / $limite);

        return
            [
                'proveedores' => $proveedores,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //consulta filtrada por nit, nombre proveedor y vendedor vista consulta
    public function listaProveedoresFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $proveedores = $this->modeloProveedor->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloProveedor->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'proveedores' => $proveedores,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta general de proveedor por id
    public function proveedorId()
    {
        $idProveedor = $_GET['idProveedor'] ?? '';
        return $this->modeloProveedor->consultGenProveedorId($idProveedor);
    }


    // Consulta para verificar Proveedor si esta registrado en BD
    public function nitProveedor()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['nitProveedor']) || empty($input['nitProveedor'])) {
                echo json_encode(['error' => 'El código del producto es requerido']);
                exit;
            }

            $ProveedorNit = $input['nitProveedor'];

            header("Content-Type: application/json; charset=UTF-8");

            $proveedor = $this->modeloProveedor->consultaProveedor($ProveedorNit);

            if ($proveedor) {
                echo json_encode(["success" => true, "proveedor" => $proveedor]);
            } else {
                echo json_encode(["success" => false, "error" => "Provedor No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }


    //Actualizar proveedor
    public function ActualizarProveedor()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nitProve = $_POST['nitProveedor'];
            $nomProveIn = $_POST['nomProveedor'];
            $nomProve = ucwords(strtolower(trim($nomProveIn)));
            $correoProve = strtolower($_POST['correoProv']);
            $celProve = $_POST['celProveedor'];
            $nomVendeIn = $_POST['nomVendedor'];
            $nomVende = ucwords(strtolower(trim($nomVendeIn)));
            $celVende = $_POST['celVendedor'];
            $idProveedor = $_POST['idProveedor'];

            $this->modeloProveedor->actualizarProveedor($nitProve, $nomProve, $correoProve, $celProve, $nomVende, $celVende, $idProveedor);

            if ($_SESSION['rol'] == 1) {
                echo "
                        <script>
                            alert('Actualizacion del Proveedor Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaProveedor';
                        </script>
                        ";
                exit;
            } elseif ($_SESSION['rol'] == 2) {
                echo "
                        <script>
                            alert('Actualizacion del Proveedor Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaProveedorEmp';
                        </script>
                        ";
                exit;
            }
        }
    }


    //Eliminar proveedor
    public function EliminarProveedor()
    {
        $idProveedor = $_GET['idProveedor'] ?? '';
        $this->modeloProveedor->eliminarProveedor($idProveedor);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaProveedor';
            </script>
            ";
        exit;
    }
}

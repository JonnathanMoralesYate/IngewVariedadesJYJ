<?php

require_once('./models/modeloCliente.php');
require_once('./config/conexionBDJYK.php');

class ControladorCliente
{

    private $db;
    private $modeloCliente;

    public function __construct()
    {

        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloCliente = new ModeloCliente($this->db);
    }


    //registro de Clientes
    public function registroCliente()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idTipoDocumC = $_POST['tipoDocum'];
            $numDocumentoC = $_POST['documCliente'];
            $nombreCIn = $_POST['nomCliente'];
            $nombreC = ucwords(strtolower(trim($nombreCIn)));
            $apellidoCIn = $_POST['apellCliente'];
            $apellidoC = ucwords(strtolower(trim($apellidoCIn)));
            $numCelularC = $_POST['numCel'];
            $correoC = strtolower($_POST['correoCliente']);
            $puntos = $_POST['puntos'];

            $this->modeloCliente->registroCliente($idTipoDocumC, $numDocumentoC, $nombreC, $apellidoC, $numCelularC, $correoC, $puntos);

            if ($_SESSION['rol'] == 1) {

                echo "
                    <script>
                        alert('Registro del Cliente Exitoso!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroCliente';
                    </script>
                    ";
                exit;
            } elseif ($_SESSION['rol'] == 2) {
                echo "
                    <script>
                        alert('Registro del Cliente Exitoso!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroClienteEmp';
                    </script>
                    ";
                exit;
            }
        }
    }


    //Consulta General Vista 
    public function listaClientesVista($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $clientes = $this->modeloCliente->consultGenClienteVista($inicio, $limite);
        $totalClientes = $this->modeloCliente->obtenerTotalClientes();
        $totalPaginas = ceil($totalClientes / $limite);

        return
            [
                'clientes' => $clientes,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Filtra Consulta por numero documento y nombre
    public function listaClientesFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $clientes = $this->modeloCliente->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloCliente->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'clientes' => $clientes,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta ID Cliente
    public function datosClienteId()
    {
        $idCliente = $_GET['idCliente'] ?? '';
        return $this->modeloCliente->consultGenClienteId($idCliente);
    }


    // Consulta para verificar si el Cliente esta registrado en BD
    public function verificacionCliente()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['numIdentCliente']) || empty($input['numIdentCliente'])) {
                echo json_encode(['error' => 'La Identificacion del cliente es requerido']);
                exit;
            }

            $numCliente = $input['numIdentCliente'];

            header("Content-Type: application/json; charset=UTF-8");

            $cliente = $this->modeloCliente->consultaCliente($numCliente);

            if ($cliente) {
                echo json_encode(["success" => true, "cliente" => $cliente]);
            } else {
                echo json_encode(["success" => false, "error" => "Cliente No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }


    //Metodo para actualizar los puntos del cliente del formulario de salida de productos pór varios productos
    public function PuntosActualizados()
    {
        header('Content-Type: application/json');

        header('Access-Control-Allow-Origin: *');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['idCliente']) || !isset($data['precio'])) {


            foreach ($data as $fila) {

                $idCliente = $fila['idCliente'];
                $precioVenta = $fila['precio'];

                $puntosAcumulados = ($precioVenta * 0.005);

                $this->modeloCliente->puntosActualizados($puntosAcumulados, $idCliente);
            }

            //respuesta exitosa
            echo json_encode(['success' => true, 'message' => 'Puntos actualizados del Cliente']);
        } else {

            //respuesta de error
            echo json_encode(['success' => false, 'error' => 'Datos No Recibidos']);
        }
    }


    //Actualizar de Clientes
    public function ActualizarCliente()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idTipoDocumC = $_POST['tipoDocum'];
            $numDocumentoC = $_POST['documCliente'];
            $nombreCIn = $_POST['nomCliente'];
            $nombreC = ucwords(strtolower(trim($nombreCIn)));
            $apellidoCIn = $_POST['apellCliente'];
            $apellidoC = ucwords(strtolower(trim($apellidoCIn)));
            $numCelularC = $_POST['numCel'];
            $correoC = strtolower($_POST['correoCliente']);
            $puntos = $_POST['puntos'];
            $idCliente = $_POST['idCliente'];

            $this->modeloCliente->ActualizarCliente($idTipoDocumC, $numDocumentoC, $nombreC, $apellidoC, $numCelularC, $correoC, $puntos, $idCliente);

            if ($_SESSION['rol'] == 1) {
                echo "
                    <script>
                        alert('Actualizacion del Cliente Exitoso!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaCliente';
                    </script>
                    ";
                exit;
            } elseif ($_SESSION['rol'] == 2) {
                echo "
                    <script>
                        alert('Actualizacion del Cliente Exitoso!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaClienteEmp';
                    </script>
                    ";
                exit;
            }
        }
    }


    //Eliminar Cliente
    public function EliminarCliente()
    {
        $idCliente = $_GET['idCliente'] ?? '';
        $this->modeloCliente->eliminarCliente($idCliente);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaCliente';
            </script>
            ";
        exit;
    }
}

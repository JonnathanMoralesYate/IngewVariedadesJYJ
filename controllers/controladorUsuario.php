<?php

require_once('./models/modeloUsuario.php');
require_once('./config/conexionBDJYK.php');

class ControladorUsuario
{

    private $db;
    private $modeloUsuario;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloUsuario = new ModeloUsuario($this->db);
    }


    //registro de usuarios
    public function registroUsua()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idTipoDocum = $_POST['tipoDocum'];
            $numDocumento = $_POST['documUsu'];
            $nombreIn = $_POST['nomUsu'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $apellidoIn = $_POST['apellUsu'];
            $apellido = ucwords(strtolower(trim($apellidoIn)));
            $numCelular = $_POST['numCel'];
            $correoE = strtolower($_POST['correoUsu']);
            $rol = $_POST['seleccionRol'];
            $usuario = strtolower($_POST['usuario']);
            $clave = trim($_POST['contraseña']);

            $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";

            if (!preg_match($patron, $clave)) {
                echo "<script>alert('La contraseña no cumple los requisitos de seguridad.'); window.history.back();</script>";
                exit;
            }

            $claveSegura = password_hash($clave, PASSWORD_BCRYPT);

            $this->modeloUsuario->registroUsuario($idTipoDocum, $numDocumento, $nombre, $apellido, $numCelular, $correoE, $rol, $usuario, $claveSegura);

            echo "
                    <script>
                        alert('Registro Exitoso!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroUsuario';
                    </script>
                    ";
            exit;
        }
    }


    //Consulta general de usuarios
    public function listaUsuarios()
    {
        return $this->modeloUsuario->consultGenUsua();
    }

    //Consulta por parametro id usuario en tabla general de usuarios
    public function datosUsuaGenPorId()
    {
        $idUsua = $_GET['idUsuario'] ?? '';
        return $this->modeloUsuario->consultUsuaId($idUsua);
    }


    //Lista de usuarios vista consulta
    public function listaUsuariosVista($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $usuarios = $this->modeloUsuario->consultGenUsuaVista($inicio, $limite);
        $totalUsuarios = $this->modeloUsuario->obtenerTotalUsuarios();
        $totalPaginas = ceil($totalUsuarios / $limite);

        return
            [
                'usuarios' => $usuarios,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta de usuario filtrada por numero decumento y nombre
    public function listaUsuariosFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $usuarios = $this->modeloUsuario->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloUsuario->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'usuarios' => $usuarios,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta por parametro id usuario
    public function datosUsuaPorId()
    {
        $numIdentUsuario = $_GET['numIdentUsuario'] ?? '';
        return $this->modeloUsuario->consultGenUsuaVistaId($numIdentUsuario);
    }


    //Consulta por parametro nombre
    public function datosUsuaPorNombre()
    {
        $nombre = $_GET['nombre'] ?? '';
        return $this->modeloUsuario->consultGenUsuaVistaNombre($nombre);
    }


    //Actualizar usuario
    public function actualizarUsuario()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idTipoDocum = $_POST['tipoDocum'];
            $numDocumento = $_POST['documUsu'];
            $nombreIn = $_POST['nomUsu'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $apellidoIn = $_POST['apellUsu'];
            $apellido = ucwords(strtolower(trim($apellidoIn)));
            $numCelular = $_POST['numCel'];
            $correoE = strtolower($_POST['correoUsu']);
            $rol = $_POST['seleccionRol'];
            $usuario = strtolower($_POST['usuario']);
            $idUsua = $_POST['idUsuario'];

            $clave = trim($_POST['contraseña']);

            if($clave === '') {
                $claveSegura = null; // No se actualiza la contraseña si no se proporciona una nueva
            } else {
                $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";

                if (!preg_match($patron, $clave)) {
                    echo "<script>alert('La contraseña no cumple los requisitos de seguridad.'); window.history.back();</script>";
                    exit;
                }
                
                $claveSegura = password_hash($clave, PASSWORD_BCRYPT);
            }

            $this->modeloUsuario->actualizarUsua($idTipoDocum, $numDocumento, $nombre, $apellido, $numCelular, $correoE, $rol, $usuario, $claveSegura, $idUsua);

            echo "
                    <script>
                        alert('Actualizacion Exitosa!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaUsuarios';
                    </script>
                ";
            exit;
        }
    }


    //Eliminar usuario
    public function eliminarUsuario()
    {
        $idUsua = $_GET['idUsuario'] ?? '';
        $this->modeloUsuario->eliminarUsua($idUsua);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaUsuarios';
            </script>
            ";
        exit;
    }


    // Consulta para traer informacion del producto por idclase
    public function ConsultaUsuario()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['documUsu']) || empty($input['documUsu'])) {
                echo json_encode(['error' => 'El idClase del producto es requerido']);
                exit;
            }

            $numDocumU = $input['documUsu'];

            header("Content-Type: application/json; charset=UTF-8");

            $usuario = $this->modeloUsuario->consultaUsuario($numDocumU);

            if ($usuario) {
                echo json_encode(["success" => true, "usuario" => $usuario]);
            } else {
                echo json_encode(["success" => false, "error" => "Usuario No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }
}

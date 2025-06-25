<?php

require_once('./models/modeloLogin.php');
require_once('./config/conexionBDJYK.php');

class ControladorLogin
{

    private $db;
    private $modeloLogin;

    public function __construct()
    {

        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloLogin = new ModeloLogin($this->db);
    }

    public function validarUsuario()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = strtolower($_POST['usuarioL']);
            $clave = $_POST['contraseñaL'];

            // Consultar el usuario en la base de datos
            $user = $this->modeloLogin->consultaUsuario($usuario);

            if ($user) {

                $idUsua = $user['idUsuario'];
                $rol = $user['idRol'];
                $contraseñaBD = $user['Contraseña'];     // Contraseña encriptada almacenada
                $nombre = $user['Nombres'];
                $apellido = $user['Apellidos'];

                // Verifica la contraseña
                if (password_verify($clave, $contraseñaBD)) {

                    // Inicia la sesión.
                    session_start();

                    // Guarda el datos de usuario
                    $_SESSION['idUsua'] = $idUsua;
                    $_SESSION['rol'] = $rol;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellido'] = $apellido;

                    //Administrativo
                    if ($_SESSION['rol'] == 1) {

                        header("Location: index.php?action=vistaAdmin");
                        exit;

                        //Empleado
                    } elseif ($_SESSION['rol'] == 2) {

                        header("Location: index.php?action=vistaEmple");
                        exit;
                    }
                } else {
                    // Contraseña incorrecta
                    echo "
                        <script>
                            alert('Contraseña incorrecta!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=Principal';
                        </script>
                    ";
                    exit;
                }
            } else {
                // Usuario no encontrado
                echo "
                    <script>
                        alert('Usuario no encontrado o Incorrecto!');
                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=Principal';
                    </script>
                ";
                exit;
            }
        }
    }


    public function cerrarSesion()
    {
        session_start();
        session_unset();
        session_destroy();

        // Borrar cookie manualmente
        setcookie("PHPSESSID", "", time() - 3600, "/");

        echo '
            <script>
                alert("Sesión cerrada con éxito");
                window.location.href = "index.php?action=Principal";
            </script>';
        exit;
    }
}

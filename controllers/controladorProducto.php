<?php

require_once('./models/modeloGenerarCodigo.php');
require_once('./models/modeloProducto.php');
require_once('./config/conexionBDJYK.php');

class ControladorProducto
{

    private $db;
    private $modeloProducto;
    private $modeloGenerarCodigo;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloProducto = new ModeloProducto($this->db);
        $this->modeloGenerarCodigo = new ModeloGenerarCodigo($this->db);
    }

    //Registro de producto
    public function registroProductos()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $codigoProducto = $_POST['codProduc'];
            $codigoGenerado = $_POST['codigoGenerado'];
            $idClase = $_POST['tiposClase'];
            $nombreIn = $_POST['nombreproduc'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $marcaIn = $_POST['marcaProduc'];
            $marca = ucwords(strtolower(trim($marcaIn)));
            $descripcion = $_POST['descriProduc'];
            $idPresentacion = $_POST['tiposPresenta'];
            $idUndBase = $_POST['tiposUnd'];
            $contNeto = $_POST['contNeto'];
            $idFormatoVent = $_POST['formatovent'];
            $precioVenta = $_POST['precioVenta'];

            $foto = $_FILES['fotoProduc']['name'];
            $target_dir = "photo/";
            $target_file = $target_dir . basename($foto);

            if (empty($foto)) {
                $foto = "imagen_default.png";
                $target_file = $target_dir . $foto;
            } else {
                move_uploaded_file($_FILES['fotoProduc']['tmp_name'], $target_file);
            }

            if ($codigoGenerado) {

                $this->modeloProducto->registroProducto($codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto);

                $this->modeloGenerarCodigo->actualizarCodigoGenerado($codigoProducto);

                if ($_SESSION['rol'] == 1) {
                    echo "
                        <script>
                            alert('Registro del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductos';
                        </script>
                        ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                        <script>
                            alert('Registro del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductosEmp';
                        </script>
                        ";
                    exit;
                } else {
                    header("Location: index.php?action=principal");
                }
            } else {

                $this->modeloProducto->registroProducto($codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto);

                if ($_SESSION['rol'] == 1) {
                    echo "
                        <script>
                            alert('Registro del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductos';
                        </script>
                        ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                        <script>
                            alert('Registro del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductosEmp';
                        </script>
                        ";
                    exit;
                }
            }
        }
    }


    //lista de productos para vista consulta
    public function listaProductosVista($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $productos = $this->modeloProducto->consultGenProductosvista($inicio, $limite);
        $totalProductos = $this->modeloProducto->obtenerTotalProductos();
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'productos' => $productos,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //consulta de productos por codigo de barras y nombre filtro
    public function listaProductosFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $productos = $this->modeloProducto->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloProducto->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return [
            'productos' => $productos,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo
        ];
    }


    //Consulta general de productos por clase vista
    public function darListaProductosPorClase($idClase)
    {
        return $this->modeloProducto->darProductosPorClase($idClase);
    }


    //Consulta general de productos por codigo de barras 
    public function productoCodigo()
    {
        $codigoProducto = $_GET['codProduc'] ?? '';
        return $this->modeloProducto->consultGenProductos($codigoProducto);
    }


    //Consulta general de productos vista
    public function listaClasesP()
    {
        return $this->modeloProducto->mostrarClasesP();
    }


    // Consulta para verificar si el producto esta registrado en BD
    public function productoCodProducto()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['codProducto']) || empty($input['codProducto'])) {
                echo json_encode(['error' => 'El código del producto es requerido']);
                exit;
            }

            $codProducto = $input['codProducto'];

            header("Content-Type: application/json; charset=UTF-8");

            $producto = $this->modeloProducto->consultaProducto($codProducto);

            if ($producto) {
                echo json_encode(["success" => true, "producto" => $producto]);
            } else {
                echo json_encode(["success" => false, "error" => "Producto No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }


    // Consulta para traer informacion del producto
    public function informacionProducto()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['idProducto']) || empty($input['idProducto'])) {
                echo json_encode(['error' => 'El código del producto es requerido']);
                exit;
            }

            $idProducto = $input['idProducto'];

            header("Content-Type: application/json; charset=UTF-8");

            $producto = $this->modeloProducto->consultaProductoCodigo($idProducto);

            if ($producto) {
                echo json_encode(["success" => true, "producto" => $producto]);
            } else {
                echo json_encode(["success" => false, "error" => "Producto No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }


    // Consulta para traer informacion del producto por idclase
    public function ProductosPorClase()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['idClase']) || empty($input['idClase'])) {
                echo json_encode(['error' => 'El idClase del producto es requerido']);
                exit;
            }

            $idClase = $input['idClase'];

            header("Content-Type: application/json; charset=UTF-8");

            $infoProducto = $this->modeloProducto->productosPorClase($idClase);

            if ($infoProducto) {
                echo json_encode(["success" => true, "inforProducto" => $infoProducto]);
            } else {
                echo json_encode(["success" => false, "error" => "Producto No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }


    //Consulta producto por nombre pagina principal
    public function ProductosPorNombre()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['Nombre']) || empty($input['Nombre'])) {
                echo json_encode(['error' => 'El nombre del producto es requerido']);
                exit;
            }

            $nombre = $input['Nombre'];

            header("Content-Type: application/json; charset=UTF-8");

            $infoProducto = $this->modeloProducto->productosPorNombre($nombre);

            if ($infoProducto) {
                echo json_encode(["success" => true, "inforProducto" => $infoProducto]);
            } else {
                echo json_encode(["success" => false, "error" => "Producto No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }


    //Actualizar producto
    public function actualizarProducto()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $codigoProducto = $_POST['codProduc'];
            $idClase = $_POST['tiposClase'];
            $nombreIn = $_POST['nombreproduc'];
            $nombre = ucwords(strtolower(trim($nombreIn)));
            $marcaIn = $_POST['marcaProduc'];
            $marca = ucwords(strtolower(trim($marcaIn)));
            $descripcion = $_POST['descriProduc'];
            $idPresentacion = $_POST['tiposPresenta'];
            $idUndBase = $_POST['tiposUnd'];
            $contNeto = $_POST['contNeto'];
            $idFormatoVent = $_POST['formatoVent'];
            $precioVenta = $_POST['precioVenta'];

            $foto = $_FILES['fotoProduc']['name'] ? $_FILES['fotoProduc']['name'] : null;

            if ($foto) {
                $target_dir = "photo/";
                $target_file = $target_dir . basename($foto);
                move_uploaded_file($_FILES['fotoProduc']['tmp_name'], $target_file);
            } else {
                $foto = $_POST['fotoProduc_actual'];
            }

            $idProducto = $_POST['idProducto'];

            $this->modeloProducto->actualizarProducto($codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto, $idProducto);

            if ($_SESSION['rol'] == 1) {
                echo "
                        <script>
                            alert('Actualizacion del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaProductos';
                        </script>
                        ";
                exit;
            } elseif ($_SESSION['rol'] == 2) {
                echo "
                        <script>
                            alert('Registro del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaProductosEmp';
                        </script>
                        ";
                exit;
            } else {
                header("Location: index.php?action=principal");
            }
        }
    }


    //Eliminar producto
    public function eliminarProducto()
    {
        $codigoProducto = $_GET['codProduc'] ?? '';
        $this->modeloProducto->eliminarProducto($codigoProducto);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaProductos';
            </script>
            ";
        exit;
    }
}

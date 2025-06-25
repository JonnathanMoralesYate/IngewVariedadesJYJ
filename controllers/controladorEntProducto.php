<?php

require_once('./models/modeloProducto.php');
require_once('./models/modeloProveedor.php');
require_once('./models/modeloEntProducto.php');
require_once('./models/modeloInventario.php');
require_once('./config/conexionBDJYK.php');

class ControladorEntProductos
{

    private $db;
    private $modeloEntProducto;
    private $modeloProducto;
    private $modeloProveedor;
    private $modeloInventario;

    public function __construct()
    {

        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloEntProducto = new ModeloEntProducto($this->db);
        $this->modeloProducto = new ModeloProducto($this->db);
        $this->modeloProveedor = new ModeloProveedor($this->db);
        $this->modeloInventario = new ModeloInventario($this->db);
    }


    //registro de Entrada Productos
    public function RegistroEntProducto()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $codProducto = $_POST['codProducto'];
            $nitProveedor = $_POST['nitProveedor'];

            $productoId = $this->modeloProducto->consultaProducto($codProducto);

            $proveedorId = $this->modeloProveedor->consultaProveedor($nitProveedor);


            $idProducto = $productoId['idProducto'];
            $idProveedor = $proveedorId['idProveedor'];
            $fechaEnt = $_POST['fechaEnt'];
            $fechaVencim = $_POST['fechaVencim'];
            $precioCompra = $_POST['precioCompra'];
            $cantidadEnt = $_POST['cantidadEnt'];

            if ($productoId == false) {

                if ($_SESSION['rol'] == 1) {
                    echo "
                        <script>
                            alert('Producto No Registardo, Realice el Registro!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductos';
                        </script>
                        ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                                <script>
                                    alert('Registro Entrada del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductosEmp';
                                </script>
                                ";
                    exit;
                }
            } elseif ($proveedorId == false) {

                if ($_SESSION['rol'] == 1) {
                    echo "
                        <script>
                            alert('Producto No Registardo, Realice el Registro!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProveedor';
                        </script>
                        ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                        <script>
                            alert('Registro Entrada del Producto Exitoso!');
                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProveedorEmp';
                        </script>
                        ";
                    exit;
                }
            } else {

                //metodo para cuando se registre una entrada de producto, en el inventario se anexe el producto o sume el stock
                $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

                if ($estadoInventario !== false) {
                    //el producto ya existe
                    $cantidadAct = $cantidadEnt + $estadoInventario['CantActual'];
                    $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);
                    //Registra la Entrada del Producto
                    $this->modeloEntProducto->registroEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEnt);

                    if ($_SESSION['rol'] == 1) {
                        echo "
                                <script>
                                    alert('Registro Entrada del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroEntProductos';
                                </script>
                                ";
                        exit;
                    } elseif ($_SESSION['rol'] == 2) {
                        echo "
                                <script>
                                    alert('Registro Entrada del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroEntProductosEmp';
                                </script>
                                ";
                        exit;
                    }
                } else {
                    //el Producto no existe
                    $this->modeloInventario->registroInventario($idProducto, $cantidadEnt);
                    //Registra la Entrada del Producto
                    $this->modeloEntProducto->registroEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEnt);

                    if ($_SESSION['rol'] == 1) {
                        echo "
                                <script>
                                    alert('Registro Entrada del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroEntProductos';
                                </script>
                                ";
                        exit;
                    } elseif ($_SESSION['rol'] == 2) {
                        echo "
                                <script>
                                    alert('Registro Entrada del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroEntProductosEmp';
                                </script>
                                ";
                        exit;
                    }
                }
            }
        }
    }

    //Lista de entradas de producto para la vista consulta 
    public function listaEntProductosVista($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $entProductos = $this->modeloEntProducto->consultaGenEntProductosVista($inicio, $limite);
        $totalEntProductos = $this->modeloEntProducto->obtenerTotalEntProductos();
        $totalPaginas = ceil($totalEntProductos / $limite);

        return
            [
                'entProductos' => $entProductos,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }

    //Lista de entradas de producto para la vista consulta filtrada
    public function listaEntProductosFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $entProductos = $this->modeloEntProducto->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloEntProducto->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'entProductos' => $entProductos,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta general por Id
    public function consultaGenEntProductosId()
    {
        $idEntProductos = $_GET['idEntProducto'] ?? '';
        return $this->modeloEntProducto->consultaGenEntProductos($idEntProductos);
    }


    //Actualizar de Entrada Productos
    public function ActualizarEntProducto()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $codProducto = $_POST['codProducto'];
            $nitProveedor = $_POST['nitProveedor'];

            $productoId = $this->modeloProducto->consultaProducto($codProducto);
            $proveedorId = $this->modeloProveedor->consultaProveedor($nitProveedor);

            $idProducto = $productoId['idProducto'];
            $idProveedor = $proveedorId['idProveedor'];
            $fechaEnt = $_POST['fechaEnt'];
            $fechaVencim = $_POST['fechaVencim'];
            $precioCompra = $_POST['precioCompra'];
            $cantidadEnt = $_POST['cantidadEnt'];
            $idEntProducto = $_POST['idEntProducto'];

            $cantEnt = $this->modeloEntProducto->consultaCantidadEntProductos($idEntProducto);

            $cantidadEntAnterior = $cantEnt['CantEnt'];

            if ($cantidadEntAnterior == $cantidadEnt) 
            {

                $cantidadEntAct = $cantidadEnt;

                $this->modeloEntProducto->actualizarEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEntAct, $idEntProducto);

                if ($_SESSION['rol'] == 1) {
                    echo "
                                    <script>
                                        alert('Actualizacion Entrada del Producto Exitoso!');
                                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductos';
                                    </script>
                                    ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                                    <script>
                                        alert('Actualizacion Entrada del Producto Exitoso!');
                                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductosEmp';
                                    </script>
                                    ";
                    exit;
                }
            } elseif ($cantidadEntAnterior > $cantidadEnt) {

                $cantidadEntAct = $cantidadEnt;

                $this->modeloEntProducto->actualizarEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEntAct, $idEntProducto);

                $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

                //Modifica la cantidad Entrada
                $cantidad = $cantidadEntAnterior - $cantidadEnt;

                $cantidadAct = $estadoInventario['CantActual'] - $cantidad;
                $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

                if ($_SESSION['rol'] == 1) {
                    echo "
                                    <script>
                                        alert('Actualizacion Entrada del Producto Exitoso!');
                                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductos';
                                    </script>
                                    ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                                        <script>
                                            alert('Actualizacion Entrada del Producto Exitoso!');
                                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductosEmp';
                                        </script>
                                        ";
                    exit;
                }
            } else {

                $cantidadEntAct = $cantidadEnt;

                $this->modeloEntProducto->actualizarEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEntAct, $idEntProducto);

                $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

                //Modifica la cantidad Entrada
                $cantidad = $cantidadEnt - $cantidadEntAnterior;

                $cantidadAct = $estadoInventario['CantActual'] + $cantidad;
                $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

                if ($_SESSION['rol'] == 1) {
                    echo "
                                    <script>
                                        alert('Actualizacion Entrada del Producto Exitoso!');
                                        window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductos';
                                    </script>
                                    ";
                    exit;
                } elseif ($_SESSION['rol'] == 2) {
                    echo "
                                        <script>
                                            alert('Actualizacion Entrada del Producto Exitoso!');
                                            window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductosEmp';
                                        </script>
                                        ";
                    exit;
                }
            }
        }
    }


    //Eliminar Entrada Producto
    public function EliminarEntProducto()
    {
        $idEntProducto = $_GET['idEntProducto'] ?? '';

        //Consulta antes de eliminar Cantidad entrada Producto
        $cantEnt = $this->modeloEntProducto->consultaCantidadEntProductos($idEntProducto);

        $idProducto = $cantEnt['idProducto'];
        $cantidad = $cantEnt['CantEnt'];

        $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

        //resta la cantidad Entrada en inventario
        $cantidadAct = $estadoInventario['CantActual'] - $cantidad;
        $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

        $this->modeloEntProducto->eliminarEntProductos($idEntProducto);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaEntProductos';
            </script>
            ";
        exit;
    }


    //Generar reporte PDF de entrada de productos
    public function ReporteEntProductos()
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';

        $reporteEntProductos = $this->modeloEntProducto->reporteEntProductos($fechaInc, $fechaFin);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteEntProductos' => $reporteEntProductos
        ];
    }

    //Genera lista de entrada de producto vita reporte 
    public function listaEntProductos($valor, $tipo)
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';

        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $reporteEntProductos = $this->modeloEntProducto->listaEntProductos($inicio, $limite, $fechaInc, $fechaFin);
        $total = $this->modeloEntProducto->totalEntProductosPorFechas($fechaInc, $fechaFin);
        $totalPaginas = ceil($total / $limite);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteEntProductos' => $reporteEntProductos,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }

    //Consulta de entradas de producto para la vista reporte filtrada por nombre
    public function listaEntProductosFiltradoNombre($tipo, $valor)
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';

        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $reporteEntProductos = $this->modeloEntProducto->consultarFiltradoEntProductos($tipo, $valor, $inicio, $limite, $fechaInc, $fechaFin);
        $total = $this->modeloEntProducto->totalFiltradoEntProductos($tipo, $valor, $fechaInc, $fechaFin);
        $totalPaginas = ceil($total / $limite);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteEntProductos' => $reporteEntProductos,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //Metodo para traer datos de productos con mayor entrada 
    public function ProductosMayorEntrada()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $mayorEntrada = $this->modeloEntProducto->productosMayorEntrada();

        if ($mayorEntrada) {
            echo json_encode(["success" => true, "mayorEntrada" => $mayorEntrada]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
        }
    }


    //Generar reporte de entrada de productos
    public function ReporteEntProductosEmp()
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';

        $reporteEntProductos = $this->modeloEntProducto->reporteEntProductos($fechaInc, $fechaFin);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteEntProductos' => $reporteEntProductos
        ];
    }


    //Metodo para traer datos de productos con mayor entrada 
    public function ProductosMayorEntradaEmp()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $mayorEntrada = $this->modeloEntProducto->productosMayorEntrada();

        if ($mayorEntrada) {
            echo json_encode(["success" => true, "mayorEntrada" => $mayorEntrada]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
        }
    }
}

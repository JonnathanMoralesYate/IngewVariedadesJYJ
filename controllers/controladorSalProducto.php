<?php

require_once('./models/modeloSalProducto.php');
require_once('./models/modeloCliente.php');
require_once('./models/modeloEntProducto.php');
require_once('./models/modeloInventario.php');
require_once('./config/conexionBDJYK.php');

class ControladorSalProducto
{

    private $db;
    private $modeloSalProducto;
    private $modeloProducto;
    private $modeloCliente;
    private $modeloInventario;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloSalProducto = new ModeloSalProducto($this->db);
        $this->modeloProducto = new ModeloProducto($this->db);
        $this->modeloCliente = new ModeloCliente($this->db);
        $this->modeloInventario = new ModeloInventario($this->db);
    }


    //registro de Salida Producto
    public function RegistroSalProducto()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $codProducto = $_POST['codProducto'];
            $numIdentcliente = $_POST['numIdentCliente'];

            $productoId = $this->modeloProducto->consultaProducto($codProducto);
            $clienteId = $this->modeloCliente->consultaCliente($numIdentcliente);

            $idProducto = $productoId['idProducto'];
            $idCliente = $clienteId['idCliente'];
            $fechaSal = $_POST['fechaSal'];
            $cantSal = $_POST['cantSal'];
            $precioVentaString = $_POST['precioVenta'];    
            $precioVentaSinPunto = str_replace('.', '', $precioVentaString);    
            $precioVenta = (int) $precioVentaSinPunto;  

            $idModoPago = $_POST['tipoPago'];

            if ($clienteId == false) {

                if ($_SESSION['rol'] == 1) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroCliente';
                            </script>
                            ";
                        exit;
                } elseif ($_SESSION['rol'] == 2) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroClienteEmp';
                            </script>
                            ";
                        exit;
                }
            } elseif ($productoId == false) {

                if ($_SESSION['rol'] == 1) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProducto';
                            </script>
                            ";
                        exit;
                } elseif ($_SESSION['rol'] == 2) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroProductoEmp';
                            </script>
                            ";
                        exit;
                }
            } else {

                //metodo para cuando se registre una Salida de producto, en el inventario se reste el producto del stock
                $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

                if ($estadoInventario !== false) {
                    //el producto ya existe
                    $cantidadAct = $estadoInventario['CantActual'] - $cantSal;
                    $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

                    //metodo para la acumulacion de puntos del cliente
                    $puntosCliente = $this->modeloCliente->consultaPuntos($idCliente);

                    if ($puntosCliente) {

                        $puntosBd = $puntosCliente['Puntos'];

                        $puntosGanados = ($precioVenta * 0.005);

                        $puntosAct = $puntosBd + $puntosGanados;

                        $this->modeloCliente->actualizaPuntos($puntosAct, $idCliente);
                    }

                    //registrar salida producto
                    $this->modeloSalProducto->registroSalProducto($idProducto, $idCliente, $fechaSal, $cantSal, $precioVenta, $idModoPago);

                    if ($_SESSION['rol'] == 1) {
                            echo "
                                <script>
                                    alert('Registro Salida del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroSalProductos';
                                </script>
                                ";
                            exit;
                    } elseif ($_SESSION['rol'] == 2) {
                            echo "
                                <script>
                                    alert('Registro Salida del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroSalProductosEmp';
                                </script>
                                ";
                            exit;
                    }
                } else {

                    if ($_SESSION['rol'] == 1) {
                            echo "
                                <script>
                                    alert('Registro Salida del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroEntProductos';
                                </script>
                                ";
                            exit;
                    } elseif ($_SESSION['rol'] == 2) {
                            echo "
                                <script>
                                    alert('Registro Salida del Producto Exitoso!');
                                    window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=registroEntProductosEmp';
                                </script>
                                ";
                            exit;
                    }
                }
            }
        }
    }


    //lista de salidas de productos vista consulta
    public function listaSalProductosVista($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $salProductos = $this->modeloSalProducto->consultaGenSalProductosVista($inicio, $limite);
        $totalEntProductos = $this->modeloSalProducto->obtenerTotalSalProductos();
        $totalPaginas = ceil($totalEntProductos / $limite);

        return
            [
                'salProductos' => $salProductos,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //consulta filtro por codigo producto y nombre vista consulta
    public function listaSalProductosFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $salProductos = $this->modeloSalProducto->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloSalProducto->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return
            [
                'salProductos' => $salProductos,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'filtro' => $valor,
                'tipo' => $tipo,
            ];
    }


    //Consulta general por Id
    public function consultaGenSalProductosId()
    {
        $idSalProducto = $_GET['idSalProducto'] ?? '';
        return $this->modeloSalProducto->consultaSalProductoId($idSalProducto);
    }


    //Actualizar Salida de Productos
    public function ActualizarSalProductos()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $codProducto = $_POST['codProducto'];
            $numIdentcliente = $_POST['numIdentCliente'];

            $productoId = $this->modeloProducto->consultaProducto($codProducto);
            $clienteId = $this->modeloCliente->consultaCliente($numIdentcliente);

            $idProducto = $productoId['idProducto'];
            $precioProducto = $_POST['precioProducto'];
            $idCliente = $clienteId['idCliente'];
            $fechaSal = $_POST['fechaSal'];
            $cantSal = $_POST['cantSal'];
            $precioVenta = $_POST['precioVenta'];
            $idModoPago = $_POST['tipoPago'];
            $idSalProducto = $_POST['idSalProducto'];

            $cantidadSal = $this->modeloSalProducto->consultaCantidadSalProductos($idSalProducto);

            $cantidadSalAnterior = $cantidadSal['CantSalida'];

            if ($cantidadSalAnterior == $cantSal) {

                $cantidadActual = $cantSal;

                $this->modeloSalProducto->actualizarSalProducto($idProducto, $idCliente, $fechaSal, $cantidadActual, $precioVenta, $idModoPago, $idSalProducto);

                if ($_SESSION['rol'] == 1) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductos';
                            </script>
                            ";
                        exit;
                } elseif ($_SESSION['rol'] == 2) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductosEmp';
                            </script>
                                ";
                        exit;
                }
            } elseif ($cantidadSalAnterior > $cantSal) {

                $cantidadActual = $cantSal;

                //actualizar el precio de la venta
                $precioVentaAct = $precioProducto * $cantidadActual;

                //actualizar puntos del cliente
                $precioDifer = $precioVenta - $precioVentaAct;

                //metodo para la acumulacion de puntos del cliente
                $puntosCliente = $this->modeloCliente->consultaPuntos($idCliente);

                if ($puntosCliente) {

                    $puntosBd = $puntosCliente['Puntos'];

                    $puntosGanados = ($precioDifer * 0.005);

                    $puntosAct = $puntosBd - $puntosGanados;

                    $this->modeloCliente->actualizaPuntos($puntosAct, $idCliente);
                }

                //actualiza el registro de salida producto
                $this->modeloSalProducto->actualizarSalProducto($idProducto, $idCliente, $fechaSal, $cantidadActual, $precioVentaAct, $idModoPago, $idSalProducto);

                $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

                //Modifica la cantidad Entrada
                $cantidad = $cantidadSalAnterior - $cantSal;

                $cantidadAct = $estadoInventario['CantActual'] + $cantidad;
                $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

                if ($_SESSION['rol'] == 1) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductos';
                            </script>
                            ";
                        exit;
                } elseif ($_SESSION['rol'] == 2) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductosEmp';
                            </script>
                            ";
                        exit;
                }
            } else {

                $cantidadActual = $cantSal;

                $precioVentaAct = $precioProducto * $cantidadActual;

                //actualizar puntos del cliente
                $precioDifer = $precioVentaAct - $precioVenta;

                //metodo para la acumulacion de puntos del cliente
                $puntosCliente = $this->modeloCliente->consultaPuntos($idCliente);

                if ($puntosCliente) {

                    $puntosBd = $puntosCliente['Puntos'];

                    $puntosGanados = ($precioDifer * 0.005);

                    $puntosAct = $puntosBd + $puntosGanados;

                    $this->modeloCliente->actualizaPuntos($puntosAct, $idCliente);
                }

                //actualiza el registro de salida productos
                $this->modeloSalProducto->actualizarSalProducto($idProducto, $idCliente, $fechaSal, $cantidadActual, $precioVentaAct, $idModoPago, $idSalProducto);

                $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

                //Modifica la cantidad Entrada
                $cantidad = $cantSal - $cantidadSalAnterior;

                $cantidadAct = $estadoInventario['CantActual'] - $cantidad;
                $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

                if ($_SESSION['rol'] == 1) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductos';
                            </script>
                            ";
                        exit;
                } elseif ($_SESSION['rol'] == 2) {
                        echo "
                            <script>
                                alert('Registro Salida del Producto Exitoso!');
                                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductosEmp';
                            </script>
                            ";
                        exit;
                }
            }
        }
    }


    //Eliminar Salida Producto
    public function EliminarSalProducto()
    {
        $idSalProducto = $_GET['idSalProducto'] ?? '';

        //Consulta antes de eliminar salida producto
        $cantSal = $this->modeloSalProducto->consultaCantidadSalProductos($idSalProducto);

        $idProducto = $cantSal['idProducto'];
        $cantidad = $cantSal['CantSalida'];
        $idCliente = $cantSal['idCliente'];
        $valorVenta = $cantSal['PrecioVenta'];

        $estadoInventario = $this->modeloInventario->consultaInventarioId($idProducto);

        //suma la cantidad Salida en inventario
        $cantidadAct = $estadoInventario['CantActual'] + $cantidad;
        $this->modeloInventario->actualizarStock($cantidadAct, $idProducto);

        //Descuento de puntos del cliente
        $puntosCliente = $this->modeloCliente->consultaPuntos($idCliente);

        if ($puntosCliente) {

            $puntosBd = $puntosCliente['Puntos'];

            $puntosMenos = ($valorVenta * 0.005);

            $puntosAct = $puntosBd - $puntosMenos;

            $this->modeloCliente->actualizaPuntos($puntosAct, $idCliente);
        }

        $this->modeloSalProducto->eliminarSalProductos($idSalProducto);

        echo "
            <script>
                alert('Eliminacion Exitosa!');
                window.location.href='http://localhost/CRUDvariedadesJYK/index.php?action=consultaSalProductos';
            </script>
            ";
        exit;
    }


    //Generar reporte de salida productos
    public function ReporteSalProductos()
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';
        $reporteSalProductos = $this->modeloSalProducto->reporteSalProductos($fechaInc, $fechaFin);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteSalProductos' => $reporteSalProductos
        ];
    }


    //lista de salida productos vista reporte
    public function listaSalProductos($valor, $tipo)
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';

        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $reporteSalProductos = $this->modeloSalProducto->listaSalProductos($inicio, $limite, $fechaInc, $fechaFin);
        $total = $this->modeloSalProducto->totalSalProductosPorFechas($fechaInc, $fechaFin);
        $totalPaginas = ceil($total / $limite);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteSalProductos' => $reporteSalProductos,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //consulta filtrado por nombre vista reporte
    public function listaSalProductosFiltradoNombre($tipo, $valor)
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';

        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $reporteSalProductos = $this->modeloSalProducto->consultarFiltradoSalProductos($tipo, $valor, $inicio, $limite, $fechaInc, $fechaFin);
        $total = $this->modeloSalProducto->totalFiltradoSalProductos($tipo, $valor, $fechaInc, $fechaFin);
        $totalPaginas = ceil($total / $limite);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteSalProductos' => $reporteSalProductos,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //Registro de salidas de productos por salida de varios producto
    public function registrosSalProductos()
    {
        header("Content-Type: application/json; charset=UTF-8");

        header('Access-Control-Allow-Origin: *');

        $data = json_decode(file_get_contents('php://input'), true);

        if (
            !isset($data['idProducto']) || !isset($data['idCliente']) || !isset($data['fechaSal'])
            || !isset($data['cantidad']) || !isset($data['precio']) || !isset($data['formaPago'])
        ) {

            // Preparar y ejecutar la inserción de cada fila
            foreach ($data as $fila) {

                $codProducto = $fila['idProducto'];
                $numIdentCliente = $fila['idCliente'];
                $fechaSal = $fila['fechaSal'];
                $cantSal = $fila['cantidad'];
                $precioVenta = $fila['precio'];
                $idModoPago = $fila['formaPago'];

                $this->modeloSalProducto->registroSalProducto($codProducto, $numIdentCliente, $fechaSal, $cantSal, $precioVenta, $idModoPago);
            }

            //Respuesta exitosa
            echo json_encode(['success' => true, 'message' => 'Registro de salida productos correctamente']);
        } else {
            //Respuesta error 
            echo "Faltan datos necesarios";
            exit;
        }
    }


    //Metodo para traer datos de productos con mayor Venta
    public function ProductosMasVendidos()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $mayorVenta = $this->modeloSalProducto->productosMasVendidos();

        if ($mayorVenta) {
            echo json_encode(["success" => true, "mayorVenta" => $mayorVenta]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
        }
        exit;
    }


    //Metodo para traer datos de ventas por dias
    public function VentasPorDias()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $ventaPorDia = $this->modeloSalProducto->ventasPorDias();

        if ($ventaPorDia) {
            echo json_encode(["success" => true, "ventaPorDia" => $ventaPorDia]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
        }
        exit;
    }


    //Metodo para traer datos de productos con mayor Venta para pagina principal
    public function ProductosMayorVenta()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $mayoresVenta = $this->modeloSalProducto->productosMayorVenta();

        if ($mayoresVenta) {
            echo json_encode(["success" => true, "mayoresVenta" => $mayoresVenta]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No Encontrado"]);
        }
        exit;
    }


    //Generar reporte de salida productos
    public function ReporteSalProductosEmp()
    {
        $fechaInc = $_GET['fechaInc'] ?? '';
        $fechaFin = $_GET['fechaFin'] ?? '';
        $reporteSalProductos = $this->modeloSalProducto->reporteSalProductos($fechaInc, $fechaFin);

        return [
            'fechaInc' => $fechaInc,
            'fechaFin' => $fechaFin,
            'reporteSalProductos' => $reporteSalProductos
        ];
    }
}
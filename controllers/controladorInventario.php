<?php

require_once('./models/modeloInventario.php');
require_once('./config/conexionBDJYK.php');

class ControladorInventario
{

    private $db;
    private $modeloInventario;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloInventario = new ModeloInventario($this->db);
    }


    // //Reporte de Inventario
    public function inventarioActual()
    {
        return $this->modeloInventario->inventarioActualizadoPDF();
    }

    //lista de stock actual vista inventario
    public function listaInventarioActualizado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $inventario = $this->modeloInventario->inventarioActualizado($inicio, $limite);
        $totalProductos = $this->modeloInventario->obtenerTotalProductos();
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'inventario' => $inventario,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }


    //consulta filtro por nombre de stock actual 
    public function listaProductosFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $inventario = $this->modeloInventario->consultarFiltrado($tipo, $valor, $inicio, $limite);
        $total = $this->modeloInventario->totalFiltrado($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return [
            'inventario' => $inventario,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo
        ];
    }


    //lista de Productos Proximos a Vencer para reporte pdf
    public function ProductosAvencer()
    {
        return $this->modeloInventario->productosAvencer();
    }

    //lista de productos proximos a vencer en vista 
    public function listaProductosAvencer($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $productosAvencer = $this->modeloInventario->listaProductosAvencer($inicio, $limite);
        $totalProductos = $this->modeloInventario->obtenerTotalProductosProximosAvencer();
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'productosAvencer' => $productosAvencer,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo
        ];
    }


    //consulta de productos proximos a vencer filtra por nombre
    public function listaProductosAvencerFiltrado($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $productosAvencer = $this->modeloInventario->consultarFiltradoPrductosAvencer($tipo, $valor, $inicio, $limite);
        $totalProductos = $this->modeloInventario->totalFiltradoPrductosAvencer($tipo, $valor);
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'productosAvencer' => $productosAvencer,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo
        ];
        
    }


    // Consulta para verificar si el stock disponible del producto en BD
    public function disponibilidadProducto()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['idProducto']) || empty($input['idProducto'])) {
                echo json_encode(['error' => 'El ID producto es requerido']);
                exit;
            }

            $idProducto = $input['idProducto'];

            header("Content-Type: application/json; charset=UTF-8");

            $stock = $this->modeloInventario->consultaInventario($idProducto);

            if ($stock) {
                echo json_encode(["success" => true, "stock" => $stock]);
            } else {
                echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }


    //Metodo para actualizar inventario del formulario de salida de productos pór varios productos
    public function actualizarInventario()
    {
        header('Content-Type: application/json');

        header('Access-Control-Allow-Origin: *');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['idProducto']) || !isset($data['cantidad'])) {

            // Preparar y ejecutar la inserción de cada fila
            foreach ($data as $fila) {

                $idProducto = $fila['idProducto'];
                $cantSal = $fila['cantidad'];

                $this->modeloInventario->stockActualizado($cantSal, $idProducto);
            }
            //respuesta exitosa
            echo json_encode(['success' => true, 'message' => 'Datos actualizados en inventario correctamente']);
        } else {
            //repuesta error
            echo json_encode(['success' => false, 'error' => 'Datos No recibidos']);
        }
    }


    //Metodo para traer datos de productos con menor stock
    public function ProductosMenorStock()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $menorStock = $this->modeloInventario->productosMenorStock();

        if ($menorStock) {
            echo json_encode(["success" => true, "menorStock" => $menorStock]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
        }
    }


    //Reporte de invenario productos agotados
    public function ProductoSinStock()
    {
        return $this->modeloInventario->productoSinStock();
    }


    //Lista de productos din stock vista de reporte
    public function listaInventarioSinStock($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $productoSinStock = $this->modeloInventario->productoSinStock($inicio, $limite);
        $totalProductos = $this->modeloInventario->obtenerTotalProductoSinStock();
        $totalPaginas = ceil($totalProductos / $limite);

        return [
            'productoSinStock' => $productoSinStock,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo,
        ];
    }

    //Consulta de producto sin stock vista filtrada por nombre
    public function listaProductosFiltradoSinStock($tipo, $valor)
    {
        $limite = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $limite;

        $productoSinStock = $this->modeloInventario->consultarFiltradoSinStock($tipo, $valor, $inicio, $limite);
        $total = $this->modeloInventario->totalFiltradoSinStock($tipo, $valor);
        $totalPaginas = ceil($total / $limite);

        return [
            'productoSinStock' => $productoSinStock,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'filtro' => $valor,
            'tipo' => $tipo
        ];
    }


    //Reporte de Productos Proximos a Vencer
    public function ProductosAvencerEmp()
    {
        return $this->modeloInventario->productosAvencer();
    }


    // Consulta para verificar si el stock disponible del producto en BD
    public function disponibilidadProductoEmp()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['idProducto']) || empty($input['idProducto'])) {
                echo json_encode(['error' => 'El ID producto es requerido']);
                exit;
            }

            $idProducto = $input['idProducto'];

            $stock = $this->modeloInventario->consultaInventario($idProducto);

            if ($stock) {
                echo json_encode(["success" => true, "stock" => $stock]);
            } else {
                echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        exit;
    }

    //Metodo para traer datos de productos con menor stock
    public function ProductosMenorStockEmp()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $menorStock = $this->modeloInventario->productosMenorStock();

        if ($menorStock) {
            echo json_encode(["success" => true, "menorStock" => $menorStock]);
        } else {
            echo json_encode(["success" => false, "error" => "Producto No esta en Inventario o no hay stock"]);
        }
        exit;
    }

    //Reporte de invenario productos agotados
    public function ProductoSinStockEmp()
    {
        return $this->modeloInventario->productoSinStock();
    }


    //Metodo para traer datos de productos con menor stock
    public function ProductosProximosAvencer()
    {
        header("Content-Type: application/json;");

        $proximosAvencer = $this->modeloInventario->productosProximosAvencer();

        if ($proximosAvencer) {
            echo json_encode(["success" => true, "proximosAvencer" => $proximosAvencer]);
        } else {
            echo json_encode(["success" => false, "error" => "No Hay Productos Proximos a Vencer"]);
        }
        exit;
    }


    //metodo para verificar si el producto existe y hay stock para promociones
    public function VerificarCodProductoPromo()
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

            $producto = $this->modeloInventario->verificarproductoPromo($codProducto);

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
    }
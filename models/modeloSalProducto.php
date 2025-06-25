<?php

class ModeloSalProducto
{

    private $conn;
    private $table = "salida_productos";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Registrar Salida Productos
    public function registroSalProducto($idProducto, $idCliente, $fechaSal, $cantSal, $precioVenta, $idModoPago)
    {
        $query = "INSERT INTO " . $this->table . " (idProducto, idCliente, FechaSalida, CantSalida, PrecioVenta, idModoPago ) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $idCliente, $fechaSal, $cantSal, $precioVenta, $idModoPago]);
    }


    //Consulta para actualizar tabla salida Productos
    public function consultaSalProductoId($idSalProducto)
    {
        $query = "SELECT idSalProducto, productos.CodProducto, clientes.NumIdentificacion, FechaSalida, CantSalida, salida_productos.PrecioVenta, modo_pago.ModoPago FROM " . $this->table . " INNER JOIN productos ON salida_productos.idProducto=productos.idProducto INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente INNER JOIN modo_pago ON salida_productos.idModoPago=modo_pago.idModoPago WHERE idSalProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idSalProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para actualizar tabla salida Productos
    public function consultaSalProductoIdP($idSalProducto)
    {
        $query = "SELECT idSalProducto, productos.CodProducto, clientes.NumIdentificacion, FechaSalida, CantSalida, salida_productos.PrecioVenta, idModoPago FROM " . $this->table . " INNER JOIN productos ON salida_productos.idProducto=productos.idProducto INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente WHERE idSalProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idSalProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para verificar cantidad salida al actualizar tabla salida Productos
    public function consultaCantidadSalProductos($idSalProducto)
    {
        $query = "SELECT idProducto, idCliente, CantSalida, PrecioVenta FROM " . $this->table . " WHERE idSalProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idSalProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Lista de salida de productos vista consulta
    public function consultaGenSalProductosVista($inicio, $limite)
    {
        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                    CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', salida_productos.PrecioVenta, CantSalida, 
                    modo_pago.ModoPago FROM " . $this->table . " 
                    INNER JOIN productos ON salida_productos.idProducto=productos.idProducto 
                    INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente 
                    INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                    INNER JOIN modo_pago ON salida_productos.idModoPago=modo_pago.idModoPago 
                    ORDER BY FechaSalida DESC 
                    LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para contar el total de salida de productos para paginacion
    public function obtenerTotalSalProductos()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta total de salida de productos por codigo y nombre 
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        if ($tipo === 'codigo') {
            $condicion = "CodProducto LIKE :valor";
        } elseif ($tipo === 'fechaSal') {
            $condicion = "DATE(FechaSalida) LIKE :valor";
        } else {
            $condicion = "1=1"; // Sin filtro, o maneja otros casos
        }

        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                    CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', salida_productos.PrecioVenta, CantSalida, 
                    modo_pago.ModoPago FROM " . $this->table . " 
                    INNER JOIN productos ON salida_productos.idProducto=productos.idProducto 
                    INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente 
                    INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                    INNER JOIN modo_pago ON salida_productos.idModoPago=modo_pago.idModoPago 
                    WHERE $condicion
                    ORDER BY FechaSalida DESC 
                    LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de salida de productos por codigo y nombre paginacion
    public function totalFiltrado($tipo, $valor)
    {
        $condicion = '';
        $parametros = [];

        if ($tipo === 'codigo') {
            $condicion = "CodProducto LIKE :valor";
            $parametros[':valor'] = '%' . $valor . '%';
        } elseif ($tipo === 'fechaSal') {
            $condicion = "DATE(FechaSalida) LIKE :valor";
            $parametros[':valor'] = '%' . $valor . '%';
        } else {
            $condicion = "1=1"; // Sin filtro, o maneja otros casos
        }

        $query = "SELECT COUNT(*) FROM " . $this->table . " 
                    INNER JOIN productos ON salida_productos.idProducto=productos.idProducto 
                    INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente 
                    INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                    INNER JOIN modo_pago ON salida_productos.idModoPago=modo_pago.idModoPago 
                    WHERE $condicion";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($parametros);
        return (int)$stmt->fetchColumn();
    }


    //Consulta por Id Salida Productos INNER JOIN
    public function consultaGenSalProductosVistaId($codProducto)
    {
        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', salida_productos.PrecioVenta, CantSalida, modo_pago.ModoPago FROM " . $this->table . " INNER JOIN productos ON salida_productos.idProducto=productos.idProducto INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN modo_pago ON salida_productos.idModoPago=modo_pago.idModoPago WHERE CodProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta por Id Salida Productos INNER JOIN
    public function consultaGenSalProductosVistaFecha($fecha)
    {
        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', salida_productos.PrecioVenta, CantSalida, modo_pago.ModoPago FROM " . $this->table . " INNER JOIN productos ON salida_productos.idProducto=productos.idProducto INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN modo_pago ON salida_productos.idModoPago=modo_pago.idModoPago WHERE DATE(FechaSalida) LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $fecha . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar Entrada Productos
    public function actualizarSalProducto($idProducto, $idCliente, $fechaSal, $cantSal, $precioVentaEntero, $idModoPago, $idSalProducto)
    {
        $query = "UPDATE " . $this->table . " SET idProducto=?, idCliente=?, FechaSalida=?, CantSalida=?, PrecioVenta=?, idModoPago=? WHERE idSalProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $idCliente, $fechaSal, $cantSal, $precioVentaEntero, $idModoPago, $idSalProducto]);
    }


    //Eliminar Registro de tabla Entrada Productos
    public function eliminarSalProductos($idSalProducto)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idSalProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idSalProducto]);
    }


    //Consulta para generar pdf del informe de salida de productos
    public function reporteSalProductos($fechaInc, $fechaFin)
    {
        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', CantSalida, salida_productos.PrecioVenta FROM " . $this->table . " INNER JOIN productos ON salida_productos.idProducto=productos.idProducto INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase WHERE DATE(FechaSalida) BETWEEN ? AND ? ORDER BY FechaSalida DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$fechaInc, $fechaFin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Lista de salida de productos vista reporte por fechas
    public function listaSalProductos($inicio, $limite, $fechaInc, $fechaFin)
    {
        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion,
                CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', CantSalida, 
                salida_productos.PrecioVenta FROM " . $this->table . " 
                INNER JOIN productos ON salida_productos.idProducto=productos.idProducto 
                INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente 
                INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase
                WHERE DATE(FechaSalida) BETWEEN :fechaInc AND :fechaFin
                ORDER BY FechaSalida DESC
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para contar el total de salida de productos por fechas para paginacion
    public function totalSalProductosPorFechas($fechaInc, $fechaFin)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . "
                    WHERE DATE(FechaSalida) BETWEEN :fechaInc AND :fechaFin";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada salida de productos por fechas y nombre vista reporte
    public function consultarFiltradoSalProductos($tipo, $valor, $inicio, $limite, $fechaInc, $fechaFin)
    {
        $query = "SELECT idSalProducto, FechaSalida, clientes.NumIdentificacion, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion,
                CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', CantSalida, 
                salida_productos.PrecioVenta FROM " . $this->table . " 
                INNER JOIN productos ON salida_productos.idProducto=productos.idProducto 
                INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente 
                INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase
                WHERE DATE(FechaSalida) BETWEEN :fechaInc AND :fechaFin
                AND  productos.{$tipo} LIKE :valor 
                ORDER BY FechaSalida DESC
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de salida de productos por nombre paginacion
    public function totalFiltradoSalProductos($tipo, $valor, $fechaInc, $fechaFin)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . "
                    INNER JOIN productos ON salida_productos.idProducto=productos.idProducto 
                    INNER JOIN clientes ON salida_productos.idCliente=clientes.idCliente 
                    WHERE DATE(FechaSalida) BETWEEN :fechaInc AND :fechaFin
                    AND  productos.{$tipo} LIKE :valor";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }


    //Consulta para ver los productos mas vendidos 
    public function productosMasVendidos()
    {
        $query = "SELECT CONCAT(productos.Nombre,' ', productos.Marca,' ', presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Producto', 
        SUM(salida_productos.CantSalida) AS totalVendido FROM " . $this->table . " 
        INNER JOIN productos ON salida_productos.idProducto = productos.idProducto 
        INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase
        GROUP BY productos.idProducto, productos.Nombre, productos.Descripcion 
        ORDER BY totalVendido DESC LIMIT 10";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para ver las ventas por dias
    public function ventasPorDias()
    {
        $query = "SELECT DATE(FechaSalida) AS Fecha, SUM(precioVenta) AS TotalVendido FROM " . $this->table . " GROUP BY Fecha ORDER BY Fecha DESC limit 8";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para ver los productos mas vendidos en pagina principal
    public function productosMayorVenta()
    {
        $query = "SELECT CONCAT(productos.Nombre,' ', productos.Marca,' ', presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Producto',
                    productos.Descripcion, productos.Foto, SUM(salida_productos.CantSalida) AS totalVendido FROM " . $this->table . " 
                    INNER JOIN productos ON salida_productos.idProducto = productos.idProducto 
                    INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase
                    GROUP BY productos.idProducto, productos.Nombre, productos.Descripcion 
                    ORDER BY totalVendido DESC LIMIT 9";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

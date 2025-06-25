<?php

class ModeloEntProducto
{

    private $conn;
    private $table = "entrada_productos";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Registrar Entrada Productos
    public function registroEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEnt)
    {
        $query = "INSERT INTO " . $this->table . " (idProducto, idProveedor, FechaEnt, FechaVencimiento, PrecioCompra, CantEnt) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEnt]);
    }


    //Consulta para actualizar tabla Entrada Productos
    public function consultaGenEntProductos($idEntProducto)
    {
        $query = "SELECT idEntProducto, productos.CodProducto, proveedores.NitProveedor, FechaEnt, FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor WHERE idEntProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idEntProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para verificar cantidad entrada al actualizar tabla Entrada Productos
    public function consultaCantidadEntProductos($idEntProducto)
    {
        $query = "SELECT idProducto, CantEnt FROM " . $this->table . " WHERE idEntProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idEntProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Listado de entrada productos vista consulta
    public function consultaGenEntProductosVista($inicio, $limite)
    {
        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, 
        productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', 
        FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " 
        INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto 
        INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
        INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
        ORDER BY FechaEnt DESC
        LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Total entrada de productos para paginacion
    public function obtenerTotalEntProductos()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por codigo o nombre del producto
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        if ($tipo === 'codigo') {
            $condicion = "CodProducto LIKE :valor";
        } elseif ($tipo === 'fechaEnt') {
            $condicion = "DATE(FechaEnt) LIKE :valor";
        } else {
            $condicion = "1=1"; // Sin filtro, o maneja otros casos
        }

        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, 
        productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', 
        FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " 
        INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto 
        INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
        INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
        WHERE $condicion
        ORDER BY FechaEnt DESC
        LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total por codigo o nombre del producto
    public function totalFiltrado($tipo, $valor)
    {
        $condicion = '';
        $parametros = [];

        if ($tipo === 'codigo') {
            $condicion = "CodProducto LIKE :valor";
            $parametros[':valor'] = '%' . $valor . '%';
        } elseif ($tipo === 'fechaEnt') {
            $condicion = "DATE(FechaEnt) LIKE :valor";
            $parametros[':valor'] = '%' . $valor . '%';
        } else {
            $condicion = "1=1"; // Sin filtro, o maneja otros casos
        }

        $query = "SELECT COUNT(*) FROM " . $this->table . " 
                INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto 
                INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
                INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                WHERE $condicion";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($parametros);
        return (int)$stmt->fetchColumn();
    }


    //Consulta por Id tabla Entrada Productos INNER JOIN
    public function consultaGenEntProductosVistaId($codProducto)
    {
        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase WHERE CodProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta por Id tabla Entrada Productos INNER JOIN
    public function consultaGenEntProductosVistaFecha($fecha)
    {
        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase WHERE DATE(FechaEnt) LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $fecha . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar Entrada Productos
    public function actualizarEntProducto($idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEnt, $idEntProducto)
    {
        $query = "UPDATE " . $this->table . " SET idProducto=?, idProveedor=?, FechaEnt=?, FechaVencimiento=?, PrecioCompra=?, CantEnt=? WHERE idEntProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $idProveedor, $fechaEnt, $fechaVencim, $precioCompra, $cantidadEnt, $idEntProducto]);
    }


    //Eliminar Registro de tabla Entrada Productos
    public function eliminarEntProductos($idEntProducto)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idEntProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idEntProducto]);
    }


    //Consulta para generar pdf del informe de entrada de productos 
    public function reporteEntProductos($fechaInc, $fechaFin)
    {
        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase WHERE DATE(FechaEnt) BETWEEN ? AND ? ORDER BY FechaEnt DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$fechaInc, $fechaFin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //listado de entrada de productos vista informe
    public function listaEntProductos($inicio, $limite, $fechaInc, $fechaFin)
    {
        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, productos.Marca, 
        productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto',
        FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " 
        INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto 
        INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
        INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
        WHERE DATE(FechaEnt) BETWEEN :fechaInc AND :fechaFin 
        ORDER BY FechaEnt DESC
        LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Total entrada de productos para paginacion vista informe
    public function totalEntProductosPorFechas($fechaInc, $fechaFin)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . "
                    WHERE DATE(FechaEnt) BETWEEN :fechaInc AND :fechaFin";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //consulta por filtro nombre vista informe
    public function consultarFiltradoEntProductos($tipo, $valor, $inicio, $limite, $fechaInc, $fechaFin)
    {
        $query = "SELECT idEntProducto, FechaEnt, proveedores.NombreProveedor, productos.CodProducto, productos.Nombre, productos.Marca, 
        productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto',
        FechaVencimiento, PrecioCompra, CantEnt FROM " . $this->table . " 
        INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto 
        INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
        INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
        WHERE DATE(FechaEnt) BETWEEN :fechaInc AND :fechaFin 
        AND  productos.{$tipo} LIKE :valor 
        ORDER BY FechaEnt DESC
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


    //Consulta total por nombre vista informe
    public function totalFiltradoEntProductos($tipo, $valor, $fechaInc, $fechaFin)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . "
                    INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto 
                    INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
                    WHERE DATE(FechaEnt) BETWEEN :fechaInc AND :fechaFin
                    AND productos.{$tipo} LIKE :valor";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':fechaInc', $fechaInc);
        $stmt->bindValue(':fechaFin', $fechaFin);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }


    //consulta para ver los Productos con mayor entrada
    public function productosMayorEntrada()
    {
        $query = "SELECT CONCAT(productos.Nombre,' ', productos.Marca) AS Producto, SUM(entrada_productos.CantEnt) AS TotalEntradas FROM " . $this->table . " INNER JOIN productos ON entrada_productos.idProducto=productos.idProducto  WHERE entrada_productos.FechaEnt >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) GROUP BY productos.idProducto, productos.Nombre, productos.Marca ORDER BY TotalEntradas limit 10";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

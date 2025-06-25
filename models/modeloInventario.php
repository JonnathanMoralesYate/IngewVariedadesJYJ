<?php

class ModeloInventario
{

    private $conn;
    private $table = "inventario";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Registro de Producto en Inventario
    public function registroInventario($idProducto, $cantidadAct)
    {
        $query = "INSERT INTO " . $this->table . " (idProducto, CantActual) VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $cantidadAct]);
    }


    //Consulta de Producto en Inventario
    public function consultaInventarioId($idProducto)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Consulta de Producto en Inventario con Cantidad Actual > 0
    public function consultaInventario($idProducto)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idProducto=? AND CantActual > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Actualiza la Cantidad Actual del Producto
    public function actualizarStock($cantidadAct, $idProducto)
    {
        $query = "UPDATE " . $this->table . " SET CantActual=? WHERE idProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$cantidadAct, $idProducto]);
    }


    //Vista reporte actualizado de inventario
    public function inventarioActualizadoPDF()
    {
        $query = "SELECT idInventario, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', formato_venta.FormatoVenta, CantActual, productos.Foto FROM " . $this->table . " INNER JOIN productos ON inventario.idProducto=productos.idProducto INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta WHERE CantActual > 0 ORDER BY CantActual ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Listado de Stock actual inventario
    public function inventarioActualizado($inicio, $limite)
    {
        $query = "SELECT idInventario, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', 
                formato_venta.FormatoVenta, CantActual, productos.Foto FROM " . $this->table . " 
                INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta 
                WHERE CantActual > 0 
                ORDER BY CantActual ASC
                LIMIT :inicio, :limite";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de stock para paginacion
    public function obtenerTotalProductos()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "  WHERE CantActual > 0");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrado por nombre producto vista reporte
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {

        $query = "SELECT idInventario, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', 
                formato_venta.FormatoVenta, CantActual, productos.Foto FROM " . $this->table . " 
                INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta 
                WHERE productos.{$tipo} LIKE :valor AND CantActual > 0 
                ORDER BY CantActual ASC
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total por nombre producto paginacion
    public function totalFiltrado($tipo, $valor)
    {
        $query = "SELECT COUNT(*) 
                FROM " . $this->table . " 
                INNER JOIN productos ON inventario.idProducto = productos.idProducto 
                WHERE productos.{$tipo} LIKE :valor AND CantActual > 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }


    //Vista reporte Productos Proximos a Vencer de inventario
    public function productosAvencer()
    {
        $query = "SELECT idInventario, entrada_productos.FechaVencimiento, CantActual, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', proveedores.NombreProveedor, productos.Foto FROM " . $this->table . " INNER JOIN productos ON inventario.idProducto=productos.idProducto INNER JOIN entrada_productos ON productos.idProducto=entrada_productos.idProducto INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor WHERE entrada_productos.FechaVencimiento >= CURRENT_DATE AND CantActual>0 ORDER BY entrada_productos.FechaVencimiento ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Lista de productos proximos a vencer vista reporte
    public function listaProductosAvencer($inicio, $limite)
    {
        $query = "SELECT idInventario, entrada_productos.FechaVencimiento, CantActual, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                    CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', proveedores.NombreProveedor, 
                    productos.Foto FROM " . $this->table . " 
                    INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                    INNER JOIN entrada_productos ON productos.idProducto=entrada_productos.idProducto 
                    INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                    INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
                    WHERE entrada_productos.FechaVencimiento >= CURRENT_DATE AND CantActual>0 
                    ORDER BY entrada_productos.FechaVencimiento ASC
                    LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total productos proximos a vencer vista reporte paginacion
    public function obtenerTotalProductosProximosAvencer()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . " 
        INNER JOIN entrada_productos ON inventario.idProducto = entrada_productos.idProducto
        WHERE entrada_productos.FechaVencimiento >= CURRENT_DATE AND CantActual>0");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrado por nombre producto vista reporte
    public function consultarFiltradoPrductosAvencer($tipo, $valor, $inicio, $limite)
    {
        $query = "SELECT idInventario, entrada_productos.FechaVencimiento, CantActual, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                    CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', proveedores.NombreProveedor, 
                    productos.Foto FROM " . $this->table . " 
                    INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                    INNER JOIN entrada_productos ON productos.idProducto=entrada_productos.idProducto 
                    INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                    INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor 
                    WHERE entrada_productos.FechaVencimiento >= CURRENT_DATE AND CantActual>0 
                    AND productos.{$tipo} LIKE :valor
                    ORDER BY entrada_productos.FechaVencimiento ASC
                    LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total por nombre producto vista reporte paginacion
    public function totalFiltradoPrductosAvencer($tipo, $valor)
    {
        $query = "SELECT COUNT(*) 
                FROM " . $this->table . " 
                INNER JOIN entrada_productos ON inventario.idProducto = entrada_productos.idProducto
                INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                WHERE entrada_productos.FechaVencimiento >= CURRENT_DATE AND CantActual>0
                AND productos.{$tipo} LIKE :valor ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }


    //Consulta para ver que prodcutos hay en inventario que estan y no tienen estok
    public function productoSinStock()
    {
        $query = "SELECT idInventario, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', formato_venta.FormatoVenta, CantActual, productos.Foto FROM " . $this->table . " INNER JOIN productos ON inventario.idProducto=productos.idProducto INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta WHERE CantActual = 0";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Listado de productos sin stock vista reporte
    public function productosSinStock($inicio, $limite)
    {
        $query = "SELECT idInventario, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion,
                    CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', 
                    formato_venta.FormatoVenta, CantActual, productos.Foto FROM " . $this->table . " 
                    INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                    INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                    INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta 
                    WHERE CantActual = 0
                    ORDER BY productos.Nombre ASC
                    LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total productos sin stock paginacion
    public function obtenerTotalProductoSinStock()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "  WHERE CantActual = 0");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por nombre producto vista reporte
    public function consultarFiltradoSinStock($tipo, $valor, $inicio, $limite)
    {
        $query = "SELECT idInventario, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, 
                CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', 
                formato_venta.FormatoVenta, CantActual, productos.Foto FROM " . $this->table . " 
                INNER JOIN productos ON inventario.idProducto=productos.idProducto 
                INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase 
                INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta 
                WHERE productos.Nombre LIKE :valor AND CantActual = 0 
                ORDER BY productos.{$tipo} ASC
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total por nombre producto paginacion
    public function totalFiltradoSinStock($tipo, $valor)
    {
        $query = "SELECT COUNT(*) 
                FROM " . $this->table . " 
                INNER JOIN productos ON inventario.idProducto = productos.idProducto 
                WHERE productos.{$tipo} LIKE :valor AND CantActual = 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }


    //Actualiza la Cantidad Actual del Producto por salida de varios producto, solo se realizará si la cantidad actual es mayor o igual que la cantidad a restar.
    public function stockActualizado($cantSal, $idProducto)
    {
        $query = "UPDATE inventario SET CantActual= CantActual - ? WHERE idProducto=? AND CantActual >= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$cantSal, $idProducto, $cantSal]);
    }


    //Consulta para mostrar los productos con menor stock
    public function productosMenorStock()
    {
        $query = "SELECT CONCAT(productos.Nombre, ' ', productos.Marca) AS 'Producto', CantActual FROM " . $this->table . " INNER JOIN productos ON inventario.idProducto = productos.idProducto WHERE CantActual > 0 ORDER BY inventario.CantActual ASC limit 10";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Vista reporte Productos Proximos a Vencer de inventario
    public function productosProximosAvencer()
    {
        $query = "SELECT entrada_productos.FechaVencimiento, inventario.CantActual, productos.CodProducto, productos.Nombre, productos.Marca, productos.Descripcion, CONCAT(presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', proveedores.NombreProveedor, productos.Foto FROM " . $this->table . " INNER JOIN productos ON inventario.idProducto=productos.idProducto INNER JOIN entrada_productos ON productos.idProducto=entrada_productos.idProducto INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN proveedores ON entrada_productos.idProveedor=proveedores.idProveedor WHERE entrada_productos.FechaVencimiento BETWEEN CURDATE() + INTERVAL 0 DAY AND CURDATE() + INTERVAL 4 DAY ORDER BY entrada_productos.FechaVencimiento ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Consulta 
    public function verificarproductoPromo($codProducto)
    {
        $query = "SELECT productos.CodProducto FROM " . $this->table . " 
            INNER JOIN productos ON inventario.idProducto=productos.idProducto
            WHERE productos.CodProducto = ? AND CantActual > 0";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 
}

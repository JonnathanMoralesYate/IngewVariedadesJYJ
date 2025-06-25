<?php
class ModeloProducto
{

    private $conn;
    private $table = "productos";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Registar producto
    public function registroProducto($codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto)
    {
        $query = "INSERT INTO " . $this->table . " (CodProducto, idClase, Nombre, Marca, Descripcion, idPresentacion, idUndBase, ContNeto, idFormatoVenta, PrecioVenta, Foto) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto]);
    }


    //Consulta general productos por codigo de barras
    public function consultGenProductos($codigoProducto)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE CodProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Lista de productos vista consulta
    public function consultGenProductosvista($inicio, $limite)
    {
        $query = "SELECT idProducto, CodProducto, clase_producto.Clase, Nombre, Marca, Descripcion, 
                    presentacion_producto.Presentacion, CONCAT(ContNeto,' ', unidad_base.UndBase) AS Contenido, 
                    formato_venta.FormatoVenta, PrecioVenta, Foto FROM " . $this->table . " 
            INNER JOIN clase_producto ON productos.idClase = clase_producto.idClase 
            INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
            INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase 
            INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta 
            ORDER BY Nombre ASC 
            LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total productos paginacion
    public function obtenerTotalProductos()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM ".$this->table."");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por codigo y nombre del producto
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'CodProducto' : 'Nombre';

        $query = "SELECT idProducto, CodProducto, clase_producto.Clase, Nombre, Marca, Descripcion, 
                        presentacion_producto.Presentacion, CONCAT(ContNeto,' ', unidad_base.UndBase) AS Contenido, 
                        formato_venta.FormatoVenta, PrecioVenta, Foto FROM " . $this->table . "
                INNER JOIN clase_producto ON productos.idClase = clase_producto.idClase 
                INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase 
                INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta 
                WHERE $campo LIKE :valor 
                ORDER BY Nombre ASC 
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total por codigo y nombre paginacion
    public function totalFiltrado($tipo, $valor)
    {
        $campo = $tipo == 'codigo' ? 'CodProducto' : 'Nombre';

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM ".$this->table." WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta general productos de clase
    public function darProductosPorClase($idClase)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idClase=? LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idClase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para mostrar productos segun clase en pagina principal
    public function productosPorClase($idClase)
    {
        $query = "SELECT Foto, CONCAT(Nombre,' ',Marca,' ',presentacion_producto.Presentacion,' ',ContNeto,' ', unidad_base.UndBase) AS 'Producto', 
                Descripcion FROM " . $this->table . " 
                INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
                INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase 
                WHERE idClase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idClase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta para mostrar productos segun nombre en pagina principal
    public function productosPorNombre($nombre)
    {
        $query = "SELECT Foto, CONCAT(Nombre,' ',Marca) AS 'Producto', Descripcion FROM " . $this->table . " WHERE Nombre LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta general productos con inner join por codigo producto
    public function consultGenProductosvistaCodigo($codigoProducto)
    {
        $query = "SELECT idProducto, CodProducto, clase_producto.Clase, Nombre, Marca, Descripcion, 
        presentacion_producto.Presentacion, CONCAT(ContNeto,' ', unidad_base.UndBase) AS Contenido, formato_venta.FormatoVenta, PrecioVenta, Foto FROM " . $this->table .
            " INNER JOIN clase_producto ON productos.idClase=clase_producto.idClase
        INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta WHERE CodProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta general productos con inner join por nombre producto
    public function consultGenProductosvistaNombre($nombre)
    {
        $query = "SELECT idProducto, CodProducto, clase_producto.Clase, Nombre, Marca, Descripcion, 
        presentacion_producto.Presentacion, CONCAT(ContNeto,' ', unidad_base.UndBase) AS Contenido, formato_venta.FormatoVenta, PrecioVenta, Foto FROM " . $this->table .
            " INNER JOIN clase_producto ON productos.idClase=clase_producto.idClase
        INNER JOIN presentacion_producto ON productos.idPresentacion=presentacion_producto.idPresentacion 
        INNER JOIN unidad_base ON productos.idUndBase=unidad_base.idUndBase INNER JOIN formato_venta ON productos.idFormatoVenta=formato_venta.idFormatoVenta WHERE Nombre LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar producto
    public function actualizarProducto($codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto, $idProducto)
    {
        $query = "UPDATE " . $this->table . " SET CodProducto=?, idClase=?, Nombre=?, Marca=?, Descripcion=?, idPresentacion=?, idUndBase=?, ContNeto=?, idFormatoVenta=?, PrecioVenta=?, Foto=? WHERE idProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto, $idClase, $nombre, $marca, $descripcion, $idPresentacion, $idUndBase, $contNeto, $idFormatoVent, $precioVenta, $foto, $idProducto]);
    }


    //Eliminar producto
    public function eliminarProducto($codigoProducto)
    {
        $query = "DELETE FROM " . $this->table . " WHERE CodProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto]);
    }


    //Consulta producto por codigo de barras
    public function consultaProducto($codigoProducto)
    {
        $query = "SELECT idProducto, PrecioVenta FROM " . $this->table . " WHERE CodProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Consulta del productos con inner join para agregar a la tabla
    public function consultaProductoCodigo($idProducto)
    {
        $query = "SELECT CodProducto, CONCAT(Nombre,' ',Marca) AS 'Producto', CONCAT(presentacion_producto.Presentacion,' ', ContNeto,' ', unidad_base.UndBase) AS 'Contenido Neto', PrecioVenta FROM " . $this->table . " INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase WHERE idProducto=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Consulta de Clases que tienen Productos registrados para mostrar las clases en pagina principal
    public function mostrarClasesP()
    {
        $query = "SELECT productos.idClase, clase_producto.Clase FROM " . $this->table . " INNER JOIN clase_producto ON productos.idClase = clase_producto.idClase GROUP BY productos.idClase, clase_producto.Clase";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

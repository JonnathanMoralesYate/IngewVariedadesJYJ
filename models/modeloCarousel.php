<?php

class ModeloCarousel
{
    private $conn;
    private $table = "promociones";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Registrar carousel
    public function registroCarousel($idProducto, $descrpcion)
    {
        $query = "INSERT INTO " . $this->table . " (idProducto, Descripcion) VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $descrpcion]);
    }

    //Consulta general carousel
    public function ConsultaCarouselVista($inicio, $limite)
    {
        $query = "SELECT idPromocion, productos.CodProducto, CONCAT(productos.Nombre, ' - ', productos.Marca, ' - ', presentacion_producto.Presentacion, ' ', productos.ContNeto, ' ', unidad_base.UndBase) AS Producto,
                    promociones.Descripcion, productos.Foto  FROM " . $this->table . "
                    INNER JOIN productos ON promociones.idProducto=productos.idProducto
                    INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase
                    ORDER BY promociones.idPromocion DESC
                    LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total promocion paginacion
    public function obtenerTotalProductos()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por codigo y nombre del producto
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'CodProducto' : 'Nombre';

        $query = "SELECT idPromocion, productos.CodProducto, CONCAT(productos.Nombre, ' - ', productos.Marca, ' - ', presentacion_producto.Presentacion, ' ', productos.ContNeto, ' ', unidad_base.UndBase) AS Producto,
                    promociones.Descripcion, productos.Foto  FROM " . $this->table . "
                    INNER JOIN productos ON promociones.idProducto=productos.idProducto
                    INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase
                    WHERE $campo LIKE :valor 
                    ORDER BY promociones.idPromocion DESC
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
        $campo = $tipo == 'codigo' ? 'productos.CodProducto' : 'productos.Nombre';

        $query = "SELECT COUNT(*) FROM " . $this->table . "
                INNER JOIN productos ON promociones.idProducto = productos.idProducto
                WHERE $campo LIKE :valor";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta por id para actualizar promociones
    public function consultarPromocionId($idPromocion)
    {
        $query = "SELECT idPromocion, productos.CodProducto, promociones.Descripcion 
                    FROM " . $this->table . "
                    INNER JOIN productos ON promociones.idProducto=productos.idproducto
                    WHERE idPromocion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPromocion]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Consulta general carousel
    public function consultGenCarousel()
    {
        $query = "SELECT CONCAT(productos.Nombre,' ', productos.Marca,' ', presentacion_producto.Presentacion,' ', productos.ContNeto,' ', unidad_base.UndBase) AS 'Producto',
                    productos.Foto, promociones.Descripcion  FROM " . $this->table . "
                    INNER JOIN productos ON promociones.idProducto = productos.idProducto 
                    INNER JOIN presentacion_producto ON productos.idPresentacion = presentacion_producto.idPresentacion 
                    INNER JOIN unidad_base ON productos.idUndBase = unidad_base.idUndBase";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar carousel
    public function actualizarPromocion($idProducto, $descrpcion, $idPromocion)
    {
        $query = "UPDATE " . $this->table . " SET idProducto=?, Descripcion=? WHERE idPromocion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProducto, $descrpcion, $idPromocion]);
    }


    //Eliminar carousel
    public function eliminarPromocion($idPromocion)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idPromocion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPromocion]);
    }
}

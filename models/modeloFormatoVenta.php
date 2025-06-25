<?php

class ModeloFormatoVenta
{

    private $conn;
    private $table = "formato_venta";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Registrar formato venta
    public function registrarFormatoVenta($nombre)
    {
        $query = "INSERT INTO " . $this->table . " (FormatoVenta) VALUES(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre]);
    }


    //Consulta general tabla formato venta 
    public function consultGenFormatoVenta()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Lista de formato venta vista consulta
    public function listaFormatoVenta($inicio, $limite) 
    {
        $query = "SELECT * FROM " . $this->table . " LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //consulta total formato venta para paginacion
    public function obtenerTotalFormatoVenta()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por id y nombre formato venta vista consulta
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'idFormatoVenta' : 'FormatoVenta';

        $query = "SELECT * FROM " . $this->table . " WHERE $campo LIKE :valor ORDER BY idFormatoVenta ASC LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total por id y nombre formato venta vista consulta
    public function totalFiltrado($tipo, $valor)
    {
        $campo = $tipo == 'codigo' ? 'idFormatoVenta' : 'FormatoVenta';

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    

    //Consulta formato venta por ID
    public function consultFormatoVentaId($idFormatoVenta)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idFormatoVenta=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idFormatoVenta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta formato venta por Nombre
    public function consultFormatoVentaNombre($nombre)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE FormatoVenta LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar formato venta
    public function actualizarFormatoVenta($nombre, $idFormatoVenta)
    {
        $query = "UPDATE " . $this->table . " SET FormatoVenta=? WHERE idFormatoVenta=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre, $idFormatoVenta]);
    }


    //Eliminar formato venta
    public function eliminarPresentacion($idFormatoVenta)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idFormatoVenta=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idFormatoVenta]);
    }
}

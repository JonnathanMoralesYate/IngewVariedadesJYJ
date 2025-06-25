<?php

class ModeloPresentacion
{

    private $conn;
    private $table = "presentacion_producto";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Registrar presentacion
    public function registrarPresentacion($nombre)
    {
        $query = "INSERT INTO " . $this->table . " (Presentacion) VALUES(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre]);
    }


    //Consulta general tabla presentacion 
    public function consultGenPresentacion()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Listado de presentacion producto vista consulta
    public function listaPresentacion($inicio, $limite)
    {
        $query = "SELECT * FROM " . $this->table . " LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total presentacion producto paginacion
    public function obtenerTotalPresentacion()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por id y nombre presentacion producto vista consulta
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'idPresentacion' : 'Presentacion';

         $query = "SELECT * FROM " . $this->table . " WHERE $campo LIKE :valor ORDER BY Presentacion ASC LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //consulta total filtrada por id y nombre presentacion paginacion
    public function totalFiltrado($tipo, $valor)
    {
        $campo = $tipo == 'codigo' ? 'idPresentacion' : 'Presentacion';

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta presentacion por ID
    public function consultPresentacionId($idPresentacion)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idPresentacion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPresentacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta presentacion por Nombre
    public function consultPresentacionNombre($nombre)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE Presentacion LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar presentacion
    public function actualizarPresentacion($nombre, $idPresentacion)
    {
        $query = "UPDATE " . $this->table . " SET Presentacion=? WHERE idPresentacion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre, $idPresentacion]);
    }


    //Eliminar presentacion
    public function eliminarPresentacion($idPresentacion)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idPresentacion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPresentacion]);
    }
}

<?php

class ModeloUndBase
{

    private $conn;
    private $table = "unidad_base";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Registro unidad base
    public function registrarUndBase($nombre)
    {
        $query = "INSERT INTO " . $this->table . " (UndBase) VALUES(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre]);
    }


    //Consulta general tabla Unidad Base
    public function consultGenUndBase()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Lista de Unidad Base vista consulta
    public function listaUndBase($inicio, $limite)
    {
        $query = "SELECT * FROM " . $this->table . " LIMIT :inicio, :limite";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Contar total de registros unidad base para paginación
    public function obtenerTotalUndBase()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada unidad base por nombre
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'idUndBase' : 'UndBase';

        $query = "SELECT * FROM " . $this->table . " WHERE $campo LIKE :valor ORDER BY UndBase ASC LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Contar total de registros unidad base filtrados para paginación
    public function totalFiltrado($tipo, $valor)
    {
        $campo = $tipo == 'codigo' ? 'idUndBase' : 'UndBase';

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta unidad base por ID
    public function consultUndBaseId($idUndBase)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idUndBase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUndBase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta unidad base por Nombre
    public function consultUndBaseNombre($nombre)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE UndBase LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar unidad base
    public function actualizarUndBase($nombre, $idUndBase)
    {
        $query = "UPDATE " . $this->table . " SET UndBase=? WHERE idUndBase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre, $idUndBase]);
    }


    //Eliminar unidad base
    public function eliminarUndBase($idUndBase)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idUndBase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUndBase]);
    }
}

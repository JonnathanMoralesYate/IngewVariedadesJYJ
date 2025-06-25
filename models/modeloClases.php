<?php

class ModeloClases
{

    private $conn;
    private $table = "clase_producto";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Registrar clase
    public function registrarClases($nombre)
    {
        $query = "INSERT INTO " . $this->table . " (Clase) VALUES(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre]);
    }


    //Consulta general tabla clase Productos
    public function listaClasesP()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta de lista de clases vista consulta
    public function consultGenClases($inicio, $limite)
    {
        $query = "SELECT * FROM " . $this->table . " LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de clases para paginacion
    public function obtenerTotalClases()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta por filtrado de id y nombre de clase
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'idClase' : 'Clase';

        $query = "SELECT * FROM " . $this->table . " WHERE $campo LIKE :valor ORDER BY Clase ASC LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de id y nombre de clase 
    public function totalFiltrado($tipo, $valor)
    {
        $campo = $tipo == 'codigo' ? 'idClase' : 'Clase';

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta clase por ID
    public function consultClaseId($idClase)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idClase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idClase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta clase por Nombre
    public function consultClaseNombre($nombre)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE Clase LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar clase
    public function actualizarClase($nombre, $idClase)
    {
        $query = "UPDATE " . $this->table . " SET Clase=? WHERE idClase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre, $idClase]);
    }


    //Eliminar clase
    public function eliminarClase($idClase)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idClase=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idClase]);
    }
}

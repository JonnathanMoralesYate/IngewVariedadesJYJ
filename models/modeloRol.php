<?php

class ModeloRol
{

    private $conn;
    private $table = "roles";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Consulta general tabla roles
    public function consultGenRoles()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

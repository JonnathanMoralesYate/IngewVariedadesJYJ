<?php

class ModeloLogin
{

    private $conn;
    private $table = "registro_usuarios";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Consulta de Usuario
    public function consultaUsuario($usuario)
    {
        $query = "SELECT idUsuario, idRol, Contraseña, Nombres, Apellidos FROM " . $this->table . " WHERE Usuario=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);      // Devuelve un solo registro como un array asociativo o `false` si no encuentra el usuario
    }
}

<?php

class DataBase
{
    private $host = "localhost";
    private $db_name = "variedadesjyk";
    private $username = "variedadesjyk";
    private $password = "variedJYK2025";
    private static $conn = null;

    public function getConnectionJYK()
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                    $this->username,
                    $this->password
                );
                self::$conn->exec("set names utf8");
            } catch (PDOException $e) {
                echo "Error de Conexión: " . $e->getMessage();
                exit;
            }
        }
        return self::$conn;
    }
}
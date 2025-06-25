<?php

class ModeloModoPago
{

    private $conn;
    private $table = "modo_pago";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Consulta general tabla Modo Pago
    public function consultaModoPago()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

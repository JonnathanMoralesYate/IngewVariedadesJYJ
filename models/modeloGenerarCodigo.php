<?php

class ModeloGenerarCodigo
{

    private $conn;
    private $table = "codigos_barras";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Actualizar codigo generado y asignado Producto
    public function actualizarCodigoGenerado($codigoProducto)
    {
        $query = "UPDATE " . $this->table . " SET CodigoBarra=? WHERE idCodigoBarra=1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigoProducto]);
    }


    //consulta para obtener consecutivo al generar codigo barras
    public function consecutivoCodigo($idConsecutivo)
    {
        $query = "SELECT CodigoBarra FROM codigos_barras WHERE idCodigoBarra=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idConsecutivo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
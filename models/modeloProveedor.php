<?php

class ModeloProveedor
{

    private $conn;
    private $table = "proveedores";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Registrar Proveedor
    public function registroProveedor($nitProve, $nomProve, $correoProve, $celProve, $nomVende, $celVende)
    {
        $query = "INSERT INTO " . $this->table . " (NitProveedor, NombreProveedor, Email, CelularProveedor, NombreVendedor, CelularVendedor) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nitProve, $nomProve, $correoProve, $celProve, $nomVende, $celVende]);
    }


    //Listado de proveedores vista consulta
    public function consultGenProveedores($inicio, $limite)
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY NombreProveedor ASC LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de proveedores paginacion
    public function obtenerTotalProveedores()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . "");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por nit nombre proveedor y vendedor vista consulta
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = match ($tipo) {
            'codigo' => 'NitProveedor',
            'nombreP' => 'NombreProveedor',
            'nombreV' => 'NombreVendedor',
        };

        $query = "SELECT * FROM " . $this->table . "
            WHERE $campo LIKE :valor
            ORDER BY NombreProveedor ASC 
            LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta total de filtrada por nit nombre proveedor y vendedor paginacion
    public function totalFiltrado($tipo, $valor)
    {
        $campo = match ($tipo) {
            'codigo' => 'NitProveedor',
            'nombreP' => 'NombreProveedor',
            'nombreV' => 'NombreVendedor',
        };

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta general proveedor por nit
    public function consultGenProveedorNit($nitProveedor)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE NitProveedor=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nitProveedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Eliminar proveedor
    public function consultGenProveedorId($idProveedor)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE idProveedor=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProveedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta general proveedor por nombre 
    public function consultGenProveedorNombre($nomProve)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE NombreProveedor LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nomProve . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Consulta general proveedor por nombre vendedor
    public function consultGenProveedorNombreVende($nomVende)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE NombreVendedor LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nomVende . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar proveedor
    public function actualizarProveedor($nitProve, $nomProve, $correoProve, $celProve, $nomVende, $celVende, $idProveedor)
    {
        $query = "UPDATE " . $this->table . " SET NitProveedor=?, NombreProveedor=?, Email=?, CelularProveedor=?, NombreVendedor=?, CelularVendedor=? WHERE idProveedor=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nitProve, $nomProve, $correoProve, $celProve, $nomVende, $celVende, $idProveedor]);
    }


    //Eliminar proveedor
    public function eliminarProveedor($idProveedor)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idProveedor=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idProveedor]);
    }


    //Consulta general proveedor por nit
    public function consultaProveedor($nitProveedor)
    {
        $query = "SELECT idProveedor FROM " . $this->table . " WHERE NitProveedor=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nitProveedor]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

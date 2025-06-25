<?php

class ModeloUsuario
{

    private $conn;
    private $table = "registro_usuarios";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Registro de Usuario
    public function registroUsuario($idTipoDocum, $numDocumento, $nombre, $apellido, $numCelular, $correoE, $rol, $usuario, $claveSegura)
    {
        $query = "INSERT INTO " . $this->table . " (idTipoDocum, NumIdentificacion, Nombres, Apellidos, NumCelular, Email, idRol, Usuario, Contraseña) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idTipoDocum, $numDocumento, $nombre, $apellido, $numCelular, $correoE, $rol, $usuario, $claveSegura]);
    }


    //Consulta general de la tabla
    public function consultGenUsua()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Lista de usuarios vista consulta
    public function consultGenUsuaVista($inicio, $limite)
    {
        $query = "SELECT idUsuario, tipo_documento.tipoDocum, NumIdentificacion, Nombres, Apellidos, 
                NumCelular, Email, roles.Rol, Usuario, Contraseña FROM " . $this->table . " 
                INNER JOIN tipo_documento ON registro_usuarios.idTipoDocum = tipo_documento.idTipoDocum 
                INNER JOIN roles ON registro_usuarios.idRol = roles.idRol
                ORDER BY Nombres ASC 
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Contar total de registros para paginación
    public function obtenerTotalUsuarios()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table . " ");
        return (int)$stmt->fetchColumn();
    }


    //Consulta filtrada por numero documento o nombre
    public function consultarFiltrado($tipo, $valor, $inicio, $limite)
    {
        $campo = $tipo == 'codigo' ? 'NumIdentificacion' : 'Nombres';

        $query = "SELECT idUsuario, tipo_documento.tipoDocum, NumIdentificacion, Nombres, Apellidos, 
                NumCelular, Email, roles.Rol, Usuario, Contraseña FROM " . $this->table . " 
                INNER JOIN tipo_documento ON registro_usuarios.idTipoDocum = tipo_documento.idTipoDocum 
                INNER JOIN roles ON registro_usuarios.idRol = roles.idRol
                WHERE $campo LIKE :valor
                ORDER BY Nombres ASC 
                LIMIT :inicio, :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Contar total de registros filtrados para paginación
    public function totalFiltrado($tipo, $valor)
    {
        $campo = $tipo == 'codigo' ? 'NumIdentificacion' : 'Nombres';

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM ".$this->table." WHERE $campo LIKE :valor");
        $stmt->bindValue(':valor', "%$valor%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    //Consulta por parametro Id
    public function consultUsuaId($idUsua)
    {
        $query = "SELECT idUsuario, idTipoDocum, NumIdentificacion, Nombres, Apellidos, NumCelular, Email, idRol, Usuario FROM " . $this->table . " WHERE idUsuario=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsua]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //consulta general con inner join por Id
    public function consultGenUsuaVistaId($numIdentUsuario)
    {
        $query = "SELECT idUsuario, tipo_documento.tipoDocum, NumIdentificacion, Nombres, Apellidos, NumCelular, Email, roles.Rol, Usuario, Contraseña FROM " . $this->table . " INNER JOIN tipo_documento ON registro_usuarios.idTipoDocum = tipo_documento.idTipoDocum INNER JOIN roles ON registro_usuarios.idRol = roles.idRol WHERE NumIdentificacion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$numIdentUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //consulta general con inner join por Nombre
    public function consultGenUsuaVistaNombre($nombre)
    {
        $query = "SELECT idUsuario, tipo_documento.tipoDocum, NumIdentificacion, Nombres, Apellidos, NumCelular, Email, roles.Rol, Usuario, Contraseña FROM " . $this->table . " INNER JOIN tipo_documento ON registro_usuarios.idTipoDocum = tipo_documento.idTipoDocum INNER JOIN roles ON registro_usuarios.idRol = roles.idRol WHERE Nombres LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $nombre . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Actualizar usuario
    public function actualizarUsua($idTipoDocum, $numDocumento, $nombre, $apellido, $numCelular, $correoE, $rol, $usuario, $claveSegura, $idUsua)
    {
        $query = "UPDATE " . $this->table . " SET idTipoDocum = ?, NumIdentificacion = ?, Nombres = ?, Apellidos = ?, NumCelular = ?, Email = ?, idRol = ?, Usuario = ?";

        $params = [
            $idTipoDocum,
            $numDocumento,
            $nombre,
            $apellido,
            $numCelular,
            $correoE,
            $rol,
            $usuario
        ];

        // Agregar contraseña solo si no es NULL
        if (!empty($claveSegura)) {
            $query .= ", Contraseña = ?";
            $params[] = $claveSegura;
        }

        // Finalizar la consulta
        $query .= " WHERE idUsuario = ?";
        $params[] = $idUsua;

        // Preparar y ejecutar
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
    }


    //Eliminar usuario
    public function eliminarUsua($idUsua)
    {
        $query = "DELETE FROM " . $this->table . " WHERE idUsuario=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsua]);
    }


    //Consulta por numero de identificacion
    public function consultaUsuario($numDocumU)
    {
        $query = "SELECT idUsuario FROM " . $this->table . " WHERE NumIdentificacion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$numDocumU]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

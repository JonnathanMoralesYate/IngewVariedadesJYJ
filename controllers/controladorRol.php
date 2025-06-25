<?php

require_once('./models/modeloRol.php');
require_once('./config/conexionBDJYK.php');

class ControladorRol
{

    private $db;
    private $modeloRol;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloRol = new ModeloRol($this->db);
    }


    //Lista de roles
    public function listaRoles()
    {
        return $this->modeloRol->consultGenRoles();
    }
}

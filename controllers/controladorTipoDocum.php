<?php

require_once('./models/modeloTipoDocum.php');
require_once('./config/conexionBDJYK.php');

class ControladorTipoDocum
{

    private $db;
    private $modeloTipoDocum;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloTipoDocum = new ModeloTipoDocum($this->db);
    }


    //Lista de tipo de documento
    public function listaTiposDocum()
    {
        return $this->modeloTipoDocum->consultGenTipoDocum();
    }
}

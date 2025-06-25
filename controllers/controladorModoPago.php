<?php

require_once('./models/modeloModoPago.php');
require_once('./config/conexionBDJYK.php');

class ControladorModoPago
{

    private $db;
    private $modeloModoPago;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloModoPago = new ModeloModoPago($this->db);
    }


    //Lista de Modo de Pago
    public function listaModoPago()
    {
        return $this->modeloModoPago->consultaModoPago();
    }
}

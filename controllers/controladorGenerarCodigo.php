<?php

require_once('./models/modeloGenerarCodigo.php');
require_once('./config/conexionBDJYK.php');

class ControladorGenerarCodigo
{

    private $db;
    private $modeloGenerarCodigo;


    public function __construct()
    {

        $database = new DataBase();
        $this->db = $database->getConnectionJYK();
        $this->modeloGenerarCodigo = new ModeloGenerarCodigo($this->db);
    }


    //metodo para traer el consecutivo para generar codigo de barras
    public function ConsecutivoCodigo()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputJSON = file_get_contents("php://input");

            $input = json_decode($inputJSON, true);

            if (!isset($input['idConsecutivo']) || empty($input['idConsecutivo'])) {
                echo json_encode(['error' => 'El ID del Consecutivo es requerido']);
                exit;
            }

            $idConsecutivo = $input['idConsecutivo'];

            header("Content-Type: application/json; charset=UTF-8");

            $consecutivoCodigo = $this->modeloGenerarCodigo->consecutivoCodigo($idConsecutivo);

            if ($consecutivoCodigo) {
                echo json_encode(["success" => true, "consecutivoCodigo" => $consecutivoCodigo]);
            } else {
                echo json_encode(["success" => false, "error" => "Consecutivo del Codigo No Registrado"]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
<?php
// app/controllers/PacienteController.php
require_once __DIR__ . '/../models/Paciente.php';

class PacienteController {
    private $db;
    private $pacienteModel;

    public function __construct($db) {
        $this->db = $db;
        $this->pacienteModel = new Paciente($this->db);
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datosUsuario = [
                'nombre_usuario' => $_POST['nombre_usuario'],
                'contrasena'     => $_POST['cedula'] // Usamos la cédula como contraseña inicial
            ];

            $datosPersonales = [
                'nombre'    => $_POST['nombre'],
                'apellido'  => $_POST['apellido'],
                'cedula'    => $_POST['cedula'],
                'correo'    => $_POST['correo'],
                'telefono'  => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            ];

            $datosMedicos = [
                'tipo_sangre'             => $_POST['tipo_sangre'],
                'antecedentes_personales' => $_POST['antecedentes_personales'],
                'alergias'                => $_POST['alergias'],
                'antecedentes_familiares' => $_POST['antecedentes_familiares'],
                'habitos_psicobiologicos' => $_POST['habitos_psicobiologicos']
            ];

            $resultado = $this->pacienteModel->registrarCompleto($datosUsuario, $datosPersonales, $datosMedicos);
            
            if ($resultado === true) {
                header("Location: index.php?view=dashboard&msg=paciente_registrado");
            } else {
                echo "<script>alert('$resultado');</script>";
            }
        }
    }
}
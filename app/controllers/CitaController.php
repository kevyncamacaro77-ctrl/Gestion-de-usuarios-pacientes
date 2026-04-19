<?php
// app/controllers/CitaController.php
require_once __DIR__ . '/../models/Cita.php';

class CitaController {
    private $db;
    private $citaModel;

    public function __construct($db) {
        $this->db = $db;
        $this->citaModel = new Cita($this->db);
    }

    public function guardarDisponibilidad() {
        if (isset($_POST['btn_disponibilidad'])) {
            $res = $this->citaModel->registrarDisponibilidad(
                $_SESSION['id_medico_perfil'], // Debes tener este ID en la sesión
                $_POST['fecha'],
                $_POST['h_inicio'],
                $_POST['h_fin']
            );
            if ($res) header("Location: index.php?view=dashboard&msg=ok");
        }
    }
}
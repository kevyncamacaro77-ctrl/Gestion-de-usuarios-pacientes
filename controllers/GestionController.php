<?php
require_once 'models/Cita.php';
require_once 'models/Consulta.php';

class GestionController {
    private $db;
    private $citaModel;
    private $consultaModel;

    public function __construct($db) {
        $this->db = $db;
        $this->citaModel = new Cita($db);
        $this->consultaModel = new Consulta($db);
    }

    // ... (tus otras funciones citas y cancelarCita se mantienen igual)

    public function disponibilidad() {
        if ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 1) {
            $id_usuario = $_SESSION['user_id'];
            
            // CORRECCIÓN: Para ver los horarios, primero buscamos el idmedico real
            $queryM = $this->db->prepare("SELECT idmedico FROM medico WHERE Usuario_id_usuario = ?");
            $queryM->execute([$id_usuario]);
            $medico = $queryM->fetch(PDO::FETCH_ASSOC);
            
            $horarios = [];
            if ($medico) {
                $id_real = $medico['idmedico'];
                $query = $this->db->prepare("SELECT * FROM disponibilidad WHERE idmedico = ? ORDER BY fecha ASC, horainicio ASC");
                $query->execute([$id_real]);
                $horarios = $query->fetchAll(PDO::FETCH_OBJ);
            }
            
            include 'views/medico/disponibilidad.php';
        } else {
            header("Location: index.php?action=dashboard");
        }
    }

    public function guardarDisponibilidad() {

     if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol'])) {
        die("Error: La sesión se perdió antes de guardar. ID: " . ($_SESSION['user_id'] ?? 'Nulo'));
    }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 1)) {
            $id_sesion_usuario = $_SESSION['user_id'];
            $fecha = $_POST['fecha'];
            $inicio = $_POST['hora_inicio'];
            $fin = $_POST['hora_fin'];

            try {
                $queryMedico = $this->db->prepare("SELECT idmedico FROM medico WHERE Usuario_id_usuario = ?");
                $queryMedico->execute([$id_sesion_usuario]);
                $medico = $queryMedico->fetch(PDO::FETCH_ASSOC);

                if ($medico) {
                    $id_real_medico = $medico['idmedico'];
                    $stmt = $this->db->prepare("INSERT INTO disponibilidad (idmedico, fecha, horainicio, horafin, estatus) VALUES (?, ?, ?, ?, 'disponible')");
                    $stmt->execute([$id_real_medico, $fecha, $inicio, $fin]);

                    header("Location: index.php?action=gestionar_disponibilidad");
                    exit();
                } else {
                    die("Error: No se encontró perfil médico.");
                }
            } catch (PDOException $e) {
                die("Error de base de datos: " . $e->getMessage());
            }
        }
    } 

    public function eliminarHorario() {
        if (isset($_GET['id']) && ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 1)) {
            $id = $_GET['id'];
            $stmt = $this->db->prepare("DELETE FROM disponibilidad WHERE id_disponibilidad = ?");
            $stmt->execute([$id]);
            header("Location: index.php?action=gestionar_disponibilidad");
            exit();
        }
    }

    public function historial() {
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $historial = $this->consultaModel->obtenerPorPaciente($_SESSION['user_id']);
        include 'views/pacient/historial_paciente.php'; 
    }

    private function calcularHorasRestantes($fecha) {
        $fecha_cita = new DateTime($fecha);
        $ahora = new DateTime();
        $dif = $ahora->diff($fecha_cita);
        return ($dif->days * 24) + $dif->h;
    }

    private function mostrarAlerta($mensaje, $accionRedirigir) {
        echo "<script>alert('$mensaje'); window.location.href='index.php?action=$accionRedirigir';</script>";
        exit();
    }
} 
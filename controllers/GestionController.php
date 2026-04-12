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

    public function citas() {
    if (!isset($_SESSION['user_id'])) { 
        header("Location: index.php?action=login"); 
        exit(); 
    }
    
    $rol = $_SESSION['rol'];
    $id = $_SESSION['user_id'];

    if ($rol == 1 || $rol == 4) {
        $citas = $this->citaModel->listarTodo();
    } else {
        $citas = $this->citaModel->listarPorUsuario($id, $rol);
    }
    
    include 'views/shared/citas.php';
    }

public function buscarPaciente() {
    $id_usuario = $_SESSION['user_id'];

    // 1. Obtenemos el idmedico real del doctor logueado
    $stmtM = $this->db->prepare("SELECT idmedico FROM medico WHERE Usuario_id_usuario = ?");
    $stmtM->execute([$id_usuario]);
    $medico = $stmtM->fetch(PDO::FETCH_ASSOC);

    if ($medico) {
        $id_medico = $medico['idmedico'];

        // 2. Consulta con Triple JOIN siguiendo tu estructura de phpMyAdmin
        $query = $this->db->prepare("
            SELECT DISTINCT p.* FROM paciente p
            INNER JOIN cita c ON p.idpaciente = c.idpaciente
            INNER JOIN disponibilidad d ON c.id_disponibilidad = d.id_disponibilidad
            WHERE d.idmedico = ?
        ");
        
        try {
            $query->execute([$id_medico]);
            $pacientes = $query->fetchAll(PDO::FETCH_OBJ);
            include 'views/medico/mis_pacientes.php';
        } catch (PDOException $e) {
            die("Error en la base de datos: " . $e->getMessage());
        }
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


public function mostrarConsulta() {
    $id_paciente = $_GET['id_paciente'] ?? null;
    $id_consulta = $_GET['id_consulta'] ?? null;
    
    $paciente = null;
    $consulta = null;
    $consultas_anteriores = [];

    // Si viene un ID de paciente (desde "Mis Pacientes"), buscamos sus datos e historial
    if ($id_paciente) {
        $stmtP = $this->db->prepare("SELECT * FROM paciente WHERE idpaciente = ?");
        $stmtP->execute([$id_paciente]);
        $paciente = $stmtP->fetch(PDO::FETCH_OBJ);

        $stmtH = $this->db->prepare("SELECT * FROM consulta WHERE paciente_idpaciente = ? ORDER BY fecha DESC");
        $stmtH->execute([$id_paciente]);
        $consultas_anteriores = $stmtH->fetchAll(PDO::FETCH_OBJ);
    }

    // Si viene un ID de consulta (para editar), buscamos la consulta
    if ($id_consulta) {
        $stmtC = $this->db->prepare("SELECT * FROM consulta WHERE idConsulta = ?");
        $stmtC->execute([$id_consulta]);
        $consulta = $stmtC->fetch(PDO::FETCH_OBJ);
    }

    // Cargamos la vista. Ahora no dará error si $paciente es null
    include 'views/medico/consulta.php';
}

// Guardar o Actualizar los datos
public function guardarConsulta() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_con = $_POST['idConsulta'] ?? null;
        $motivo = $_POST['motivo'];
        $diag = $_POST['diagnostico'];
        $recom = $_POST['recomendaciones'];
        $estado = $_POST['estado'];
        
        // 1. Obtener el ID del médico logueado
        $stmtM = $this->db->prepare("SELECT idmedico FROM medico WHERE Usuario_id_usuario = ?");
        $stmtM->execute([$_SESSION['user_id']]);
        $medico = $stmtM->fetch(PDO::FETCH_ASSOC);
        $id_m = $medico['idmedico'];

        // 2. Lógica para obtener el ID del paciente
        $id_p = null;
        if (!empty($_POST['paciente_idpaciente'])) {
            $id_p = $_POST['paciente_idpaciente'];
        } elseif (!empty($_POST['cedula_buscar'])) {
            // Buscamos al paciente por la cédula que escribió el médico
            $stmtP = $this->db->prepare("SELECT idpaciente FROM paciente WHERE cedula = ?");
            $stmtP->execute([$_POST['cedula_buscar']]);
            $paciente = $stmtP->fetch(PDO::FETCH_ASSOC);
            
            if ($paciente) {
                $id_p = $paciente['idpaciente'];
            } else {
                die("Error: No existe un paciente registrado con la cédula: " . $_POST['cedula_buscar']);
            }
        }

        if ($id_p) {
            try {
                if (!empty($id_con)) {
                    // ACTUALIZAR CONSULTA EXISTENTE
                    $sql = "UPDATE consulta SET motivo=?, diagnostico=?, recomendaciones=?, estado=? WHERE idConsulta=?";
                    $this->db->prepare($sql)->execute([$motivo, $diag, $recom, $estado, $id_con]);
                } else {
                    // INSERTAR NUEVA CONSULTA
                    $sql = "INSERT INTO consulta (fecha, motivo, diagnostico, recomendaciones, estado, medico_idmedico, paciente_idpaciente) 
                            VALUES (NOW(), ?, ?, ?, ?, ?, ?)";
                    $this->db->prepare($sql)->execute([$motivo, $diag, $recom, $estado, $id_m, $id_p]);
                }
                
                // Redirigir con éxito
                header("Location: index.php?action=mis_pacientes&msg=success");
            } catch (PDOException $e) {
                die("Error al guardar en la base de datos: " . $e->getMessage());
            }
        }
    }
}

} 
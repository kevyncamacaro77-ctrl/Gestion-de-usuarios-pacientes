<?php

class MedicoController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMedicosPorEspecialidad() {
        if (ob_get_level()) ob_end_clean(); // Limpia basura del buffer
        
        $id = $_GET['id'] ?? null;
        
        // Esta consulta hace que SOLO aparezcan médicos que TENGAN horarios disponibles
        $sql = "SELECT DISTINCT m.idmedico, m.nombre 
                FROM medico m
                INNER JOIN medico_especialidad me ON m.idmedico = me.medico_idmedico
                INNER JOIN disponibilidad d ON m.idmedico = d.idmedico
                WHERE me.Especialidad_id_especialidad = :id 
                AND d.estatus = 'disponible'"; 

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        header('Content-Type: application/json');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // --- ESTA ES LA QUE TE FALTABA AGREGAR ---
    public function getHorariosDisponibles() {
        if (ob_get_level()) ob_end_clean();
        
        $id_medico = $_GET['id_medico'] ?? null;

        try {
            // Buscamos los cupos en la tabla disponibilidad para ese médico específico
            $sql = "SELECT id_disponibilidad, fecha, horainicio 
                    FROM disponibilidad 
                    WHERE idmedico = :id 
                    AND estatus = 'disponible' 
                    ORDER BY fecha, horainicio ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id_medico]);
            $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($horarios);

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

    public function guardarConsulta() {
    $tipo = $_POST['tipo_consulta']; // Asegúrate que tu select envíe esto
    $id_cita = $_POST['id_cita'] ?? null;

    // VALIDACIÓN: Si NO es emergencia y NO hay cita seleccionada
    if ($tipo !== 'Emergencia' && empty($id_cita)) {
        // Redirigir con error si tu sistema tiene mensajes flash
        header("Location: index.php?action=nueva_consulta&error=cita_obligatoria");
        exit();
    }

    // 1. Guardar la consulta en la DB (Tu código actual)
    $this->model->insertarConsulta($_POST);

    // 2. Si venía de una cita, actualizar su estado para que no aparezca más como "Pendiente"
    if (!empty($id_cita)) {
        $this->db->prepare("UPDATE cita SET estado = 'Finalizada' WHERE id_cita = ?")
                 ->execute([$id_cita]);
    }
    
    header("Location: index.php?action=historial&success=1");
}
public function cancelarCita($id) {
    // Si el médico intenta cancelar, el modelo debe permitirlo
    $resultado = $this->model->actualizarEstadoCita($id, 'Cancelada');

    if ($resultado) {
        header("Location: index.php?action=citas&success=cancelada");
    } else {
        header("Location: index.php?action=citas&error=error_cancelar");
    }
    exit();
}
}
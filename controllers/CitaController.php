<?php
class CitaController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function guardarCita() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Capturamos los datos
        $id_disponibilidad = $_POST['id_disponibilidad'] ?? null;
        
        // 2. CORRECCIÓN CLAVE: Usamos 'user_id' que es como sale en tu Array de diagnóstico
        $id_paciente = $_SESSION['user_id'] ?? null; 

        if ($id_disponibilidad && $id_paciente) {
            try {
                $this->db->beginTransaction();

                // 3. Insertar en la tabla 'cita' (Nombres exactos de tu imagen 294163)
                $sqlCita = "INSERT INTO cita (fecha_creacion, motivo, idpaciente, id_disponibilidad) 
                            VALUES (NOW(), 'Consulta Oftalmológica', :idp, :idd)";
                
                $stmtCita = $this->db->prepare($sqlCita);
                $stmtCita->execute([
                    'idp' => $id_paciente,
                    'idd' => $id_disponibilidad
                ]);

                // 4. Actualizar la tabla 'disponibilidad' (Nombres exactos de tu imagen 29354b)
                $sqlDisp = "UPDATE disponibilidad SET estatus = 'ocupado' WHERE id_disponibilidad = :idd";
                $stmtDisp = $this->db->prepare($sqlDisp);
                $stmtDisp->execute(['idd' => $id_disponibilidad]);

                $this->db->commit();
                
                // 5. Redirección al Dashboard con mensaje de éxito
                header("Location: index.php?action=dashboard&res=ok");
                exit;

            } catch (Exception $e) {
                if ($this->db->inTransaction()) $this->db->rollBack();
                die("Error en la base de datos: " . $e->getMessage());
            }
        } else {
            die("Error crítico: No se pudo identificar al paciente (user_id) o el cupo (id_disponibilidad).");
        }
    }
}
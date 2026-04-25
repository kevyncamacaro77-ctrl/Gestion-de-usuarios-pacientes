<?php
class Admin {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener citas contadas por cada especialidad
    public function getEstadisticasCitas() {
        $sql = "SELECT 
                    e.nombre_especialidad, 
                    COUNT(c.id_cita) as total_citas
                FROM Especialidad e
                LEFT JOIN medico_especialidad me ON e.id_especialidad = me.id_especialidad
                LEFT JOIN medico m ON me.idmedico = m.idmedico
                LEFT JOIN cita c ON m.idmedico = c.medico_idmedico
                GROUP BY e.id_especialidad, e.nombre_especialidad";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de pacientes registrados
    public function getTotalPacientes() {
        $sql = "SELECT COUNT(*) as total FROM paciente";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
}
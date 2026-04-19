<?php
// app/models/Cita.php

class Cita {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Genera bloques de tiempo de 40 min ignorando el tiempo de almuerzo
    public function generarHorariosDisponibles($horaInicio, $horaFin, $intervalo = 40) {
        $horarios = [];
        $inicio = new DateTime($horaInicio);
        $fin = new DateTime($horaFin);

        // Definimos un rango de almuerzo (ejemplo: 12:00 a 13:00)
        $almuerzoInicio = new DateTime("12:00:00");
        $almuerzoFin = new DateTime("13:00:00");

        while ($inicio < $fin) {
            $bloqueFin = clone $inicio;
            $bloqueFin->modify("+$intervalo minutes");

            // Si el bloque no choca con el almuerzo, lo agregamos
            if ($inicio < $almuerzoInicio || $inicio >= $almuerzoFin) {
                if ($bloqueFin <= $fin) {
                    $horarios[] = $inicio->format('H:i');
                }
            }
            $inicio->modify("+$intervalo minutes");
        }
        return $horarios;
    }

    public function registrarDisponibilidad($id_medico, $fecha, $hora_inicio, $hora_fin) {
        $sql = "INSERT INTO Disponibilidad (fecha, horainicio, horafin, estatus, idmedico) 
                VALUES (:fecha, :inicio, :fin, 'Disponible', :id_medico)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'fecha' => $fecha,
            'inicio' => $hora_inicio,
            'fin' => $hora_fin,
            'id_medico' => $id_medico
        ]);
    }
}
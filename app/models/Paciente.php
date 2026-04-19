<?php
// app/models/Paciente.php

class Paciente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarCompleto($datosUsuario, $datosPersonales, $datosMedicos) {
        try {
            $this->conn->beginTransaction();

            // 1. Crear el Usuario (rol 4 = Paciente, estado 1 = Activo)
            $sqlUser = "INSERT INTO Usuario (nombre_usuario, contrasena, idrol, idestado_usuario) 
                        VALUES (:user, :pass, 4, 1)";
            $stmtUser = $this->conn->prepare($sqlUser);
            $stmtUser->execute([
                'user' => $datosUsuario['nombre_usuario'],
                'pass' => password_hash($datosUsuario['contrasena'], PASSWORD_BCRYPT)
            ]);
            $idUsuarioCreado = $this->conn->lastInsertId();

            // 2. Crear el Estado del Paciente (Antecedentes)
            // Vinculamos con el ID del usuario que registra (el de la sesión actual)
            $sqlEstado = "INSERT INTO Estado_paciente (tipo_sangre, antecedentes_personales, alergias, antecedentes_familiares, habitos_psicobiologicos, id_usuario) 
                          VALUES (:sangre, :ant_p, :alergias, :ant_f, :habitos, :id_autor)";
            $stmtEstado = $this->conn->prepare($sqlEstado);
            $stmtEstado->execute([
                'sangre'  => $datosMedicos['tipo_sangre'],
                'ant_p'   => $datosMedicos['antecedentes_personales'],
                'alergias' => $datosMedicos['alergias'],
                'ant_f'   => $datosMedicos['antecedentes_familiares'],
                'habitos' => $datosMedicos['habitos_psicobiologicos'],
                'id_autor'=> $_SESSION['id_usuario'] 
            ]);
            $idEstadoCreado = $this->conn->lastInsertId();

            // 3. Crear los datos del Paciente vinculado a los anteriores
            $sqlPaciente = "INSERT INTO paciente (id_usuario, nombre, apellido, cedula, correo, telefono, direccion, idEstado_paciente) 
                            VALUES (:id_u, :nom, :ape, :ced, :cor, :tel, :dir, :id_e)";
            $stmtPac = $this->conn->prepare($sqlPaciente);
            $stmtPac->execute([
                'id_u' => $idUsuarioCreado,
                'nom'  => $datosPersonales['nombre'],
                'ape'  => $datosPersonales['apellido'],
                'ced'  => $datosPersonales['cedula'],
                'cor'  => $datosPersonales['correo'],
                'tel'  => $datosPersonales['telefono'],
                'dir'  => $datosPersonales['direccion'],
                'id_e' => $idEstadoCreado
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return "Error al registrar: " . $e->getMessage();
        }
    }
}
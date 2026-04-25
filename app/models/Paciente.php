<?php
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

            // 2. Crear los datos del Paciente vinculado al Usuario
            $sqlPaciente = "INSERT INTO paciente (id_usuario, nombre, apellido, cedula, correo, telefono, direccion) 
                            VALUES (:id_u, :nom, :ape, :ced, :cor, :tel, :dir)";
            $stmtPac = $this->conn->prepare($sqlPaciente);
            $stmtPac->execute([
                'id_u' => $idUsuarioCreado,
                'nom'  => $datosPersonales['nombre'],
                'ape'  => $datosPersonales['apellido'],
                'ced'  => $datosPersonales['cedula'],
                'cor'  => $datosPersonales['correo'],
                'tel'  => $datosPersonales['telefono'],
                'dir'  => $datosPersonales['direccion']
            ]);
            $idPacienteCreado = $this->conn->lastInsertId();

            // 3. Crear los Antecedentes (en la tabla 'antecedentes')
            $sqlAnt = "INSERT INTO antecedentes (tipo_sangre, antecedentes_personales, alergias, antecedentes_familiares, habitos_psicobiologicos) 
                       VALUES (:sangre, :ant_p, :alergias, :ant_f, :habitos)";
            $stmtAnt = $this->conn->prepare($sqlAnt);
            $stmtAnt->execute([
                'sangre'  => $datosMedicos['tipo_sangre'],
                'ant_p'   => $datosMedicos['antecedentes_personales'],
                'alergias' => $datosMedicos['alergias'],
                'ant_f'   => $datosMedicos['antecedentes_familiares'],
                'habitos' => $datosMedicos['habitos_psicobiologicos']
            ]);
            $idAntecedenteCreado = $this->conn->lastInsertId();

            // 4. Vincular Paciente con Antecedente (en la tabla intermedia)
            $sqlVinculo = "INSERT INTO paciente_antecedente (paciente_idpaciente, antecedentes_idantecedentes) 
                           VALUES (:id_p, :id_a)";
            $stmtVinculo = $this->conn->prepare($sqlVinculo);
            $stmtVinculo->execute([
                'id_p' => $idPacienteCreado,
                'id_a' => $idAntecedenteCreado
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return "Error al registrar: " . $e->getMessage();
        }
    }
}
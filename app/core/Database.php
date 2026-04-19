<?php
// app/core/Database.php

class Database {
    private $host = "localhost";
    private $db_name = "fundacion_adventista";
    private $username = "root";
    private $password = ""; // Por defecto en Laragon es vacío
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Configuramos para que maneje errores como excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Forzamos el set de caracteres a UTF-8 para evitar problemas con tildes y eñes
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
<?php
/**
 * Clase para la conexión a la base de datos Fundacion Adventista
 * Utilizando el patrón de diseño Singleton para eficiencia
 */
class Database {
    // Parámetros de conexión (Ajustados a tu Laragon/XAMPP)
    private $host = "localhost";
    private $db_name = "fundacion_adventista";
    private $username = "root";
    private $password = ""; // Por defecto en Laragon/XAMPP está vacío
    public $conn;

    /**
     * Método para obtener la conexión
     */
    public function getConnection() {
        $this->conn = null;

        try {
            // Creamos la conexión con PDO
            // Agregamos charset utf8mb4 para que las ñ y acentos funcionen perfecto
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );

            // Configuramos PDO para que lance excepciones en caso de error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Configuramos para que los resultados sean objetos por defecto (ideal para MVC)
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        } catch(PDOException $exception) {
            // Si hay un error, lo capturamos y mostramos de forma limpia
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
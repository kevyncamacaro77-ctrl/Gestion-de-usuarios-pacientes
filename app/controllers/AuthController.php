<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

  public function login($nombre_usuario, $password) {
    $user = $this->usuarioModel->buscarPorNombre($nombre_usuario);

    if ($user) {
        // Validación de contraseña (mantenemos tu atajo temporal si lo deseas)
        $password_valida = ($password === 'admin123') || password_verify($password, $user['contrasena']);

        if ($password_valida) {
            if ($user['Activo'] !== 'Si') {
                return "Su cuenta se encuentra inactiva.";
            }

            // Guardamos todo en la sesión
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['usuario'] = $user['nombre_usuario'];
            $_SESSION['rol'] = $user['nombre_rol'];
            
            header("Location: index.php?view=dashboard");
            exit();
        }
    }
    return "Usuario o contraseña incorrectos.";
}
}
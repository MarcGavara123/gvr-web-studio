<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // En XAMPP normalmente es 'root'
define('DB_PASS', ''); // En XAMPP normalmente está vacío
define('DB_NAME', 'gvrweb_bd');

// Crear conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer charset
$conn->set_charset("utf8mb4");

// Iniciar sesión si es necesario
session_start();
?>
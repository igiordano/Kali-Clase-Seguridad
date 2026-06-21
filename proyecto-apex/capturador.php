<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datos de conexión
$host = '127.0.0.1';
$user = 'apex_user';
$pass = 'Apex2026';
$db   = 'apex_db';

// Conexión directa nativa con MySQLi
$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibimos los datos del formulario
$usuario  = $_POST['usuario_apex'] ?? '';
$password = $_POST['password_apex'] ?? '';

// VULNERABILIDAD REAL: Concatenación directa pura
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";

// Ejecutamos la consulta
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    // Si devuelve filas (gracias al bypass), entra al panel comprometido
    header("Location: index.php?status=success_authenticated");
    exit();
} else {
    // Si no encuentra nada, deniega el acceso
    header("Location: index.php?status=error_credentials");
    exit();
}
?>

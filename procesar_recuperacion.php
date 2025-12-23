<?php
include "config/conexion.php"; // Ajusta esta ruta a tu archivo de conexión

$correo = $_POST['correo'];

// Consultar usuario
$consulta = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows == 0) {
    // El correo NO existe
    header("Location: recuperar_contraseña.php?error=no_encontrado");
    exit;
}

// Si existe, aquí después generaremos el código
echo "Se envió un código de recuperación a tu correo.";
?>

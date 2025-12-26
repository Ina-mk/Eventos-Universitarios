<?php
// Iniciamos sesión para guardar el correo del usuario
session_start();

// Conectamos a la base de datos
include "config/conexion.php";

// Recibimos el código escrito por el usuario
$codigo = $_POST['codigo'];

// Obtenemos la fecha y hora actual
$ahora = date("Y-m-d H:i:s");

// Buscamos un usuario con ese código que no esté expirado
$consulta = "
    SELECT correo FROM usuarios 
    WHERE codigo_recuperacion = '$codigo'
    AND codigo_expira >= '$ahora'
";

$resultado = $conexion->query($consulta);

// Si no se encontró ningún registro, el código es inválido
if ($resultado->num_rows == 0) {
    header("Location: verificar_codigo.php?error=invalido");
    exit;
}

// Si el código es válido, obtenemos el correo
$usuario = $resultado->fetch_assoc();

// Guardamos el correo en sesión para el siguiente paso
$_SESSION['correo_recuperacion'] = $usuario['correo'];

// Redirigimos a la pantalla para cambiar contraseña
header("Location: cambiar_contraseña.php");
exit;

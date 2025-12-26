<?php
// Conectamos con la base de datos
include "config/conexion.php";

// Recibimos el correo enviado desde el formulario
session_start();
$correo = $_SESSION['correo_recuperacion'];


// Recibimos la nueva contraseña y la ciframos
// password_hash la protege para que nadie pueda verla
$nueva = password_hash($_POST['nueva'], PASSWORD_DEFAULT);

// Actualizamos la contraseña en la base de datos
// y borramos el código de recuperación y su expiración
$actualizar = "
    UPDATE usuarios 
    SET contraseña = '$nueva',
        codigo_recuperacion = NULL,
        codigo_expira = NULL
    WHERE correo = '$correo'
";

// Ejecutamos la consulta
$conexion->query($actualizar);

// Redirigimos al login para que inicie sesión con la nueva contraseña
header("Location: login.php");
exit;
?>

<?php
// ===============================
// INICIAMOS LA SESIÓN
// ===============================
// Esto nos permite usar $_SESSION
session_start();

// ===============================
// SEGURIDAD
// ===============================
// Si NO existe el correo guardado en sesión,
// significa que el usuario NO pasó por el código,
// entonces lo mandamos al inicio del proceso
if (!isset($_SESSION['correo_recuperacion'])) {
    header("Location: recuperar_contraseña.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!-- Título que aparece en la pestaña -->
    <title>Crear nueva contraseña</title>
</head>
<body>

<!-- Título visible en la página -->
<h2>Crear nueva contraseña</h2>

<!-- 
    FORMULARIO PARA CAMBIAR LA CONTRASEÑA
    Este formulario envía la nueva contraseña
    al archivo guardar_nueva_contraseña.php
-->
<form action="guardar_nueva_contraseña.php" method="POST">

    <!-- Campo para escribir la nueva contraseña -->
    <label>Nueva contraseña:</label><br>
    <input type="password" name="nueva" required><br><br>

    <!-- Campo para confirmar la contraseña -->
    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirmar" required><br><br>

    <!-- Botón para guardar la nueva contraseña -->
    <button type="submit">Guardar contraseña</button>

</form>

</body>
</html>

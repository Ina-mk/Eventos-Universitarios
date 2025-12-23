<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
</head>
<body>

<h2>Recuperar contraseña</h2>

<?php if (isset($_GET['error']) && $_GET['error'] == 'no_encontrado'): ?>
    <p style="color: red;">Correo no registrado</p>
<?php endif; ?>

<form action="procesar_recuperacion.php" method="POST">

    <label>Ingresa el correo registrado, enviaremos un código de recuperación:</label><br>
    <input type="email" name="correo" required><br><br>

    <button type="submit">Enviar código</button>

</form>

<br>
<a href="login.php">Volver al inicio de sesión</a>

</body>
</html>

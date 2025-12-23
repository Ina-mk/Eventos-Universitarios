<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>

<!-- TÍTULO PRINCIPAL DEL FORMULARIO -->
<h2>Iniciar sesión</h2>

<!-- FORMULARIO QUE ENVÍA LOS DATOS A procesar_login.php -->
<form action="procesar_login.php" method="POST">

    <!-- ETIQUETA Y CAMPO DEL CORREO -->
    <label>Correo:</label><br>
    <input type="email" name="correo" required><br><br>

    <!-- ETIQUETA Y CAMPO DE CONTRASEÑA -->
    <label>Contraseña:</label><br>
    <input type="password" name="contraseña" required><br><br>

    <!-- BOTÓN PARA ENVIAR EL FORMULARIO -->
    <button type="submit">Ingresar</button>
</form>

<br>

<!-- ENLACE A LA PÁGINA PARA RECUPERAR CONTRASEÑA -->
<a href="recuperar_contraseña.php">¿Olvidaste tu contraseña?</a>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
</head>
<body>

<h2>Registro de usuario</h2>

<form action="registrar_usuario.php" method="POST">

    <label>Correo Institucional:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contraseña" required><br><br>

    <label>Rol:</label><br>
    <select name="rol" required>
        <option value="estudiante">Estudiante</option>
        <option value="organizador">Organizador</option>
        <option value="admin">Administrador</option>
    </select>
    <br><br>

    <button type="submit">Registrarse</button>

</form>

</body>
</html>

<?php



// ===============================
// registrar_usuario.php
// Permite al administrador registrar nuevos usuarios
// ===============================

// Iniciar sesión para validar rol de administrador
session_start();

/*echo 'POST<pre>';
print_r($_POST);
echo '</pre>';
echo 'SESSION<pre>';
print_r($_SESSION);
echo '</pre>';
exit;*/
// ===============================
// VERIFICAR QUE EL USUARIO SEA ADMIN
// ===============================
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
require 'config/conexion.php';

// ===============================
// VARIABLES PARA MENSAJE
// ===============================
$mensaje = ''; // Aquí se almacenarán errores o mensajes de éxito

// ===============================
// PROCESAR FORMULARIO SI SE ENVÍA
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ===============================
    // RECIBIR Y LIMPIAR DATOS DEL FORMULARIO
    // ===============================
    $correo = trim($_POST['correo'] ?? '');
    $contraseña = trim($_POST['contraseña'] ?? '');
    $rol = trim($_POST['rol'] ?? '');

    // ===============================
    // VALIDAR CAMPOS OBLIGATORIOS
    // ===============================
    if (!$correo || !$contraseña || !$rol) {
        $mensaje = "Error: Todos los campos son obligatorios.";
    } 
    // ===============================
    // VALIDAR QUE EL CORREO SEA INSTITUCIONAL
    // ===============================
    elseif (!str_ends_with($correo, '@alumno.ipn.mx')) {
        $mensaje = "Error: Solo se permiten correos institucionales (@alumno.ipn.mx).";
    } 
    // ===============================
    // INSERTAR USUARIO EN LA BD
    // ===============================
    else {
        // Encriptar contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        // Preparar consulta SQL
        $sql = "INSERT INTO usuarios (correo, contraseña, rol) 
                VALUES ('$correo', '$contraseña_hash', '$rol')";

        // Ejecutar consulta y verificar resultado
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "Usuario registrado correctamente.";
        } else {
            $mensaje = "Error al registrar usuario: " . $conexion->error;
        }
    }
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <!-- ===============================
         TÍTULO DE LA PÁGINA
         =============================== -->
    <h2 class="text-center mb-4">Registrar Nuevo Usuario</h2>

    <!-- ===============================
         MOSTRAR MENSAJE DE ERROR O ÉXITO
         =============================== -->
    <?php if ($mensaje): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- ===============================
         FORMULARIO DE REGISTRO
         =============================== -->
    <form action="" method="POST" class="bg-white p-4 shadow rounded">
        <!-- Correo institucional -->
        <div class="mb-3">
            <label for="correo" class="form-label">Correo institucional</label>
            <input type="email" name="correo" id="correo" class="form-control" required placeholder="usuario@alumno.ipn.mx">
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" required>
        </div>

        <!-- Selección de rol -->
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="">Selecciona un rol</option>
                <option value="estudiante">Estudiante</option>
                <option value="organizador">Organizador</option>
            </select>
        </div>

        <!-- Botón enviar -->
        <button type="submit" class="btn btn-primary w-100">Registrar Usuario</button>
    </form>

    <!-- Botón para regresar al panel admin -->
    <div class="text-center mt-3">
        <a href="panel_admin.php" class="btn btn-secondary">Volver al panel</a>
    </div>
</div>

</body>
</html>
<?php
// ===============================
// INICIAR SESIÓN Y VERIFICAR ROL
// ===============================
session_start();
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','organizador'])) {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";
// ===============================
// VALIDAR PERFIL COMPLETO
// ===============================
$id_usuario = $_SESSION['id_usuario'];

$consulta_perfil = "
    SELECT nombre 
    FROM perfil_organizador
    WHERE id_usuario = $id_usuario
";

$resultado_perfil = $conexion->query($consulta_perfil);
$perfil = $resultado_perfil->fetch_assoc();

if (empty($perfil['nombre'])) {
    header("Location: editar_perfil_organizador.php?error=perfil_incompleto");
    exit;
}


// ===============================
// PROCESAR ENVÍO DEL FORMULARIO
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $lugar = $_POST['lugar'];
    $organizador = $_SESSION['nombre']; // También podría ser id_usuario

    // VALIDACIÓN BÁSICA DE CAMPOS OBLIGATORIOS
    if ($nombre && $fecha && $hora && $lugar) {
        // INSERTAR EVENTO EN LA BASE DE DATOS
        $conexion->query("INSERT INTO eventos (nombre, descripcion, fecha, hora, lugar, organizador) 
                          VALUES ('$nombre','$descripcion','$fecha','$hora','$lugar','$organizador')");
        header("Location: panel_organizador.php?success=1");
        exit;
    } else {
        $error = "Debes llenar todos los campos obligatorios";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4">
        <h3>Crear Evento</h3>

        <!-- ===============================
             BLOQUE DE MENSAJE DE ERROR
             =============================== -->
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- ===============================
             FORMULARIO DE CREACIÓN DE EVENTO
             =============================== -->
        <form method="POST">
            <!-- Nombre del evento -->
            <div class="mb-3">
                <label>Nombre del evento</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>

            <!-- Fecha -->
            <div class="mb-3">
                <label>Fecha</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>

            <!-- Hora -->
            <div class="mb-3">
                <label>Hora</label>
                <input type="time" name="hora" class="form-control" required>
            </div>

            <!-- Lugar -->
            <div class="mb-3">
                <label>Lugar</label>
                <input type="text" name="lugar" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Crear Evento</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
// ===============================
// INICIAR SESIÓN Y VERIFICAR ROL
// ===============================
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'organizador') {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";

// ===============================
// OBTENER EL ID DEL EVENTO
// ===============================
$id_evento = $_GET['id'] ?? 0;
$id_evento = (int)$id_evento; // seguridad

// ===============================
// CONSULTAR EL EVENTO
// ===============================
$sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
$result = $conexion->query($sql);

if ($result->num_rows === 0) {
    die("Evento no encontrado.");
}

$evento = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="mb-3"><?= htmlspecialchars($evento['nombre']) ?></h2>
        <p><i class="bi bi-calendar-event"></i> <strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha']) ?></p>
        <p><i class="bi bi-geo-alt"></i> <strong>Lugar:</strong> <?= htmlspecialchars($evento['lugar']) ?></p>
        <p><strong>Descripción:</strong></p>
        <p><?= nl2br(htmlspecialchars($evento['descripcion'])) ?></p>

        <div class="mt-4">
            <a href="panel_organizador.php" class="btn btn-primary">Regresar al panel</a>
            <a href="editar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-secondary">Editar evento</a>
            <a href="eliminar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-danger">Eliminar evento</a>
        </div>
    </div>
</div>

</body>
</html>

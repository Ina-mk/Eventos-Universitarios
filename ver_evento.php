<?php
// ===============================
// INICIAR SESIÓN Y VERIFICAR ROL
// Permite solo estudiantes, organizadores o admins
// ===============================
session_start();

if (
    !isset($_SESSION['rol']) ||
    !in_array($_SESSION['rol'], ['organizador', 'estudiante','admin'])
) {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";

// ===============================
// OBTENER EL ID DEL EVENTO DE LA URL
// ===============================
$id_evento = $_GET['id'] ?? 0;
$id_evento = (int)$id_evento; // Seguridad: evitar inyección SQL

// ===============================
// CONSULTAR EL EVENTO
// ===============================
$sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
$result = $conexion->query($sql);

// Validar que exista el evento
if ($result->num_rows === 0) {
    die("Evento no encontrado.");
}

// Obtener datos del evento
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
        <!-- Nombre del evento -->
        <h2 class="mb-3"><?= htmlspecialchars($evento['nombre']) ?></h2>

        <!-- Fecha y lugar -->
        <p><i class="bi bi-calendar-event"></i> <strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha']) ?></p>
        <p><i class="bi bi-geo-alt"></i> <strong>Lugar:</strong> <?= htmlspecialchars($evento['lugar']) ?></p>

        <!-- Descripción del evento -->
        <p><strong>Descripción:</strong></p>
        <p><?= nl2br(htmlspecialchars($evento['descripcion'])) ?></p>

        <!-- BOTONES DEPENDIENDO DEL ROL -->
        <div class="mt-4">
            <?php if ($_SESSION['rol'] === 'organizador'): ?>
                <!-- El organizador puede editar o eliminar -->
                <a href="panel_organizador.php" class="btn btn-primary">Regresar al panel</a>
                <a href="editar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-secondary">Editar evento</a>
                <a href="eliminar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-danger"
                   onclick="return confirm('¿Estás seguro que deseas eliminar el evento?');">
                   Eliminar evento
                </a>

            <?php elseif ($_SESSION['rol'] === 'admin'): ?>
                <!-- Admin solo regresa al panel admin -->
                <a href="gestionar_eventos_admin.php" class="btn btn-primary">Regresar a gestionar eventos</a>

            <?php else: ?>
                <!-- Estudiante solo regresa al panel de eventos -->
                <a href="panel_estudiante.php" class="btn btn-primary">Regresar a eventos</a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
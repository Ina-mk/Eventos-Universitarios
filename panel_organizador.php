<?php
// ===============================
// INICIAR SESIÓN Y VALIDAR ROL
// ===============================
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'organizador') {
    header("Location: login.php");
    exit;
}

include "config/conexion.php";

// ===============================
// OBTENER NOMBRE DEL ORGANIZADOR DESDE BD
// ===============================
$id_usuario = $_SESSION['id_usuario'];

$consulta_nombre = "
    SELECT nombre 
    FROM perfil_organizador
    WHERE id_usuario = $id_usuario
";

$resultado_nombre = $conexion->query($consulta_nombre);
$datos_org = $resultado_nombre->fetch_assoc();

$organizador = $datos_org['nombre'] ?? '';


// ===============================
// CONSULTAR EVENTOS DEL ORGANIZADOR
// ===============================
$consulta = "
    SELECT * 
    FROM eventos
    WHERE organizador = '$organizador'
    ORDER BY fecha ASC
";

$resultado = $conexion->query($consulta);

// ===============================
// VERIFICAR MENSAJES DE ÉXITO
// ===============================
$mensaje_success = '';
if (isset($_GET['success']) && $_GET['success'] == 'evento_guardado') {
    $mensaje_success = "Evento guardado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Organizador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --azul-claro: #eaf2ff;
            --azul-principal: #2b90e2;
            --azul-secundario: #558fda;
            --azul-oscuro: #1f5fa8;
            --blanco: #ffffff;
            --gris: #555;
        }

        body { background-color: var(--azul-claro); }
        .navbar { background-color: var(--azul-principal) !important; }
        .navbar-brand { color: var(--blanco) !important; font-weight: bold; }
        .card { border-left: 5px solid var(--azul-principal); box-shadow: 0 3px 10px rgba(0,0,0,.15); }
        .btn-primary { background-color: var(--azul-principal) !important; border-color: var(--azul-principal) !important; }
        .btn-primary:hover { background-color: var(--azul-secundario) !important; border-color: var(--azul-secundario) !important; }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Panel Organizador</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-2">Organizador</span>
            <!-- BOTÓN EDITAR PERFIL -->
    <a href="editar_perfil_organizador.php" class="btn btn-outline-light btn-sm me-2">
        Editar perfil
    </a>
            <i class="bi bi-person-fill text-white fs-3"></i>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <!-- MENSAJE DE ÉXITO -->
    <?php if ($mensaje_success): ?>
        <div class="alert alert-success text-center">
            <i class="bi bi-check-circle-fill"></i> <?= $mensaje_success ?>
        </div>
    <?php endif; ?>

    <h2 class="text-center mb-4">Mis Eventos</h2>

    <div class="row">

        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($evento = $resultado->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card p-3 h-100">
                        <h5><?= $evento['nombre'] ?></h5>
                        <p class="text-muted mb-1">
                            <i class="bi bi-calendar-event"></i> <?= $evento['fecha'] ?>
                        </p>
                        <p class="text-muted">
                            <i class="bi bi-geo-alt"></i> <?= $evento['lugar'] ?>
                        </p>

                        <!-- BOTONES DE ACCIÓN -->
                        <a href="ver_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-primary mt-auto mb-2">Ver detalles</a>
                        <a href="editar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-secondary mt-auto mb-2">Editar</a>
                        <a href="eliminar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-danger mt-auto">Eliminar</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No tienes eventos registrados.</p>
        <?php endif; ?>

    </div>

<div class="text-center mt-4">
    <a href="crear_evento.php" class="btn btn-success">Crear nuevo evento</a>

</div>


</div>

</body>
</html>

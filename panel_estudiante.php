<?php
// ===============================
// PANEL DEL ESTUDIANTE
// Muestra todos los eventos y recomendaciones según intereses
// ===============================

session_start();

// ===============================
// VERIFICAR SESIÓN Y ROL
// ===============================
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}

include "config/conexion.php";

// ===============================
// OBTENER ID DEL ESTUDIANTE
// ===============================
$id_usuario = $_SESSION['id_usuario'];

// ===============================
// OBTENER INTERESES DEL ESTUDIANTE
// ===============================
$consulta_intereses = "
    SELECT intereses 
    FROM perfil_estudiante 
    WHERE id_usuario = $id_usuario
";
$res = $conexion->query($consulta_intereses);

$intereses = [];
if ($res->num_rows > 0) {
    $fila = $res->fetch_assoc();
    // Suponiendo que los intereses están separados por comas
    $intereses = array_map('trim', explode(',', $fila['intereses']));
}

// ===============================
// CONSULTAR EVENTOS RECOMENDADOS SEGÚN INTERESES
// ===============================
$resultado_recomendados = null;
if (!empty($intereses)) {
    $intereses_in = "'" . implode("','", $intereses) . "'";
    $consulta_recomendados = "
        SELECT *
        FROM eventos
        WHERE categoria IN ($intereses_in)
        ORDER BY fecha ASC
    ";
    $resultado_recomendados = $conexion->query($consulta_recomendados);
}

// ===============================
// CONSULTAR TODOS LOS EVENTOS DISPONIBLES
// ===============================
$consulta_todos = "
    SELECT *
    FROM eventos
    ORDER BY fecha ASC
";
$resultado_todos = $conexion->query($consulta_todos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --azul-claro: #eaf2ff;
            --azul-principal: #2b90e2;
            --azul-secundario: #558fda;
            --blanco: #ffffff;
            --gris: #555;
        }

        body { background-color: var(--azul-claro); }
        .navbar { background-color: var(--azul-principal) !important; }
        .navbar-brand { color: var(--blanco) !important; font-weight: bold; }
        .card {
            border: none;
            border-left: 5px solid var(--azul-principal);
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }
        .btn-primary {
            background-color: var(--azul-principal) !important;
            border-color: var(--azul-principal) !important;
        }
        .btn-primary:hover {
            background-color: var(--azul-secundario) !important;
            border-color: var(--azul-secundario) !important;
        }
        /* Estilos para los botones del navbar */
        .btn-outline-light:hover {
            background-color: var(--blanco);
            color: var(--azul-principal);
        }
        h3 { margin-top: 40px; }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Eventos ESCOM</a>
        
        <!-- Botón para móvil (hamburguesa) por si la pantalla es pequeña -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="ms-auto d-flex align-items-center gap-2">
                
                <!-- Botón Mi Perfil -->
                <a href="perfil_estudiante.php" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle"></i> Mi perfil
                </a>

                <!-- Botón Cerrar Sesión (NUEVO) -->
                <a href="logout.php" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>

                <!-- Separador visual -->
                <div class="vr bg-white mx-2" style="height: 25px; opacity: 0.5;"></div>

                <!-- Indicador de Rol -->
                <div class="d-flex align-items-center text-white">
                    <span class="me-2">Estudiante</span>
                    <i class="bi bi-mortarboard-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <!-- ===============================
         SECCIÓN: Eventos recomendados según intereses
         =============================== -->
    <?php if ($resultado_recomendados && $resultado_recomendados->num_rows > 0): ?>
        <h3><i class="bi bi-star-fill text-warning"></i> Esto podría interesarte</h3>
        <div class="row">
            <?php while ($evento = $resultado_recomendados->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card p-3 h-100">
                        <h5><?= htmlspecialchars($evento['nombre']) ?></h5>
                        <p class="text-muted mb-1"><i class="bi bi-calendar-event"></i> <?= htmlspecialchars($evento['fecha']) ?></p>
                        <p class="text-muted"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evento['lugar']) ?></p>
                        <a href="ver_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-primary mt-auto">Ver detalles</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <!-- ===============================
         SECCIÓN: Todos los eventos disponibles
         =============================== -->
    <h3>Eventos disponibles</h3>
    <div class="row">
        <?php if ($resultado_todos->num_rows > 0): ?>
            <?php while ($evento = $resultado_todos->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card p-3 h-100">
                        <h5><?= htmlspecialchars($evento['nombre']) ?></h5>
                        <p class="text-muted mb-1"><i class="bi bi-calendar-event"></i> <?= htmlspecialchars($evento['fecha']) ?></p>
                        <p class="text-muted"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evento['lugar']) ?></p>
                        <a href="ver_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-primary mt-auto">Ver detalles</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No hay eventos disponibles en este momento.
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Scripts de Bootstrap (Necesarios para colapsar el menú en móviles) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
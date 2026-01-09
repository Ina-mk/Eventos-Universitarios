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

// Si no tiene nombre, usamos 'Organizador' por defecto
$organizador = !empty($datos_org['nombre']) ? $datos_org['nombre'] : 'Organizador';


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
if (isset($_GET['success']) && $_GET['success'] == 'evento_creado') {
    $mensaje_success = "El evento ha sido creado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Organizador</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos Bootstrap -->
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
        
        /* Estilos para el Dropdown del menú de usuario */
        .nav-link.dropdown-toggle {
            color: var(--blanco) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link.dropdown-toggle:hover { opacity: 0.9; }
        
        .card { 
            border: none;
            border-left: 5px solid var(--azul-principal); 
            box-shadow: 0 3px 10px rgba(0,0,0,.15); 
        }
        
        .btn-primary { 
            background-color: var(--azul-principal) !important; 
            border-color: var(--azul-principal) !important; 
        }
        .btn-primary:hover { 
            background-color: var(--azul-secundario) !important; 
            border-color: var(--azul-secundario) !important; 
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="panel_organizador.php">
            <i class="bi bi-calendar-check me-2"></i>Panel Organizador
        </a>
        
        <!-- Botón hamburguesa para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <!-- MENÚ DE USUARIO DROPDOWN -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="text-white"><?= htmlspecialchars($organizador) ?></span>
                        <i class="bi bi-person-circle text-white fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><h6 class="dropdown-header">Mi Cuenta</h6></li>
                        
                        <!-- Opción Editar Perfil -->
                        <li>
                            <a class="dropdown-item" href="editar_perfil_organizador.php">
                                <i class="bi bi-pencil-square me-2"></i>Editar perfil
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        <!-- Opción Salir (Cerrar Sesión) -->
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <!-- MENSAJE DE ÉXITO -->
    <?php if ($mensaje_success): ?>
        <div class="alert alert-success text-center shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $mensaje_success ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-list-task me-2 text-primary"></i>Mis Eventos</h2>
        <a href="crear_evento.php" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Crear nuevo evento
        </a>
    </div>

    <div class="row">

        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($evento = $resultado->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card p-3 h-100">
                        <h5 class="fw-bold text-primary"><?= htmlspecialchars($evento['nombre']) ?></h5>
                        
                        <div class="mb-3">
                            <p class="text-muted mb-1 small">
                                <i class="bi bi-calendar-event me-1"></i> <?= htmlspecialchars($evento['fecha']) ?>
                                <span class="mx-1">|</span>
                                <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($evento['hora']) ?>
                            </p>
                            <p class="text-muted small">
                                <i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($evento['lugar']) ?>
                            </p>
                        </div>

                        <!-- BOTONES DE ACCIÓN -->
                        <div class="mt-auto d-grid gap-2">
                            <a href="ver_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye me-1"></i> Ver detalles
                            </a>
                            <div class="d-flex gap-2">
                                <a href="editar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-secondary btn-sm flex-fill">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>
                                <a href="eliminar_evento.php?id=<?= $evento['id_evento'] ?>" class="btn btn-danger btn-sm flex-fill" onclick="return confirm('¿Estás seguro de eliminar este evento?');">
                                    <i class="bi bi-trash me-1"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                    <h4>No tienes eventos registrados</h4>
                    <p>Comienza creando tu primer evento para que los estudiantes lo vean.</p>
                    <a href="crear_evento.php" class="btn btn-primary mt-2">Crear Evento Ahora</a>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>

<!-- SCRIPT OBLIGATORIO PARA QUE FUNCIONE EL MENÚ DESPLEGABLE -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
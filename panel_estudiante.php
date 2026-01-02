<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}
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
            --azul-oscuro: #1f5fa8;
            --blanco: #ffffff;
            --gris: #555;
        }

        body {
            background-color: var(--azul-claro);
        }

        .navbar {
            background-color: var(--azul-principal) !important;
        }

        .navbar-brand {
            color: var(--blanco) !important;
            font-weight: bold;
        }

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

        .btn-outline-light:hover {
            background-color: var(--blanco);
            color: var(--azul-principal);
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Eventos ESCOM</a>

        <!-- Zona derecha -->
        <div class="ms-auto d-flex align-items-center gap-3">

            <!-- Botón Mi Perfil -->
            <a href="perfil_estudiante.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-person-circle"></i> Mi perfil
            </a>

            <!-- Rol -->
            <span class="text-white">Estudiante</span>
            <i class="bi bi-mortarboard-fill text-white fs-4"></i>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">

    <h2 class="text-center mb-4">Eventos disponibles</h2>

    <div class="row">

        <!-- EVENTO 1 -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 h-100">
                <h5>Conferencia de Inteligencia Artificial</h5>
                <p class="text-muted mb-1">
                    <i class="bi bi-calendar-event"></i> 25 de mayo 2025
                </p>
                <p class="text-muted">
                    <i class="bi bi-geo-alt"></i> Auditorio ESCOM
                </p>

                <a href="#" class="btn btn-primary mt-auto">Ver detalles</a>
            </div>
        </div>

        <!-- EVENTO 2 -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 h-100">
                <h5>Torneo Deportivo Interescolar</h5>
                <p class="text-muted mb-1">
                    <i class="bi bi-calendar-event"></i> 2 de junio 2025
                </p>
                <p class="text-muted">
                    <i class="bi bi-geo-alt"></i> Canchas ESCOM
                </p>

                <a href="#" class="btn btn-primary mt-auto">Ver detalles</a>
            </div>
        </div>

        <!-- EVENTO 3 -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 h-100">
                <h5>Feria Cultural</h5>
                <p class="text-muted mb-1">
                    <i class="bi bi-calendar-event"></i> 10 de junio 2025
                </p>
                <p class="text-muted">
                    <i class="bi bi-geo-alt"></i> Letras ESCOM
                </p>

                <a href="#" class="btn btn-primary mt-auto">Ver detalles</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>

<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --lavanda: #F3E8FF;
            --morado-medio: #C9A7F5;
            --morado-intenso: #8A2BE2;
            --morado-oscuro: #5A189A;
            --blanco: #FFFFFF;
            --gris: #3A3A3A;
        }

        body {
            background-color: var(--lavanda);
        }

        .navbar {
            background-color: var(--morado-intenso) !important;
        }

        .navbar-brand {
            color: var(--blanco) !important;
            font-weight: bold;
        }

        .avatar-navbar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid var(--blanco);
            object-fit: cover;
            margin-left: 15px;
        }

        .card {
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            border-left: 5px solid var(--morado-intenso);
        }

        .btn-primary {
            background-color: var(--morado-intenso) !important;
            border-color: var(--morado-intenso) !important;
            font-size: 1.2rem;
            padding: 15px 25px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--morado-medio) !important;
            border-color: var(--morado-medio) !important;
            color: var(--gris);
        }

    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand" href="#">Panel Admin</a>

            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-2">Administrador</span>
                <i class="bi bi-person-circle text-white" style="font-size: 2.3rem; margin-left: 10px;"></i>
            </div>

        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="container mt-5">
        <div class="card p-4">

            <h2 class="text-center mb-2">Bienvenido, Administrador</h2>
            <p class="text-center text-muted mb-4">Panel de control del sistema</p>

            <div class="row text-center">

                <div class="col-md-6 mb-3">
                    <a href="registrar_usuario.php" class="btn btn-primary">Registrar Usuario</a>
                </div>

                <div class="col-md-6 mb-3">
                    <a href="logout.php" class="btn btn-primary">Gestionar eventos</a>
                </div>

            </div>

        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
    :root {
        --azul-claro: #EAF2FF;
        --azul-medio: #5DA9FF;
        --azul-principal: #1E6FE8;
        --azul-oscuro: #123C8C;
        --blanco: #FFFFFF;
        --gris: #3A3A3A;
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

    /* Estilo para el link del dropdown en el navbar */
    .nav-user-link {
        color: var(--blanco) !important;
        text-decoration: none;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    
    .nav-user-link:hover {
        opacity: 0.9;
    }

    .card {
        border: none;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        border-left: 5px solid var(--azul-principal);
    }

    .btn-primary {
        background-color: var(--azul-principal) !important;
        border-color: var(--azul-principal) !important;
        font-size: 1.2rem;
        padding: 15px 25px;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: var(--azul-medio) !important;
        border-color: var(--azul-medio) !important;
        color: var(--gris);
    }
</style>

</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand" href="#">Panel Admin</a>

            <!-- Menú de Usuario (Dropdown) -->
            <div class="ms-auto dropdown">
                <a href="#" class="nav-user-link dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2">
                        <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Administrador'; ?>
                    </span>
                    <i class="bi bi-person-circle" style="font-size: 2.3rem;"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><h6 class="dropdown-header">Opciones de cuenta</h6></li>
                    <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Opción de Salir -->
                    <li>
                        <a class="dropdown-item text-danger" href="logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
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
               <a href="gestionar_eventos_admin.php" class="btn btn-primary">Gestionar eventos</a>
                </div>

            </div>

        </div>
    </div>

    <!-- SCRIPT DE BOOTSTRAP (Necesario para el dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
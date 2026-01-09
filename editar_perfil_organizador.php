<?php
session_start();

// Verificar sesión y rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'organizador') {
    header("Location: login.php");
    exit;
}

$nombre_actual = $_SESSION['nombre'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - Organizador</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos Bootstrap -->
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

        /* Navbar Styles */
        .navbar {
            background-color: var(--azul-principal) !important;
        }

        .navbar-brand {
            color: var(--blanco) !important;
            font-weight: bold;
        }

        /* Card Styles */
        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-top: 5px solid var(--azul-principal);
            border-radius: 10px;
        }

        .card-header {
            background-color: var(--blanco);
            border-bottom: 1px solid #f0f0f0;
            padding: 20px;
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--azul-principal) !important;
            border-color: var(--azul-principal) !important;
            padding: 10px 25px;
        }

        .btn-primary:hover {
            background-color: var(--azul-oscuro) !important;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px 25px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg mb-5">
        <div class="container">
            <a class="navbar-brand" href="panel_organizador.php">
                <i class="bi bi-calendar-check me-2"></i>Panel Organizador
            </a>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="text-white d-none d-md-block">
                    <span class="opacity-75 small d-block text-end">Rol</span>
                    <span class="fw-bold">Organizador</span>
                </div>
                <!-- Botón Salir -->
                <a href="logout.php" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0 fw-bold" style="color: var(--gris);">Editar Perfil</h3>
                        <p class="text-muted small mb-0">Actualiza tu información personal</p>
                    </div>
                    
                    <div class="card-body p-4">

                        <!-- ALERTA DE ERROR -->
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'perfil_incompleto'): ?>
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                                <div>
                                    <strong>Atención:</strong> Debes completar tu perfil antes de crear eventos.
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- ALERTA DE ÉXITO -->
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                                <div>
                                    Perfil guardado correctamente.
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- FORMULARIO -->
                        <form action="guardar_perfil_organizador.php" method="POST">
                            
                            <div class="mb-4">
                                <label for="nombre" class="form-label fw-bold text-secondary">Nombre del Organizador</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="nombre"
                                        name="nombre" 
                                        value="<?= htmlspecialchars($nombre_actual) ?>" 
                                        placeholder="Ej. Juan Pérez"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                                
                                <!-- BOTÓN REGRESAR -->
                                <!-- Asegúrate de que 'panel_organizador.php' sea el nombre correcto de tu archivo principal -->
                                <a href="panel_organizador.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Regresar al Panel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
// DATOS DE SESIÓN
// ===============================
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario_sesion = $_SESSION['nombre'] ?? 'Usuario';

// Si es organizador, verificamos que tenga nombre en su perfil
if ($_SESSION['rol'] === 'organizador') {
    $consulta_perfil = "SELECT nombre FROM perfil_organizador WHERE id_usuario = $id_usuario";
    $resultado_perfil = $conexion->query($consulta_perfil);
    $perfil = $resultado_perfil->fetch_assoc();

    if (empty($perfil['nombre'])) {
        header("Location: editar_perfil_organizador.php?error=perfil_incompleto");
        exit;
    }
    $nombre_usuario_sesion = $perfil['nombre'];
}

// ===============================
// PROCESAR ENVÍO DEL FORMULARIO
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria']; // <--- NUEVO CAMPO RECIBIDO
    $fecha = $_POST['fecha'];
    $hora_input = $_POST['hora'];
    $lugar = $_POST['lugar'];
    
    // Formatear hora
    $hora_formateada = date("H:i:s", strtotime($hora_input));
    $organizador = $nombre_usuario_sesion;

    // VALIDACIÓN BÁSICA
    if ($nombre && $categoria && $fecha && $hora_input && $lugar) {
        
        // AGREGAMOS 'categoria' A LA CONSULTA SQL
        $sql = "INSERT INTO eventos (nombre, descripcion, categoria, fecha, hora, lugar, organizador) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        
        // "sssssss" = 7 strings (nombre, desc, cat, fecha, hora, lugar, org)
        $stmt->bind_param("sssssss", $nombre, $descripcion, $categoria, $fecha, $hora_formateada, $lugar, $organizador);
        
        if ($stmt->execute()) {
            $redirect = ($_SESSION['rol'] === 'admin') ? 'panel_admin.php' : 'panel_organizador.php';
            header("Location: $redirect?success=evento_creado");
            exit;
        } else {
            $error = "Error al guardar: " . $conexion->error;
        }
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
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --azul-claro: #EAF2FF;
            --azul-principal: #1E6FE8;
            --azul-oscuro: #123C8C;
            --blanco: #FFFFFF;
            --gris: #3A3A3A;
        }

        body { background-color: var(--azul-claro); }

        .navbar { background-color: var(--azul-principal) !important; }
        .navbar-brand { color: var(--blanco) !important; font-weight: bold; }
        
        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-top: 5px solid var(--azul-principal);
            border-radius: 10px;
        }

        .btn-primary {
            background-color: var(--azul-principal) !important;
            border-color: var(--azul-principal) !important;
        }
        
        .btn-primary:hover { background-color: var(--azul-oscuro) !important; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg mb-5">
    <div class="container">
        <a class="navbar-brand" href="<?= ($_SESSION['rol'] === 'admin') ? 'panel_admin.php' : 'panel_organizador.php' ?>">
            <i class="bi bi-calendar-plus me-2"></i>Gestión de Eventos
        </a>
        
        <div class="ms-auto d-flex align-items-center gap-3">
            <div class="text-white d-none d-md-block text-end">
                <span class="opacity-75 small d-block">Usuario</span>
                <span class="fw-bold"><?= htmlspecialchars($nombre_usuario_sesion) ?></span>
            </div>
            <a href="logout.php" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-right"></i> Salir
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                
                <h3 class="mb-4 text-center" style="color: var(--azul-oscuro);">
                    <i class="bi bi-plus-circle-dotted me-2"></i>Crear Nuevo Evento
                </h3>

                <!-- MENSAJE DE ERROR -->
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <!-- FORMULARIO -->
                <form method="POST">
                    
                    <!-- NOMBRE -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Nombre del evento</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Taller de Robótica" required>
                    </div>

                    <!-- DESCRIPCIÓN -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Detalles..."></textarea>
                    </div>

                    <!-- NUEVO CAMPO: CATEGORÍA -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Categoría</label>
                        <select name="categoria" class="form-select" required>
                            <option value="" selected disabled>Selecciona una categoría...</option>
                            <!-- Asegúrate de que estas opciones coincidan con los intereses de los estudiantes -->
                            <option value="Tecnología">Tecnología</option>
                            <option value="Deportes">Deportes</option>
                            <option value="Cultural">Cultural</option>
                            <option value="Académico">Académico</option>
                            <option value="Social">Social</option>
                            <option value="Ciencia">Ciencia</option>
                        </select>
                    </div>

                    <!-- FECHA Y HORA -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Hora</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-clock"></i></span>
                                <input type="time" name="hora" class="form-control" step="60" required>
                            </div>
                        </div>
                    </div>

                    <!-- LUGAR -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Lugar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" name="lugar" class="form-control" placeholder="Ej. Sala Audiovisual" required>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= ($_SESSION['rol'] === 'admin') ? 'panel_admin.php' : 'panel_organizador.php' ?>" class="btn btn-secondary me-md-2">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-check-lg me-2"></i>Publicar Evento
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
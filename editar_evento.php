<?php
// ===============================
// INICIAR SESIÓN Y VERIFICAR ROL ADMIN
// ===============================
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";

// ===============================
// OBTENER EL ID DEL EVENTO DESDE GET
// ===============================
$id_evento = (int)($_GET['id'] ?? 0);

// ===============================
// CONSULTAR DATOS DEL EVENTO
// ===============================
$sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
$result = $conexion->query($sql);
if ($result->num_rows === 0) die("Evento no encontrado.");

$evento = $result->fetch_assoc();

// ===============================
// GUARDAR CAMBIOS SI SE ENVÍA EL FORMULARIO
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $lugar = $_POST['lugar'];
    $descripcion = $_POST['descripcion'];

    // Actualizar la base de datos
    $sql_update = "
        UPDATE eventos
        SET nombre='$nombre', fecha='$fecha', lugar='$lugar', descripcion='$descripcion'
        WHERE id_evento = $id_evento
    ";
    $conexion->query($sql_update);

    // Redirigir de nuevo a la gestión de eventos con mensaje de éxito
    header("Location: gestionar_eventos_admin.php?success=evento_actualizado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Evento</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <!-- Card con formulario -->
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Editar Evento</h2>

        <!-- Formulario de edición -->
        <form method="POST">

            <!-- Nombre del evento -->
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($evento['nombre']) ?>" required>
            </div>

            <!-- Fecha del evento -->
            <div class="mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" value="<?= htmlspecialchars($evento['fecha']) ?>" required>
            </div>

            <!-- Lugar del evento -->
            <div class="mb-3">
                <label class="form-label">Lugar</label>
                <input type="text" class="form-control" name="lugar" value="<?= htmlspecialchars($evento['lugar']) ?>" required>
            </div>

            <!-- Descripción del evento -->
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="5" required><?= htmlspecialchars($evento['descripcion']) ?></textarea>
            </div>

            <!-- Botones: Cancelar / Guardar -->
            <div class="d-flex justify-content-between">
                <a href="gestionar_eventos_admin.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
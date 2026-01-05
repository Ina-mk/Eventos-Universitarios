<?php
// ===============================
// editar_evento.php
// Permite al admin o al organizador editar eventos
// Los organizadores solo pueden editar sus propios eventos
// ===============================

// ===============================
// INICIAR SESIÓN Y VERIFICAR ROL
// ===============================
session_start();

// Solo admin y organizador pueden acceder
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','organizador'])) {
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
// SI EL USUARIO ES ORGANIZADOR, VERIFICAR QUE EL EVENTO LE PERTENEZCA
// ===============================
if ($_SESSION['rol'] === 'organizador') {
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener el nombre del organizador
    $res = $conexion->query("SELECT nombre FROM perfil_organizador WHERE id_usuario = $id_usuario");
    $org = $res->fetch_assoc()['nombre'] ?? '';

    if ($evento['organizador'] !== $org) {
        die("No tienes permiso para editar este evento.");
    }
}

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
    if ($_SESSION['rol'] === 'admin') {
        header("Location: gestionar_eventos_admin.php?success=evento_actualizado");
    } else {
        header("Location: panel_organizador.php?success=evento_actualizado");
    }
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
                <?php if($_SESSION['rol'] === 'admin'): ?>
                    <a href="gestionar_eventos_admin.php" class="btn btn-secondary">Cancelar</a>
                <?php else: ?>
                    <a href="panel_organizador.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

        </form>

        <!-- ===============================
             SECCIÓN: ESTUDIANTES INTERESADOS
             SOLO PARA ORGANIZADORES
             =============================== -->
        <?php if($_SESSION['rol'] === 'organizador'): ?>
            <h4 class="mt-5">Estudiantes interesados en esta categoría</h4>
            <ul class="list-group mb-3">
                <?php
                // Suponiendo que hay columna 'categoria' en eventos
                $categoria = $evento['categoria'] ?? '';

                // Buscar estudiantes cuyo campo 'intereses' incluya la categoría del evento
                $res_est = $conexion->query("
                    SELECT nombre, correo 
                    FROM perfil_estudiante 
                    WHERE intereses LIKE '%$categoria%'
                ");

                if($res_est->num_rows > 0){
                    while($est = $res_est->fetch_assoc()){
                        echo "<li class='list-group-item'>{$est['nombre']} ({$est['correo']})</li>";
                    }
                } else {
                    echo "<li class='list-group-item text-muted'>No hay estudiantes interesados aún.</li>";
                }
                ?>
            </ul>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
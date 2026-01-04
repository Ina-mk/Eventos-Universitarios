<?php
// ===============================
// INICIAR SESIÓN Y VALIDAR ADMIN
// ===============================
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BD
// ===============================
include "config/conexion.php";

// ===============================
// CONSULTAR TODOS LOS EVENTOS
// ===============================
$consulta = "
    SELECT id_evento, nombre, fecha, lugar, organizador
    FROM eventos
    ORDER BY fecha ASC
";

$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestión de Eventos</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Organizador</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>

            <?php while ($evento = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($evento['nombre']) ?></td>
                    <td><?= htmlspecialchars($evento['fecha']) ?></td>
                    <td><?= htmlspecialchars($evento['lugar']) ?></td>
                    <td><?= htmlspecialchars($evento['organizador']) ?></td>
                    <td class="text-center">
                        <a 
                            href="ver_evento.php?id=<?= $evento['id_evento'] ?>"
                            class="btn btn-primary btn-sm mb-1"
                        >
                            Ver detalles
                        </a>
                        <a 
                            href="editar_evento.php?id=<?= $evento['id_evento'] ?>"
                            class="btn btn-secondary btn-sm mb-1"
                        >
                            Editar
                        </a>
                        <a 
                            href="eliminar_evento.php?id=<?= $evento['id_evento'] ?>"
                            class="btn btn-danger btn-sm mb-1"
                            onclick="return confirm('¿Seguro que deseas eliminar este evento?');"
                        >
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No hay eventos registrados.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="panel_admin.php" class="btn btn-secondary">Regresar al panel</a>
    </div>
</div>

</body>
</html>
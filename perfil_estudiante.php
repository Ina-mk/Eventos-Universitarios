<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}

include "config/conexion.php";

$id_usuario = $_SESSION['id_usuario'];

// ===============================
// CONSULTAR DATOS DEL ESTUDIANTE
// ===============================
$consulta = "
SELECT 
    u.nombre,
    u.correo,
    u.boleta,
    p.carrera,
    p.semestre,
    p.intereses
FROM usuarios u
INNER JOIN perfil_estudiante p 
    ON u.id_usuario = p.id_usuario
WHERE u.id_usuario = $id_usuario
";

$resultado = $conexion->query($consulta);
$estudiante = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eaf2ff;
        }
        .card {
            border-left: 5px solid #2b90e2;
            box-shadow: 0 3px 10px rgba(0,0,0,.15);
        }
    </style>
</head>

<body>

<?php if (isset($_GET['success'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success text-center">
            <i class="bi bi-check-circle-fill"></i>
            Perfil actualizado correctamente
        </div>
    </div>
<?php endif; ?>


<div class="container mt-5">
    <div class="card p-4">

        <h2 class="text-center mb-3">
            <?php echo $estudiante['nombre']; ?>
        </h2>

        <p class="text-center text-muted">
            <?php echo $estudiante['carrera'] ?? 'Carrera no registrada'; ?>
        </p>

        <hr>

        <h5>Información personal</h5>

        <p><strong>Correo:</strong> <?php echo $estudiante['correo']; ?></p>
        <p><strong>Boleta:</strong> <?php echo $estudiante['boleta']; ?></p>
        <p><strong>Semestre:</strong> <?php echo $estudiante['semestre'] ?? 'No registrado'; ?></p>
        <p><strong>Intereses:</strong> <?php echo $estudiante['intereses'] ?? 'No registrados'; ?></p>

       <div class="d-flex justify-content-center gap-3 mt-4">
          <a href="panel_estudiante.php" class="btn btn-secondary">
        Volver al panel
        </a>

    <a href="editar_perfil_estudiante.php" class="btn btn-primary">
        Editar perfil
    </a>
</div>

    </div>
</div>

</body>
</html>


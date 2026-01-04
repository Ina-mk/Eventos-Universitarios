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

$intereses_actuales = explode(',', $estudiante['intereses'] ?? '');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h3 class="text-center mb-4">Editar Perfil</h3>

        <!-- ===============================
             MENSAJES DE ERROR
        =============================== -->
        <?php
        if (isset($_GET['error'])) {
            $mensajes = [
                "nombre" => "El nombre no puede estar vacío",
                "correo" => "El correo no es válido",
                "boleta" => "La boleta debe contener solo números",
                "carrera" => "Carrera inválida",
                "semestre" => "El semestre debe estar entre 1 y 8",
                "intereses" => "Selecciona al menos un interés"
            ];

            if (isset($mensajes[$_GET['error']])) {
                echo '
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    ' . $mensajes[$_GET['error']] . '
                </div>';
            }
        }
        ?>

        <!-- ===============================
             FORMULARIO
        =============================== -->
        <form action="guardar_perfil_estudiante.php" method="POST">

            <!-- DATOS PERSONALES -->
            <h5>Datos personales</h5>

            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control"
                       value="<?= htmlspecialchars($estudiante['nombre']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control"
                       value="<?= htmlspecialchars($estudiante['correo']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Boleta</label>
                <input
                    type="text"
                    name="boleta"
                    class="form-control"
                    value="<?= htmlspecialchars($estudiante['boleta']) ?>"
                    maxlength="10"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    required
                >
            </div>

            <hr>

            <!-- PERFIL ACADÉMICO -->
            <h5>Perfil académico</h5>

            <div class="mb-3">
                <label class="form-label">Carrera</label>
                <select name="carrera" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="ISC" <?= $estudiante['carrera']=='ISC'?'selected':'' ?>>Ingeniería en Sistemas Computacionales</option>
                    <option value="IC" <?= $estudiante['carrera']=='IC'?'selected':'' ?>>Ingeniería en Computación</option>
                    <option value="LCD" <?= $estudiante['carrera']=='LCD'?'selected':'' ?>>Licenciatura en Ciencia de Datos</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Semestre</label>
                <select name="semestre" class="form-select" required>
                    <option value="">Selecciona semestre</option>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i ?>" <?= $estudiante['semestre']==$i?'selected':'' ?>>
                            <?= $i ?>°
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <hr>

            <!-- INTERESES -->
            <h5>Intereses</h5>

            <?php
            $lista_intereses = [
                "Inteligencia Artificial",
                "Ciencia",
                "Tecnología",
                "Arte",
                "Deportes",
                "Clubs estudiantiles",
                "Empresas",
                "Intercambios",
                "Bolsa de trabajo",
                "Concursos",
                "Oportunidades estudiantiles",
                "Emprendimiento",
                "Investigación",
                "Desarrollo de software",
                "Hardware y electrónica"
            ];

            foreach ($lista_intereses as $interes):
            ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]"
                           value="<?= $interes ?>"
                           <?= in_array($interes, $intereses_actuales) ? 'checked' : '' ?>>
                    <label class="form-check-label"><?= $interes ?></label>
                </div>
            <?php endforeach; ?>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar cambios
                </button>
                <a href="perfil_estudiante.php" class="btn btn-secondary ms-2">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

</body>
</html>

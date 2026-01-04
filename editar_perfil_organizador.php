<?php
session_start();

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
</head>
<body>

<h2>Editar perfil</h2>
<?php if (isset($_GET['error']) && $_GET['error'] == 'perfil_incompleto'): ?>
    <div style="color:#856404; background:#fff3cd; padding:10px; border:1px solid #ffeeba; margin-bottom:15px;">
        ⚠️ Debes completar tu perfil antes de crear eventos.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div style="color:#155724; background:#d4edda; padding:10px; border:1px solid #c3e6cb; margin-bottom:15px;">
        ✅ Perfil guardado correctamente.
    </div>
<?php endif; ?>


<form action="guardar_perfil_organizador.php" method="POST">

    <label>Nombre:</label><br>
    <input 
        type="text" 
        name="nombre" 
        value="<?= htmlspecialchars($nombre_actual) ?>" 
        placeholder="Escribe tu nombre"
        required
    ><br><br>

    <button type="submit">Guardar</button>

</form>

</body>
</html>

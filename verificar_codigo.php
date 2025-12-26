<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar código</title>
</head>
<body>

<!-- Título principal -->
<h2>Verificar código de recuperación</h2>

<!-- 
    Si viene un error por la URL (ej: ?error=invalido),
    mostramos un mensaje en rojo
-->
<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">
        <?php
        // Mensaje si el código es incorrecto o ya expiró
        if ($_GET['error'] == 'invalido') {
            echo "Código incorrecto o expirado";
        }
        ?>
    </p>
<?php endif; ?>

<!-- 
    Formulario para enviar el código al archivo procesar_codigo.php
-->
<form action="procesar_codigo.php" method="POST">

    <!-- Campo para escribir el código -->
    <label>Código de recuperación:</label><br>
    <input type="text" name="codigo" required maxlength="6"><br><br>

    <!-- Botón para verificar -->
    <button type="submit">Verificar código</button>

</form>

</body>
</html>

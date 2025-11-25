<?php
session_start();

// 1. Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "eventos_db");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 2. Recibir datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// 3. Buscar el usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $usuario = $resultado->fetch_assoc();
    
    // 4. Verificar contraseña encriptada
    if (password_verify($contraseña, $usuario['contraseña'])) {

        // Crear variables de sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['rol'] = $usuario['rol'];

        // 5. Redirigir según el rol
        if ($usuario['rol'] == 'admin') {
            header("Location: panel_admin.php");
        } elseif ($usuario['rol'] == 'organizador') {
            header("Location: panel_organizador.php");
        } else {
            header("Location: panel_estudiante.php");
        }

        exit;

    } else {
        echo "Contraseña incorrecta.";
    }

} else {
    echo "Correo no encontrado.";
}

$conexion->close();
?>

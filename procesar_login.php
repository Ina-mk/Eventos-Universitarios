<?php
session_start();

// 1. Conectar a la base de datos
// Lo cambie para que no volvieramos a escribir lo mismo y cambiar varios archivos
require 'config/conexion.php';

// 2. Recibir datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// 3. Buscar el usuario DE FORMA SEGURA (Prepared Statement)
// Preparamos la plantilla de la consulta con un signo de interrogación (?)
$sql = "SELECT id_usuario, correo, contraseña, rol FROM usuarios WHERE correo = ?";

$stmt = $conexion->prepare($sql); // Preparamos la sentencia

// Vinculamos el parámetro (la "s" significa que es un String)
$stmt->bind_param("s", $correo); 

$stmt->execute(); // Ejecutamos la consulta

$resultado = $stmt->get_result(); // Obtenemos el resultado

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

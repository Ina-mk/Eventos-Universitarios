<?php
// Conectar con la bd
$conexion = new mysqli("localhost", "root", "", "eventos_db");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];
$rol = $_POST['rol'];

// Validar que el correo sea institucional
if (!str_ends_with($correo, '@alumno.ipn.mx')) {
    die("Error: Solo se permiten correos institucionales (@alumno.ipn.mx).");
}

// Encriptar la contraseña 
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (correo, contraseña, rol) 
        VALUES ('$correo', '$contraseña_hash', '$rol')";

if ($conexion->query($sql) === TRUE) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error al registrar: " . $conexion->error;
}

$conexion->close();
?>

<?php
session_start();
include "config/conexion.php";

// Recibir nombre del formulario
$nombre = $_POST['nombre'] ?? '';

// Validar que no esté vacío
if (empty($nombre)) {
    header("Location: editar_perfil_organizador.php?error=1");
    exit;
}

// Guardar en la tabla perfil_organizador
$id_usuario = $_SESSION['id_usuario'];

// Primero revisamos si ya existe un registro para este usuario
$consulta = "SELECT * FROM perfil_organizador WHERE id_usuario = $id_usuario";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    // Ya existe → actualizar
    $sql = "UPDATE perfil_organizador SET nombre = '$nombre' WHERE id_usuario = $id_usuario";
} else {
    // No existe → insertar
    $sql = "INSERT INTO perfil_organizador (id_usuario, nombre) VALUES ($id_usuario, '$nombre')";
}

if ($conexion->query($sql) === TRUE) {
    // Actualizar la sesión
    $_SESSION['nombre'] = $nombre;

    // Redirigir con mensaje de éxito
    header("Location: editar_perfil_organizador.php?success=1");
    exit;
} else {
    echo "Error al guardar el nombre: " . $conexion->error;
}
?>


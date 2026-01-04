<?php
// ===============================
// INICIAR SESIÓN Y VALIDAR ROL
// ===============================
session_start();

// Solo los organizadores pueden guardar eventos
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'organizador') {
    header("Location: login.php");
    exit;
}

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";
// ===============================
// OBTENER NOMBRE DEL ORGANIZADOR
// ===============================
$id_usuario = $_SESSION['id_usuario'];

$consulta_org = "
    SELECT nombre 
    FROM perfil_organizador
    WHERE id_usuario = $id_usuario
";

$resultado_org = $conexion->query($consulta_org);
$datos_org = $resultado_org->fetch_assoc();

$organizador = $datos_org['nombre'];

// ===============================
// OBTENER DATOS DEL FORMULARIO
// ===============================
$nombre_evento = trim($_POST['nombre_evento'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$fecha = $_POST['fecha'] ?? '';
$lugar = trim($_POST['lugar'] ?? '');
$organizador = $_SESSION['nombre']; // nombre del organizador desde sesión

// ===============================
// VALIDACIONES
// ===============================
if ($nombre_evento === '') {
    header("Location: crear_evento.php?error=nombre");
    exit;
}

if ($descripcion === '') {
    header("Location: crear_evento.php?error=descripcion");
    exit;
}

if ($fecha === '') {
    header("Location: crear_evento.php?error=fecha");
    exit;
}

if ($lugar === '') {
    header("Location: crear_evento.php?error=lugar");
    exit;
}

// ===============================
// GUARDAR EVENTO EN LA BASE DE DATOS
// ===============================
$consulta = $conexion->prepare("
    INSERT INTO eventos (nombre_evento, descripcion, fecha, lugar, organizador)
    VALUES (?, ?, ?, ?, ?)
");
$consulta->bind_param("sssss", $nombre_evento, $descripcion, $fecha, $lugar, $organizador);

if ($consulta->execute()) {
    // ===============================
    // SI SE GUARDA CORRECTAMENTE
    // ===============================
    header("Location: panel_organizador.php?success=evento_guardado");
    exit;
} else {
    // ===============================
    // SI HAY ERROR AL GUARDAR
    // ===============================
    header("Location: crear_evento.php?error=guardar");
    exit;
}

?>


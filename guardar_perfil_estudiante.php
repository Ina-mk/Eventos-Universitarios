<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}

include "config/conexion.php";

$id_usuario = $_SESSION['id_usuario'];

// ===============================
// RECIBIR DATOS
// ===============================
$nombre   = trim($_POST['nombre']);
$correo   = trim($_POST['correo']);
$boleta   = trim($_POST['boleta']);
$carrera  = $_POST['carrera'];
$semestre = $_POST['semestre'];
$intereses = $_POST['intereses'] ?? [];

// ===============================
// VALIDACIONES
// ===============================
if ($nombre == "") {
    header("Location: editar_perfil_estudiante.php?error=nombre");
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: editar_perfil_estudiante.php?error=correo");
    exit;
}

if (!ctype_digit($boleta)) {
    header("Location: editar_perfil_estudiante.php?error=boleta");
    exit;
}

$permitidas = ['ISC','IC','LCD'];
if (!in_array($carrera, $permitidas)) {
    header("Location: editar_perfil_estudiante.php?error=carrera");
    exit;
}

if ($semestre < 1 || $semestre > 8) {
    header("Location: editar_perfil_estudiante.php?error=semestre");
    exit;
}

if (count($intereses) == 0) {
    header("Location: editar_perfil_estudiante.php?error=intereses");
    exit;
}

// Convertir intereses a texto
$intereses_txt = implode(',', $intereses);

// ===============================
// ACTUALIZAR TABLA USUARIOS
// ===============================
$conexion->query("
    UPDATE usuarios SET
        nombre = '$nombre',
        correo = '$correo',
        boleta = '$boleta'
    WHERE id_usuario = $id_usuario
");

// ===============================
// ACTUALIZAR PERFIL_ESTUDIANTE
// ===============================
$conexion->query("
    UPDATE perfil_estudiante SET
        carrera = '$carrera',
        semestre = '$semestre',
        intereses = '$intereses_txt'
    WHERE id_usuario = $id_usuario
");

// ===============================
// REDIRIGIR CON ÉXITO
// ===============================
header("Location: perfil_estudiante.php?success=1");
exit;

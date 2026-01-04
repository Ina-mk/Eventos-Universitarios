<?php
// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";

// ===============================
// OBTENER ID DEL EVENTO DESDE GET
// ===============================
$id = $_GET['id'];

// ===============================
// CONSULTA DEL EVENTO
// ===============================
$resultado = $conexion->query("SELECT * FROM eventos WHERE id_evento=$id");
$evento = $resultado->fetch_assoc();
?>

<h2><?= $evento['nombre'] ?></h2>
<p><?= $evento['descripcion'] ?></p>
<p><i class="bi bi-calendar-event"></i> <?= date("d/m/Y", strtotime($evento['fecha'])) ?></p>
<p><i class="bi bi-clock"></i> <?= date("H:i", strtotime($evento['hora'])) ?></p>
<p><i class="bi bi-geo-alt"></i> <?= $evento['lugar'] ?></p>
<p><i class="bi bi-person"></i> Organizador: <?= $evento['organizador'] ?></p>

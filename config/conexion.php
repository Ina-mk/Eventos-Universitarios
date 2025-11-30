<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "eventos_db"; 

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Revisar si hay error
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

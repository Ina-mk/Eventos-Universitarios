<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "eventos_db"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Revisar si hay error
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

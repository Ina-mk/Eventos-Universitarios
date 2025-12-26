<?php
// ===============================
// USO DE PHPMailer
// ===============================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Archivos necesarios de PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// ===============================
// CONEXIÓN A LA BASE DE DATOS
// ===============================
include "config/conexion.php";

// ===============================
// OBTENER EL CORREO DEL FORMULARIO
// ===============================
$correo = $_POST['correo'];

// ===============================
// BUSCAR SI EL CORREO EXISTE
// ===============================
$consulta = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($consulta);

// Si el correo NO existe → regresar con error
if ($resultado->num_rows == 0) {
    header("Location: recuperar_contraseña.php?error=no_encontrado");
    exit;
}

// ===============================
// GENERAR CÓDIGO Y FECHA DE EXPIRACIÓN
// ===============================

// Código aleatorio de 6 dígitos
$codigo = random_int(100000, 999999);

// El código expira en 15 minutos
$expira = date("Y-m-d H:i:s", strtotime("+15 minutes"));

// ===============================
// GUARDAR CÓDIGO EN LA BASE DE DATOS
// ===============================
$actualizar = "
    UPDATE usuarios 
    SET codigo_recuperacion = '$codigo',
        codigo_expira = '$expira'
    WHERE correo = '$correo'
";

$conexion->query($actualizar);

// ===============================
// ENVIAR CORREO CON EL CÓDIGO
// ===============================
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP (Gmail)
    $mail->isSMTP();
    
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'escomeventos@gmail.com';
    $mail->Password = 'jkgr wjbc wtgj dwis'; // contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // IMPORTANTE PARA ACENTOS
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
];

    // Remitente y destinatario
    $mail->setFrom('escomeventos@gmail.com', 'ESCOM Eventos');
    $mail->addAddress($correo);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Código de recuperación';
    $mail->Body = "
        <h3>Recuperación de contraseña</h3>
        <p>Tu código es:</p>
        <h2>$codigo</h2>
        <p>Este código expira en 15 minutos.</p>
    ";

    // Enviar correo
    $mail->send();

    // Redirigir a la pantalla para ingresar el código
    header("Location: verificar_codigo.php");
    exit;

} catch (Exception $e) {
    echo "Error al enviar correo: {$mail->ErrorInfo}";
}
?>

<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método no permitido.';
    exit;
}

// Validación de correo electrónico
function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Capturar y sanitizar los datos del formulario
$name = isset($_POST['form_name']) ? htmlspecialchars(trim($_POST['form_name'])) : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Verificar campos requeridos
if (!$name || !$email || !$phone || !$message) {
    echo 'Todos los campos son obligatorios.';
    exit;
}

// Verificar formato de correo electrónico
if (!isEmail($email)) {
    echo 'Dirección de correo no válida.';
    exit;
}

// Configurar detalles del correo
$to = 'alfonsovengoechea@gmail.com'; // Cambia a tu correo
$subject = "Nueva reserva de: $name";
$body = "
    Nombre: $name
    Email: $email
    Teléfono: $phone
    Mensaje: $message
";
$headers = "From: $email\r\nReply-To: $email\r\n";

// Enviar el correo
if (mail($to, $subject, $body, $headers)) {
    echo 'Reserva enviada correctamente.';
} else {
    echo 'Hubo un problema al enviar la reserva.';
}
?>

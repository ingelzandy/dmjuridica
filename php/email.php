<?php
// Incluir los archivos necesarios de PHPMailer
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

// Crear una instancia de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    //Configuración del servidor SMTP
    $mail->isSMTP();                                           // Enviar usando SMTP
    $mail->Host = 'smtp.gmail.com';                              // Servidor SMTP de Gmail (puedes usar otro)
    $mail->SMTPAuth = true;                                      // Activar autenticación SMTP
    $mail->Username = 'alcsecopii@gmail.com';                     // Tu dirección de correo
    $mail->Password = 'omww qfqz euvb cmmr';                            // Tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Cifrado TLS
    $mail->Port = 587;                                           // Puerto SMTP de Gmail

    // Remitente y destinatarios
    $mail->setFrom('alcsecopii@gmail.com', 'Alerta SECOP II');
    $mail->addAddress('contratacion@saravena-arauca.gov.co', 'Contratación'); // Destinatario

    // Contenido del correo
    $mail->isHTML(true);                                          // Establecer el formato como HTML
    $mail->Subject = 'Prueba de alerta';
    $mail->Body    = 'Pendiente por publicar';

    // Enviar el correo
    $mail->send();
    echo 'El mensaje ha sido enviado con éxito.';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
}
?>
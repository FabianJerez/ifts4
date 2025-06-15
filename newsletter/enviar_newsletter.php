<?php
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/config.php';
require 'includes/utils.php';
require 'includes/PHPMailer/PHPMailer.php';
require 'includes/PHPMailer/Exception.php';
require 'includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Solo acceso para usuarios administrativos
if (!esAdministrativo()) {
    exit("Acceso denegado");
}

// Ejecutar baja automática antes de enviar
verificarYDarBajaAutomatica($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    // Obtener los usuarios suscriptos y activos
    $stmt = $conn->prepare("SELECT email, unsuscribe_token FROM usuarios WHERE newsletter = 1 AND activo = 1");
    $stmt->execute();
    $destinatarios = $stmt->fetchAll();

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP para Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = GMAIL_USER;
        $mail->Password = GMAIL_APP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Corrección para evitar errores de verificación SSL en XAMPP/local
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ]
        ];

        $mail->setFrom(GMAIL_USER, 'IFTS 4');
        $mail->isHTML(true);
        $mail->Subject = $asunto;

        // Enviar uno a uno con enlace de desuscripción
        foreach ($destinatarios as $d) {
            $mail->clearAllRecipients();
            $mail->addAddress($d['email']);

            $enlaceBaja = "http://localhost/ifts4/newsletter/newsletter_unsuscribe.php?token=" . $d['unsuscribe_token'];//en el caso de la pagina web sera 

            $mail->Body = nl2br($mensaje) . "<hr><p style='font-size: small;'>Si no queres recibir mas correos, podes <a href='$enlaceBaja'>desuscribirte aqui</a>.</p>";

            $mail->send();
        }

        echo "Newsletter enviado a " . count($destinatarios) . " suscriptores.";
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}
?>

<!-- Formulario de redacción del newsletter -->
<h2>Enviar Newsletter</h2>
<form method="POST">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>

    <label>Mensaje:</label><br>
    <textarea name="mensaje" rows="10" style="width: 100%;" required></textarea><br><br>

    <button type="submit">Enviar Newsletter</button>
</form>



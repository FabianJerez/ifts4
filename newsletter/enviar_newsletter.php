<?php
$modo_embebido = $modo_embebido ?? false;

$modo_embebido = $modo_embebido ?? false;

if (!$modo_embebido) {
    require 'includes/db.php';
    require_once __DIR__ . '/auth.php';
    require 'includes/config.php';
    require 'includes/utils.php';
} else {
    // Si está embebido y utils.php aún no fue cargado
    if (!function_exists('verificarYDarBajaAutomatica')) {
        require 'includes/utils.php';
    }
    if (!defined('GMAIL_USER')) {
        require 'includes/config.php';
    }
}

require_once 'includes/PHPMailer/PHPMailer.php';
require_once 'includes/PHPMailer/Exception.php';
require_once 'includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!esAdministrativo()) {
    exit("Acceso denegado");
}

// Baja lógica automática al ingresar
verificarYDarBajaAutomatica($conn);

// Al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    $stmt = $conn->prepare("SELECT email, unsuscribe_token FROM usuarios WHERE newsletter = 1 AND activo = 1");
    $stmt->execute();
    $destinatarios = $stmt->fetchAll();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = GMAIL_USER;
        $mail->Password = GMAIL_APP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];

        $mail->setFrom(GMAIL_USER, 'IFTS 4');
        $mail->isHTML(true);
        $mail->Subject = $asunto;

        foreach ($destinatarios as $d) {
            $mail->clearAllRecipients();
            $mail->addAddress($d['email']);

            $enlaceBaja = "http://localhost/ifts4/newsletter/newsletter_unsuscribe.php?token=" . $d['unsuscribe_token'];

            $mail->Body = nl2br($mensaje) . "<hr><p style='font-size: small;'>Si no queres recibir mas correos, podes <a href='$enlaceBaja'>desuscribirte aqui</a>.<br><br>Atte. Bedelia IFTS 4</p>";

            $mail->send();
        }

        echo "<p>Newsletter enviado a <strong>" . count($destinatarios) . "</strong> suscriptores.</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error al enviar: {$mail->ErrorInfo}</p>";
    }
}
?>

<h2>Enviar Newsletter</h2>
<form method="POST">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>

    <label>Mensaje:</label><br>
    <textarea name="mensaje" rows="10" style="width: 100%;" required></textarea><br><br>

    <button type="submit">Enviar Newsletter</button>
</form>

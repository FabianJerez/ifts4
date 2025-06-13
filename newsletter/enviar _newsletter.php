<?php
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/PHPMailer/PHPMailer.php';
require 'includes/PHPMailer/Exception.php';
require 'includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (getUserRole() !== 'administrativo') {
    exit("Acceso denegado");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    $result = $conn->query("SELECT email FROM usuarios WHERE newsletter = 1 AND activo = 1");

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'likid88@gmail.com';
        $mail->Password = 'Intelb819';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('likid88@gmail.com', 'IFTS 4');
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = nl2br($mensaje);

        while ($row = $result->fetch_assoc()) {
            $mail->addBCC($row['email']);
        }

        $mail->send();
        echo "✅ Newsletter enviado.";
    } catch (Exception $e) {
        echo "❌ Error: {$mail->ErrorInfo}";
    }
}
?>

<!-- Formulario HTML -->
<form method="POST">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>
    <label>Mensaje:</label><br>
    <textarea name="mensaje" rows="10" required></textarea><br><br>
    <button type="submit">Enviar Newsletter</button>
</form>

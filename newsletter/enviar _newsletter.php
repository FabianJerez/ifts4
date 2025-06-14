<?php
require 'includes/db.php';                     // Conexión PDO a la base 'ifts4'
require 'includes/auth.php';                   // Manejo de sesión y roles
require 'includes/config.php';
require 'includes/utils.php';                  // Incluye la baja automática
require 'includes/PHPMailer/PHPMailer.php';    // PHPMailer core
require 'includes/PHPMailer/Exception.php';    // PHPMailer manejo de errores
require 'includes/PHPMailer/SMTP.php';         // PHPMailer SMTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verifica que solo un usuario administrativo acceda
if (!esAdministrativo()) {
    exit("Acceso denegado");
}

// Baja lógica automática antes de enviar
verificarYDarBajaAutomatica($conn);

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    // Obtener destinatarios con newsletter activo
    $stmt = $conn->prepare("SELECT email, unsuscribe_token FROM usuarios WHERE newsletter = 1 AND activo = 1");
    $stmt->execute();
    $destinatarios = $stmt->fetchAll();

    $mail = new PHPMailer(true);

    try {
        // Configuración de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = GMAIL_USER;                   // Recomendación: usar archivo config.php
        $mail->Password = GMAIL_APP_PASSWORD;        // Contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom(GMAIL_USER, 'IFTS 4');
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = nl2br($mensaje);

        // Agregar todos como copia oculta (BCC)
        foreach ($destinatarios as $d) {
            $enlaceBaja = 'https://ifts4.edu.ar/newsletter/newsletter_unsuscribe.php?token=' . $d['unsuscribe_token'];      //enlace para desuscribirse

            $mensajePersonalizado = nl2br($mensaje) . "<hr><p style='font-size: small;'>Si no querés recibir más correos, podés <a href='$enlaceBaja'>desuscribirte aquí</a>.</p>";

            $mail->clearAllRecipients(); // limpia antes de enviar a cada uno
            $mail->addAddress($d['email']);
            $mail->Body = $mensajePersonalizado;
            $mail->send();
        }


        $mail->send();
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


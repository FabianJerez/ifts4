<?php
require 'includes/db.php';                  // Conexión a la base de datos
require 'includes/auth.php';                // Funciones de autenticación y control de rol
require 'includes/utils.php';               // Funciones utilitarias (como la baja automática)
require 'includes/config.php';
require 'includes/PHPMailer/PHPMailer.php'; // Clase principal de PHPMailer
require 'includes/PHPMailer/Exception.php'; // Manejo de errores de PHPMailer
require 'includes/PHPMailer/SMTP.php';      // Clase para configurar conexión SMTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!esAdministrativo()) {   //control de acceso por rol
    exit("Acceso denegado");
}

// Baja automática antes de recolectar destinatarios
verificarYDarBajaAutomatica($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    $result = $conn->query("SELECT email FROM usuarios WHERE newsletter = 1 AND activo = 1"); //consulta a la BD

    //Configuración de PHPMailer
    $mail = new PHPMailer(true);                   // Se activa el modo "lanzar excepciones" para capturar errores

    try {
        $mail->isSMTP();                           // Indicamos que usaremos SMTP
        $mail->Host = 'smtp.gmail.com';            // Servidor de Gmail
        $mail->SMTPAuth = true;                    // Autenticación requerida
        $mail->Username = GMAIL_USER;     // email del administrador
        $mail->Password = GMAIL_APP_PASSWORD;   //La contraseña de aplicación generada          
        $mail->SMTPSecure = 'tls';                 // Cifrado TLS
        $mail->Port = 587;                         // Puerto de Gmail (TLS)
        //configuracion del mensaje
        $mail->setFrom('likid88@gmail.com', 'IFTS 4');  // Remitente
        $mail->isHTML(true);                            // Indica que el mensaje es HTML
        $mail->Subject = $asunto;
        $mail->Body    = nl2br($mensaje);               // Convierte saltos de línea en <br> para HTML

        //Agregar destinatarios como CCO (copia oculta) para que cada estudiante no vea los otros correos
        while ($row = $result->fetch_assoc()) {
            $mail->addBCC($row['email']);
        }

        $mail->send();                          //Enviar el correo
        echo "Newsletter enviado.";
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>

<!-- Formulario HTML para que el administrativo redacte y envíe el newsletter. -->
<form method="POST">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>
    <label>Mensaje:</label><br>
    <textarea name="mensaje" rows="10" required></textarea><br><br>
    <button type="submit">Enviar Newsletter</button>
</form>

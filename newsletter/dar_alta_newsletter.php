<?php
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/utils.php';

if (!esAdministrativo()) {
    exit("Acceso denegado");
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT newsletter FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id]);
    $estado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($estado && $estado['newsletter'] == 1) {
        echo "El usuario ya está suscripto al newsletter.";
    } else {
        $nuevo_token = generarToken();
        $stmt = $conn->prepare("UPDATE usuarios SET newsletter = 1, unsuscribe_token = ?, fecha_suscripcion = NOW() WHERE id_usuario = ?");
        $stmt->execute([$nuevo_token, $id]);
        echo "El Usuario se suscribio al newsletter correctamente.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
<br><br>
<a href="usuarios.php">Volver al listado</a>


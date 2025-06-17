<?php
$modo_embebido = true;
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/utils.php';

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
        header("Location: panel.php?seccion=usuarios");
        exit;
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>

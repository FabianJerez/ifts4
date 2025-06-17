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
    $estado = $stmt->fetch();

    if ($estado && $estado['newsletter'] == 0) {
        echo "El usuario ya fue dado de baja del newsletter.";
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET newsletter = 0, unsuscribe_token = NULL WHERE id_usuario = ?");
        $stmt->execute([$id]);
        header("Location: panel.php?seccion=usuarios");
        exit;
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>

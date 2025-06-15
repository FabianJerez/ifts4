<?php
require 'includes/db.php';
require 'includes/auth.php';

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
        echo "El Usuario se desuscribio del newsletter correctamente.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
<br><br>
<a href="usuarios.php">Volver al listado</a>


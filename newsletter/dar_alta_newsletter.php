<?php
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/utils.php'; // para generarToken()

if (!esAdministrativo()) {
    exit("Acceso denegado");
}

$id = $_GET['id'] ?? null;

if ($id) {
    $nuevo_token = generarToken();  // token para el enlace de desuscripción

    $stmt = $conn->prepare("UPDATE usuarios SET newsletter = 1, unsuscribe_token = ? WHERE id_usuario = ?");
    $stmt->execute([$nuevo_token, $id]);

    echo "Usuario vuelto a suscribir al newsletter correctamente.";
} else {
    echo "ID de usuario no proporcionado.";
}
?>
<br><br>
<a href="usuarios.php">⬅ Volver al listado</a>

<?php
require 'includes/db.php';
require 'includes/auth.php';

if (getUserRole() !== 'estudiante') {       //compruebo que sea un estudiante
    exit('Solo estudiantes pueden suscribirse.');
}

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conn->prepare("UPDATE usuarios SET newsletter = 1 WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

echo "✅ Te has suscripto al newsletter correctamente.";

<?php
require 'includes/db.php';
require 'includes/auth.php';

if (getUserRole() !== 'administrativo') {
    exit('Sin permisos');
}

$id = $_GET['id'];

$stmt = $conn->prepare("UPDATE usuarios SET newsletter = 0 WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo "Usuario desuscripto del newsletter.";

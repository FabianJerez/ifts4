<?php
require 'includes/db.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    exit("❌ Token inválido.");
}

$stmt = $conn->prepare("UPDATE usuarios SET newsletter = 0 WHERE unsuscribe_token = ?");
$stmt->execute([$token]);

if ($stmt->rowCount() > 0) {
    echo "✅ Te desuscribiste del newsletter correctamente.";
} else {
    echo "❌ Token inválido o usuario ya desuscripto.";
}

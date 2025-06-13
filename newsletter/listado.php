<?php
require 'includes/db.php';
require 'includes/auth.php';

$rol = getUserRole();
if (!in_array($rol, ['profesor', 'administrativo'])) {  //solo esta disponible la funcion listar para profesor y administrativo
    exit('Acceso no autorizado.');
}

$result = $conn->query("SELECT nombre, apellido, email FROM usuarios WHERE newsletter = 1 AND activo = 1");

echo "<h2>Suscriptores al Newsletter</h2><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>{$row['nombre']} {$row['apellido']} - {$row['email']}</li>";
}
echo "</ul>";

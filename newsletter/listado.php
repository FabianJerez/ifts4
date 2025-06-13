<?php
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/utils.php';

if (getUserRole() === 'administrativo') {//antes de listar se da de baja (automatica) si pasaron mas de 4 años desde la fecha de suscripcion
    verificarYDarBajaAutomatica($conn);
}

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

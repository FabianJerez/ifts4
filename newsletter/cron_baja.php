<?php
require 'includes/db.php';      // Conexión a la base de datos
require 'includes/auth.php';    // Por si querés restringir acceso opcional
require 'includes/utils.php';   // Función de baja

// Opcional: solo permitir ejecución a administrativos logueados
/*
if (getUserRole() !== 'administrativo') {
    exit("Acceso denegado");
}
*/

$sql = "
    SELECT id_usuario, nombre, apellido, email, fecha_suscripcion 
    FROM usuarios 
    WHERE newsletter = 1 
      AND fecha_suscripcion IS NOT NULL 
      AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR)
";

$result = $conn->query($sql);
$bajas = [];

while ($row = $result->fetch_assoc()) {
    $bajas[] = $row;
}

// Si hay usuarios para dar de baja, actualizamos
if (!empty($bajas)) {
    $conn->query("
        UPDATE usuarios 
        SET newsletter = 0 
        WHERE newsletter = 1 
          AND fecha_suscripcion IS NOT NULL 
          AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR)
    ");

    echo "<h3>Usuarios dados de baja del newsletter:</h3><ul>";
    foreach ($bajas as $u) {
        echo "<li>{$u['nombre']} {$u['apellido']} - {$u['email']} (desde {$u['fecha_suscripcion']})</li>";
    }
    echo "</ul>";
    echo "<p>Total: " . count($bajas) . "</p>";
} else {
    echo "No hay usuarios para dar de baja en este momento.";
}
?>

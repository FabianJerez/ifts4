<?php
require 'includes/db.php';
require 'includes/utils.php';

// Opcional: control de acceso
require 'includes/auth.php';
if (getUserRole() !== 'administrativo') exit("Acceso denegado");

// Ejecutar y mostrar bajas
$bajas = verificarYDarBajaAutomatica($conn);

if (!empty($bajas)) {
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
<!-- boton para volver al panel -->
<br><br>
<div style="text-align: left;">
    <a href="../index.php" style="text-decoration: none;">
        <button style="padding: 5px 10px; font-size: 16px;">Volver al Panel</button>
    </a>
</div>


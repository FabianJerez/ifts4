<?php
require_once __DIR__ . '/auth.php';

function verificarYDarBajaAutomatica($conn) {
    // Buscar usuarios que cumplan con el criterio de baja
    $sqlSelect = "
        SELECT id_usuario, nombre, apellido, email, fecha_suscripcion
        FROM usuarios
        WHERE newsletter = 1 
          AND fecha_suscripcion IS NOT NULL 
          AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR)
    ";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->execute();
    $bajas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si hay usuarios para dar de baja, actualizamos
    if (!empty($bajas)) {
        $sqlUpdate = "
            UPDATE usuarios 
            SET newsletter = 0,
                unsuscribe_token = NULL
            WHERE newsletter = 1 
              AND fecha_suscripcion IS NOT NULL 
              AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR)
        ";
        $conn->exec($sqlUpdate);
    }

    return $bajas; // Devuelve array (vacío si no hubo bajas)
}

function generarToken($longitud = 32) {
    return bin2hex(random_bytes($longitud / 2));
}
?>
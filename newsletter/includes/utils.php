<?php
function verificarYDarBajaAutomatica($conn) {//si pasan mas de 4 años se da de baja del newsletter
    $sql = "
        UPDATE usuarios 
        SET newsletter = 0 
        WHERE newsletter = 1 
          AND fecha_suscripcion IS NOT NULL 
          AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR) 
    ";
    $conn->query($sql);
}

<?php
require_once __DIR__ . '/auth.php';
session_start();                    // Necesario para usar $_SESSION en cualquier página

function getUserRole() {            //obtener el rol del usuario logueado
    return $_SESSION['rol'] ?? null;
}

function getUserId() {              //obtener el ID del usuario logueado
    return $_SESSION['id_usuario'] ?? null;
}

function isLoggedIn() {             //¿está logueado?
    return isset($_SESSION['id_usuario']);
}
//Funciones auxiliares para roles específicos
function esEstudiante() {
    return getUserRole() === 'estudiante';
}

function esProfesor() {
    return getUserRole() === 'profesor';
}

function esAdministrativo() {
    return getUserRole() === 'administrativo';
}
//comprobacion de login antes de acceder
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}
?>
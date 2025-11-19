<?php
// Configurar zona horaria de Colombia
date_default_timezone_set('America/Bogota');

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/core/App.php';
require_once 'app/core/Controller.php';

$app = new App();

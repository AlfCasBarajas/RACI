<?php
// Habilitar errores para debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar la conexión a la base de datos
require_once 'config/database.php';

// Parámetros por defecto
$controller = $_GET['controller'] ?? 'user';
$action = $_GET['action'] ?? 'index';

// Formatear el nombre de la clase del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = "controllers/{$controllerName}.php";

// Verificar si el archivo del controlador existe
if (!file_exists($controllerFile)) {
    die("El controlador '$controllerName' no existe.");
}

// Incluir el controlador
require_once $controllerFile;

// Verificar si la clase existe
if (!class_exists($controllerName)) {
    die("La clase '$controllerName' no se encuentra.");
}

// Crear una instancia del controlador
$controllerInstance = new $controllerName();

// Verificar si el método (acción) existe en el controlador
if (!method_exists($controllerInstance, $action)) {
    die("La acción '$action' no está definida en el controlador '$controllerName'.");
}

// Ejecutar la acción
$controllerInstance->$action();

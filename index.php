<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// poprawiona ścieżka do config.php
require_once __DIR__ . '/app/config/config.php';

$controller = $_GET['controller'] ?? 'product';
$action     = $_GET['action']     ?? 'index';

$controllerName = ucfirst($controller) . 'Controller';
// poprawiona ścieżka do kontrolerów
$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerName) && method_exists($controllerName, $action)) {
        $ctrl = new $controllerName();
        $ctrl->$action();
    } else {
        echo "Brak kontrolera lub akcji: $controllerName->$action";
    }
} else {
    echo "Nie znaleziono pliku kontrolera: $controllerFile";
}

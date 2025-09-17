<?php
// config/config.php
// Konfiguracja bazy SQLite i autoload

define('DB_PATH', __DIR__ . '/../storage/database.sqlite');

function getPDO() {
    static $pdo;
    if (!$pdo) {
        $pdo = new PDO('sqlite:' . DB_PATH);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}

// Autoload klas kontrolerów i modeli
spl_autoload_register(function ($class) {
    $paths = [__DIR__ . '/../app/controllers/', __DIR__ . '/../app/models/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

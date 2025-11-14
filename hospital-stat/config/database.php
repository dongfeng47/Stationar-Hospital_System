<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\ErrorDbNotCreatedController;
use App\Controllers\ErrorDbConnectionController;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $GLOBALS['pdo'] = new PDO(
        sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            $_ENV['DB_HOST'],
            $_ENV['DB_NAME'],
            $_ENV['DB_CHARSET']
        ),
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log("DB Connection failed: " . $e->getMessage());

    if (str_contains($e->getMessage(), 'Unknown database')) {
        ErrorDbNotCreatedController::show();
    } else {
        ErrorDbConnectionController::show();
    }
}

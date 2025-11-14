<?php
session_start();
require_once __DIR__ . '/config/lang.php';
require_once __DIR__ . '/config/database.php';

// Автозагрузка классов
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . "/app/models/$class.php",
        __DIR__ . "/app/controllers/$class.php"
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$controllerName = ucfirst($_GET['controller'] ?? 'Dashboard') . 'Controller';
$action = $_GET['action'] ?? 'index';

if (class_exists($controllerName) && method_exists($controllerName, $action)) {

    if ($controllerName !== 'AuthController') {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }
    }

    $controller = new $controllerName();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($action === 'edit') {
            // Для редактирования: передаём сначала id из GET, потом массив POST
            $id = (int)($_GET['id'] ?? 0);
            $controller->$action($id, $_POST);

        } else {
            // Для остальных POST  просто массив
            $controller->$action($_POST);
        }

    } else {
        // GET-запросы
        $params = $_GET;
        unset($params['controller'], $params['action']);
        $paramValues = array_values($params);
        $controller->$action(...$paramValues);
    }

} else {
    http_response_code(404);
    echo "<h2>" . __('controller_action_not_found') . "</h2>";
}

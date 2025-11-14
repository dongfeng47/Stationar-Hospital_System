<?php
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/DashboardController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class LogController
{
    private $model;

    public function __construct()
    {
        $this->model = new Log();
    }

    // список логов
    public function index()
    {
        AuthController::checkRole(['admin', 'statistician']);

        $logs = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/logs/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }
}

<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/User.php';
use App\Controllers\ErrorUsersNotCreatedController;

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        // сессия запускается
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // модель юзера
        $this->userModel = new User();
    }






    

    // форма входа
    public function loginForm(): void
    {
        // юзер уже в системе
        if (isset($_SESSION['user'])) {
            header("Location: index.php?controller=dashboard&action=index");
            exit;
        }

        require_once __DIR__ . '/../../config/lang.php';

        // таблицы юзеров нет
        if (!$this->isUsersTableExists()) {
            ErrorUsersNotCreatedController::show();
        }

        include __DIR__ . '/../views/auth/login.php';
    }








    // вход юзера
    public function login(array $post): void
    {
        require_once __DIR__ . '/../../config/lang.php';

        $username = trim($post['username'] ?? '');
        $password = trim($post['password'] ?? '');

        // поля пустые
        if ($username === '' || $password === '') {
            $error = __('invalid_login');
            include __DIR__ . '/../views/auth/login.php';
            return;
        }

        // таблица юзеров не найдена
        if (!$this->isUsersTableExists()) {
            ErrorUsersNotCreatedController::show();
        }

        try {
            // юзер из базы
            $user = $this->userModel->getByUsername($username);
        } catch (\PDOException $e) {
            // таблицы нет
            if (str_contains($e->getMessage(), '1146')) {
                ErrorUsersNotCreatedController::show();
            } else {
                throw $e;
            }
        }

        // пароль совпал
        if ($user && hash_equals($user['PasswordHash'], hash('sha256', $password))) {
            $_SESSION['user'] = [
                'Id' => $user['Id'],
                'Username' => $user['Username'],
                'Role' => $user['Role']
            ];

            // переход в панель
            header("Location: index.php?controller=dashboard&action=index");
            exit;
        } else {
            // ошибка входа
            $error = __('invalid_login');
            include __DIR__ . '/../views/auth/login.php';
        }
    }







    // проверка таблицы юзеров
    private function isUsersTableExists(): bool
    {
        global $pdo;

        try {
            $pdo->query("SELECT 1 FROM Users LIMIT 1");
            return true;
        } catch (\PDOException $e) {
            // таблица не найдена
            if (str_contains($e->getMessage(), '1146')) {
                return false;
            }
            throw $e;
        }
    }






    // выход из системы
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION['user']);
        }

        // переход на вход
        header("Location: index.php?controller=auth&action=loginForm");
        exit;
    }








    // проверка роли юзера
    public static function checkRole(array $roles = []): void
    {
        require_once __DIR__ . '/../../config/lang.php';

        // юзер не вошел
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }

        $role = $_SESSION['user']['Role'] ?? '';

        // роль не подходит
        if (!empty($roles) && !in_array($role, $roles, true)) {
            http_response_code(403);
            echo "<h3>" . htmlspecialchars(__('access_denied_role')) . " (" . htmlspecialchars($role) . ")</h3>";
            exit;
        }
    }
}

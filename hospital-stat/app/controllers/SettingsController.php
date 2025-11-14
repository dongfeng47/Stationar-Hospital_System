<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/DashboardController.php';

class SettingsController
{
    public function index()
    {
        AuthController::checkRole(); // любой авторизованный

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $currentLang = $_SESSION['lang'] ?? 'ru';
        $currentTheme = $_SESSION['theme'] ?? 'juice-orange.css';

        // спис
        $themes = [
            'juice-orange.css' => __('theme_juice_orange'),    
            'sky-light.css' => __('theme_sky_light'),          
            'green-grass.css' => __('theme_green_grass'),     
        ];

        $content = __DIR__ . '/../views/settings/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }

    public function save()
    {
        AuthController::checkRole();

       

        if (isset($_POST['language'])) {
            $allowedLangs = ['ru', 'kg'];
            $lang = in_array($_POST['language'], $allowedLangs) ? $_POST['language'] : 'ru';
            $_SESSION['lang'] = $lang;
        }

       
        
        
        if (isset($_POST['theme'])) {
            $theme = basename($_POST['theme']); // защита от подмены пути
            $allowedThemes = ['juice-orange.css','sky-light.css','green-grass.css'];
            if (in_array($theme, $allowedThemes)) {
                $_SESSION['theme'] = $theme;
            }
        }

        header("Location: index.php?controller=settings&action=index");
        exit;
    }
}

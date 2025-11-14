<?php
class DashboardController
{
    public function index()
    {
        // проверка роли
        AuthController::checkRole();

        // имя и роль юзера
        $username = $_SESSION['user']['Username'] ?? '';
        $role = $_SESSION['user']['Role'] ?? '';







        // меню по роли
        $menuItems = self::getMenuByRole($role);

        // какой файл показывать
        switch ($role) {
            case 'admin':
                $content = __DIR__ . '/../views/dashboard/admin.php';
                break;
            case 'doctor':
                $content = __DIR__ . '/../views/dashboard/doctor.php';
                break;
            case 'statistician':
                $content = __DIR__ . '/../views/dashboard/statistician.php';
                break;
            default:
                // роль неизвестна 403
                header('HTTP/1.1 403 Forbidden');
                exit('Доступ запрещен');
        }

        // данные для шаблона
        $data = [
            'username' => $username,
            'menuItems' => $menuItems,
            'content' => $content
        ];

        // подключаем шаблон
        include __DIR__ . '/../views/layouts/main.php';
    }







    // меню по роли
    public static function getMenuByRole($role)
    {
        switch ($role) {
            case 'admin':
                return [
                    __('departments') => 'department',
                    __('wards') => 'ward',
                    __('doctors') => 'doctors',
                    __('patients') => 'patient',
                    __('hospitalizations') => 'hospitalization',
                    __('procedures') => 'medicalprocedure',
                    __('diagnoses') => 'diagnosis',
                   'Пациенты / Диагнозы' => 'PatientDiagnosis', // заглавная D

                    __('logs') => 'log',
                    __('reports') => 'report',
                    __('settings') => 'settings',
                ];



            case 'doctor':
                return [
                    __('patients') => 'patient',
                    __('hospitalizations') => 'hospitalization',
                    __('procedures') => 'medicalprocedure',
                    __('diagnoses') => 'diagnosis',
                    __('settings') => 'settings',
                ];




            case 'statistician':
                return [
                    __('diagnoses') => 'diagnosis',
                    __('reports') => 'report',
                    __('settings') => 'settings',
                ];
            default:
            return [];




            
        }

    }
}

<?php
require_once __DIR__ . '/../models/Doctors.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/DashboardController.php';

class DoctorsController
{
    private $model;
    private $logModel;

    public function __construct()
    {
        $this->model = new Doctors();
        $this->logModel = new Log();
    }




    // список врачей
    public function index()
    {
        AuthController::checkRole(['admin']);
        $doctors = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/doctors/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }





    


    // форма создания 
    public function createForm()
    {
        AuthController::checkRole(['admin']);

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/doctors/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }









    // создание врача
    public function create(array $data)
{
    AuthController::checkRole(['admin']);

    $fullName = trim($data['fullName'] ?? '');
    $position = trim($data['position'] ?? '');
    $phone = trim($data['phone'] ?? '');

    if (!$fullName) {
        $_SESSION['error'] = __('full_name_required');
        header("Location: index.php?controller=doctors&action=createForm");
        exit;
    }

    $id = $this->model->create($fullName, $position, $phone);

    // лог врача
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('doctor_created') . ': ' . $fullName . ' (ID: ' . $id . '), ' . __('position') . ': ' . $position . ', ' . __('phone') . ': ' . $phone
    );

    header("Location: index.php?controller=doctors&action=index");
    exit;
}








// Форма врача
public function editForm($id)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    $doctor = $this->model->getById($id);

    if (!$doctor) {
        $_SESSION['error'] = __('doctor_not_found');
        header("Location: index.php?controller=doctors&action=index");
        exit;
    }

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = DashboardController::getMenuByRole($role);

    $content = __DIR__ . '/../views/doctors/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}











// редактирование 
public function edit($id, array $data)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    $fullName = trim($data['fullName'] ?? '');
    $position = trim($data['position'] ?? '');
    $phone = trim($data['phone'] ?? '');

    $oldDoctor = $this->model->getById($id);
    if (!$id || !$oldDoctor) {
        $_SESSION['error'] = __('doctor_not_found');
        header("Location: index.php?controller=doctors&action=index");
        exit;
    }

    $this->model->update($id, $fullName, $position, $phone);

    // лог редактирование врача
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('doctor_edited') . ': ' . $oldDoctor['FullName'] . ' (ID: ' . $id . ') → ' . $fullName . ', ' . __('position') . ': ' . $oldDoctor['Position'] . ' → ' . $position . ', ' . __('phone') . ': ' . $oldDoctor['Phone'] . ' → ' . $phone
    );

    header("Location: index.php?controller=doctors&action=index");
    exit;
}







// удаление врача
public function delete($id)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    $doctor = $this->model->getById($id);

    if ($doctor) {
        $this->model->delete($id);

        // лог удаление врача
        $userId = $_SESSION['user']['Id'] ?? null;
        $this->logModel->create(
            $userId,
            __('doctor_deleted') . ': ' . $doctor['FullName'] . ' (ID: ' . $id . '), ' . __('position') . ': ' . $doctor['Position'] . ', ' . __('phone') . ': ' . $doctor['Phone']
        );
    }

    header("Location: index.php?controller=doctors&action=index");
    exit;
}

}

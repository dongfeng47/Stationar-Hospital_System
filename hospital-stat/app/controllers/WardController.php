<?php
require_once __DIR__ . '/../models/Ward.php';
require_once __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/DashboardController.php';

class WardController
{
    private $model;
    private $departmentModel;
    private $logModel;

    public function __construct()
    {
        $this->model = new Ward();
        $this->departmentModel = new Department();
        $this->logModel = new Log();
    }




    // список палат
    public function index()
    {
        AuthController::checkRole(['admin']); // только админ

        $wards = $this->model->getAll();
        $departments = $this->departmentModel->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/wards/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }







    // форма создания 
    public function createForm()
    {
        AuthController::checkRole(['admin']);

        $departments = $this->departmentModel->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/wards/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }




    // создать палату
   public function create(array $data)
{
    AuthController::checkRole(['admin']);

    $departmentId = (int)($data['departmentId'] ?? 0);
    $wardNumber = trim($data['wardNumber'] ?? '');
    $bedCount = (int)($data['bedCount'] ?? 1);

    if ($departmentId <= 0 || empty($wardNumber) || $bedCount <= 0) {
        $_SESSION['error'] = __('invalid_create_ward_data');
        header("Location: index.php?controller=ward&action=createForm");
        exit;
    }

    $id = $this->model->create($departmentId, $wardNumber, $bedCount);

    // логируем созда 
    $userId = $_SESSION['user']['Id'] ?? null;
    $departmentName = $this->departmentModel->getById($departmentId)['Name'] ?? '';
    $this->logModel->create(
        $userId,
        __('ward_created') . ': ' . $wardNumber . ' (ID: ' . $id . '), ' . __('department') . ': ' . $departmentName . ', ' . __('beds') . ': ' . $bedCount
    );

    header("Location: index.php?controller=ward&action=index");
    exit;
}







// форма редакт
public function editForm($id)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    $ward = $this->model->getById($id);
    if (!$ward) {
        $_SESSION['error'] = __('ward_not_found');
        header("Location: index.php?controller=ward&action=index");
        exit;
    }

    $departments = $this->departmentModel->getAll();

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = DashboardController::getMenuByRole($role);

    $content = __DIR__ . '/../views/wards/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}






// редак пал
public function edit($id, array $data)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    $departmentId = (int)($data['departmentId'] ?? 0);
    $wardNumber = trim($data['wardNumber'] ?? '');
    $bedCount = (int)($data['bedCount'] ?? 1);

    if ($id <= 0 || $departmentId <= 0 || empty($wardNumber) || $bedCount <= 0) {
        $_SESSION['error'] = __('invalid_edit_ward_data');
        header("Location: index.php?controller=ward&action=editForm&id=$id");
        exit;
    }

    $ward = $this->model->getById($id);
    if (!$ward) {
        $_SESSION['error'] = __('ward_not_found');
        header("Location: index.php?controller=ward&action=index");
        exit;
    }

    $this->model->update($id, $departmentId, $wardNumber, $bedCount);

    // лог редак палат
    $userId = $_SESSION['user']['Id'] ?? null;
    $oldDepartmentName = $this->departmentModel->getById($ward['DepartmentId'])['Name'] ?? '';
    $newDepartmentName = $this->departmentModel->getById($departmentId)['Name'] ?? '';
    $this->logModel->create(
        $userId,
        __('ward_edited') . ': ' . $ward['WardNumber'] . ' (ID: ' . $id . '), ' . __('department') . ': ' . $oldDepartmentName . ' → ' . $newDepartmentName . ', ' . __('beds') . ': ' . $ward['BedCount'] . ' → ' . $bedCount
    );

    header("Location: index.php?controller=ward&action=index");
    exit;
}








// удалить 
public function delete($id)
{
    AuthController::checkRole(['admin']);

    $ward = $this->model->getById($id);
    if ($ward) {
        $this->model->delete($id);

        // логируем удаление 
        $userId = $_SESSION['user']['Id'] ?? null;
        $departmentName = $this->departmentModel->getById($ward['DepartmentId'])['Name'] ?? '';
        $this->logModel->create(
            $userId,
            __('ward_deleted') . ': ' . $ward['WardNumber'] . ' (ID: ' . $id . '), ' . __('department') . ': ' . $departmentName . ', ' . __('beds') . ': ' . $ward['BedCount']
        );
    }

    header("Location: index.php?controller=ward&action=index");
    exit;
}

}

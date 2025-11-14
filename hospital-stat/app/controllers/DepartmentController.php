<?php
require_once __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/DashboardController.php';
require_once __DIR__ . '/../controllers/AuthController.php';




class DepartmentController
{
    private $model;
    private $logModel;

    public function __construct()
    {   
        $this->model = new Department(); 
                                         // модель отд kju
        $this->logModel = new Log();
    }






    // список отделений
    public function index()
    {
        AuthController::checkRole(['admin']);

        $departments = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);
//  шаблон
        $content = __DIR__ . '/../views/departments/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }





  // форма создания
    public function createForm()
    {
        AuthController::checkRole(['admin']);

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/departments/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }





    // создать отделение
   public function create(array $data)
{
    AuthController::checkRole(['admin']);

    $name = trim($data['name'] ?? '');
    if (empty($name)) {
        $_SESSION['error'] = __('department_name_required');
        header("Location: index.php?controller=department&action=createForm");
        exit;
    }

    $id = $this->model->create($name);  // добавление отделения в базу возвращает ид





   // лог создание
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('department_created') . ': ' . $name . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=department&action=index");
    exit;
}








 // форма редактирования
public function editForm($id)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    if ($id <= 0) {
        header("Location: index.php?controller=department&action=index");
        exit;
    }

    $department = $this->model->getById($id);
    if (!$department) {
        $_SESSION['error'] = __('department_not_found');
        header("Location: index.php?controller=department&action=index");
        exit;
    }

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = DashboardController::getMenuByRole($role);

    $content = __DIR__ . '/../views/departments/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}





 // сохранить редактирование
    public function edit(int $id, array $data)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    $name = trim($data['name'] ?? '');

    if ($id <= 0 || empty($name)) {
        $_SESSION['error'] = __('invalid_edit_data');
        header("Location: index.php?controller=department&action=editForm&id=$id");
        exit;
    }

    $oldDepartment = $this->model->getById($id);
    if (!$oldDepartment) {
        $_SESSION['error'] = __('department_not_found');
        header("Location: index.php?controller=department&action=index");
        exit;
    }

    $this->model->update($id, $name);

     // лог редактирование
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('department_edited') . ': ' . $oldDepartment['Name'] . ' (ID: ' . $id . ') → ' . $name
    );

    header("Location: index.php?controller=department&action=index");
    exit;
}














   // удалить отделение
    public function delete($id)
{
    AuthController::checkRole(['admin']);

    $id = (int)$id;
    if ($id <= 0) {
        header("Location: index.php?controller=department&action=index");
        exit;
    }

    $department = $this->model->getById($id);
    if (!$department) {
        $_SESSION['error'] = __('department_not_found');
        header("Location: index.php?controller=department&action=index");
        exit;
    }

    $this->model->delete($id);

    // лог удаление
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('department_deleted') . ': ' . $department['Name'] . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=department&action=index");
    exit;
}

}

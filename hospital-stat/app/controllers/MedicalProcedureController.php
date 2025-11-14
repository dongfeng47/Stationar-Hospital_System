<?php
require_once __DIR__ . '/../models/MedicalProcedure.php';
require_once __DIR__ . '/../models/Hospitalization.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/DashboardController.php';

class MedicalProcedureController
{
    private $model;
    private $logModel;

    public function __construct()
    {
        $this->model = new MedicalProcedure();
        $this->logModel = new Log();
    }





    // список процедур
    public function index()
    {
        AuthController::checkRole(['admin', 'doctor']);
        $procedures = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/procedures/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }







    // форма создания процед
    public function createForm()
    {
        AuthController::checkRole(['admin', 'doctor']);

        $hospitalizationModel = new Hospitalization();
        $hospitalizations = $hospitalizationModel->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/procedures/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }







    // создание процедуры через POST
    public function create(array $postData)
{
    AuthController::checkRole(['admin', 'doctor']);

    if (empty($postData['HospitalizationId']) || empty($postData['ProcedureName']) || empty($postData['ProcedureDate'])) {
        $_SESSION['error'] = __('all_fields_required');
        header("Location: index.php?controller=medicalprocedure&action=createForm");
        exit;
    }

    $id = $this->model->create($postData);

    // лог создание проце
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('procedure_created') . ': ' . $postData['ProcedureName'] . ' (ID: ' . $id . '), ' . __('hospitalization_id') . ': ' . $postData['HospitalizationId']
    );

    header("Location: index.php?controller=medicalprocedure&action=index");
    exit;
}








// форма редак проц
public function editForm(int $id)
{
    AuthController::checkRole(['admin', 'doctor']);

    $procedure = $this->model->getById($id);
    if (!$procedure) {
        $_SESSION['error'] = __('procedure_not_found');
        header("Location: index.php?controller=medicalprocedure&action=index");
        exit;
    }

    $hospitalizationModel = new Hospitalization();
    $hospitalizations = $hospitalizationModel->getAll();

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = DashboardController::getMenuByRole($role);

    $content = __DIR__ . '/../views/procedures/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}









// редак процед
public function edit(int $id, array $postData)
{
    AuthController::checkRole(['admin', 'doctor']);

    if (empty($postData['HospitalizationId']) || empty($postData['ProcedureName']) || empty($postData['ProcedureDate'])) {
        $_SESSION['error'] = __('all_fields_required');
        header("Location: index.php?controller=medicalprocedure&action=editForm&id=$id");
        exit;
    }

    $oldProcedure = $this->model->getById($id);
    $this->model->update($id, $postData);

    // лог редак проц
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('procedure_edited') . ': ' . $oldProcedure['ProcedureName'] . ' (ID: ' . $id . ') → ' . $postData['ProcedureName'] .
        ', ' . __('hospitalization_id') . ': ' . $postData['HospitalizationId']
    );

    header("Location: index.php?controller=medicalprocedure&action=index");
    exit;
}









// удаление проц
public function delete(int $id)
{
    AuthController::checkRole(['admin', 'doctor']);

    $procedure = $this->model->getById($id);
    if ($procedure) {
        $this->model->delete($id);

        // 🔹 Логируем удаление процедуры
        $userId = $_SESSION['user']['Id'] ?? null;
        $this->logModel->create(
            $userId,
            __('procedure_deleted') . ': ' . $procedure['ProcedureName'] . ' (ID: ' . $id . '), ' . __('hospitalization_id') . ': ' . $procedure['HospitalizationId']
        );
    }

    header("Location: index.php?controller=medicalprocedure&action=index");
    exit;
}

}

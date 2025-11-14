<?php
require_once __DIR__ . '/../models/Diagnosis.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class DiagnosisController
{
    private $model;
    private $logModel;

    public function __construct()
    {  //моделти
        $this->model = new Diagnosis();
        $this->logModel = new Log();
    }




    // список диагнозов
    public function index()
    {
        AuthController::checkRole(['admin', 'doctor', 'statistician']);

        $diagnoses = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/diagnosis/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }






    //создание диагноза форма
    public function createForm()
    {
        AuthController::checkRole(['admin', 'doctor', 'statistician']);

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/diagnosis/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }





    // создание диагноза
    public function create(array $postData)
{
    AuthController::checkRole(['admin', 'doctor', 'statistician']);

    $diagnosisName = trim($postData['diagnosisName'] ?? '');

    if (empty($diagnosisName)) {
        $_SESSION['error'] = __('field_required');
        header("Location: index.php?controller=diagnosis&action=createForm");
        exit;
    }

    $id = $this->model->create($diagnosisName);

    // лог создание диагноза
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('diagnosis_created') . ': ' . $diagnosisName . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=diagnosis&action=index");
    exit;
}








// форма редак
public function editForm($id)
{
    AuthController::checkRole(['admin', 'doctor', 'statistician']);

    $diagnosis = $this->model->getById($id);
    if (!$diagnosis) {
        $_SESSION['error'] = __('diagnosis_not_found');
        header("Location: index.php?controller=diagnosis&action=index");
        exit;
    }

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = DashboardController::getMenuByRole($role);

    $content = __DIR__ . '/../views/diagnosis/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}









// редактирование диагноза
public function edit($id, array $postData)
{
    AuthController::checkRole(['admin', 'doctor', 'statistician']);

    $diagnosisName = trim($postData['diagnosisName'] ?? '');
    if (empty($diagnosisName)) {
        $_SESSION['error'] = __('field_required');
        header("Location: index.php?controller=diagnosis&action=editForm&id=$id");
        exit;
    }

    $oldDiagnosis = $this->model->getById($id);
    $this->model->update($id, $diagnosisName);

    // лог редактирование
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('diagnosis_edited') . ': ' . $oldDiagnosis['DiagnosisName'] . ' (ID: ' . $id . ') → ' . $diagnosisName
    );

    header("Location: index.php?controller=diagnosis&action=index");
    exit;
}





// удаление диагноза
public function delete($id)
{
    AuthController::checkRole(['admin', 'doctor', 'statistician']);

    $diagnosis = $this->model->getById($id);
    if (!$diagnosis) {
        $_SESSION['error'] = __('diagnosis_not_found');
        header("Location: index.php?controller=diagnosis&action=index");
        exit;
    }

    $this->model->delete($id);

    // лог удаление
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('diagnosis_deleted') . ': ' . $diagnosis['DiagnosisName'] . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=diagnosis&action=index");
    exit;
}

}

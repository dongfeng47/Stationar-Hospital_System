<?php
require_once __DIR__ . '/../models/Hospitalization.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Ward.php';
require_once __DIR__ . '/../models/Doctors.php';
require_once __DIR__ . '/../models/Diagnosis.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/DashboardController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class HospitalizationController
{
    private $model;
    private $logModel;

    public function __construct()
    {
        AuthController::checkRole(['admin']);
        $this->model = new Hospitalization();
        $this->logModel = new Log();
    }





    // список госпитал
    public function index()
    {
        AuthController::checkRole(['admin', 'doctor']);

        $hospitalizations = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/hospitalizations/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }






    // форма создания
    public function createForm()
    {
        AuthController::checkRole(['admin']);

        $patients = (new Patient())->getAll();
        $wards = (new Ward())->getAll();
        $doctors = (new Doctors())->getAll();
        $diagnoses = (new Diagnosis())->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/hospitalizations/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }

    // создать гос
    public function create(array $data)
{
    AuthController::checkRole(['admin']);

    if (empty($data['PatientId']) || empty($data['WardId']) || empty($data['AdmissionDate'])) {
        $_SESSION['error'] = __('required_fields_missing');
        header("Location: index.php?controller=hospitalization&action=createForm");
        exit;
    }

    $id = $this->model->create($data);

    // логируем создание госпитализации
    $userId = $_SESSION['user']['Id'] ?? null;
    $patient = (new Patient())->getById($data['PatientId']);
    $ward = (new Ward())->getById($data['WardId']);
    $this->logModel->create(
        $userId,
        __('hospitalization_created') . ': ' . $patient['FullName'] . ' → ' . $ward['WardNumber'] . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=hospitalization&action=index");
    exit;
}









// форма редак
public function editForm(int $id)
{
    AuthController::checkRole(['admin']);

    $hospitalization = $this->model->getById($id);
    if (!$hospitalization) {
        $_SESSION['error'] = __('hospitalization_not_found');
        header("Location: index.php?controller=hospitalization&action=index");
        exit;
    }

    $patients = (new Patient())->getAll();
    $wards = (new Ward())->getAll();
    $doctors = (new Doctors())->getAll();
    $diagnoses = (new Diagnosis())->getAll();

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = DashboardController::getMenuByRole($role);

    $content = __DIR__ . '/../views/hospitalizations/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}








// сохранить измен
public function edit(int $id, array $data)
{
    AuthController::checkRole(['admin']);

    $hospitalization = $this->model->getById($id);
    if (!$hospitalization) {
        $_SESSION['error'] = __('hospitalization_not_found');
        header("Location: index.php?controller=hospitalization&action=index");
        exit;
    }

    $this->model->update($id, $data);

    // лог редак
    $userId = $_SESSION['user']['Id'] ?? null;
    $patient = (new Patient())->getById($data['PatientId']);
    $ward = (new Ward())->getById($data['WardId']);
    $this->logModel->create(
        $userId,
        __('hospitalization_edited') . ' (ID: ' . $id . '), ' . __('patient') . ': ' . $patient['FullName'] . ', ' . __('ward') . ': ' . $ward['WardNumber']
    );

    header("Location: index.php?controller=hospitalization&action=index");
    exit;
}






// удалить госп
public function delete(int $id)
{
    AuthController::checkRole(['admin']);

    $hospitalization = $this->model->getById($id);
    if (!$hospitalization) {
        $_SESSION['error'] = __('hospitalization_not_found');
        header("Location: index.php?controller=hospitalization&action=index");
        exit;
    }

    $this->model->delete($id);

    // лог удаление
    $userId = $_SESSION['user']['Id'] ?? null;
    $patient = (new Patient())->getById($hospitalization['PatientId']);
    $ward = (new Ward())->getById($hospitalization['WardId']);
    $this->logModel->create(
        $userId,
        __('hospitalization_deleted') . ' (ID: ' . $id . '), ' . __('patient') . ': ' . $patient['FullName'] . ', ' . __('ward') . ': ' . $ward['WardNumber']
    );

    header("Location: index.php?controller=hospitalization&action=index");
    exit;
}

}

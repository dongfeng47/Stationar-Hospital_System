<?php
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/DashboardController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class PatientController
{
    private $model;
    private $logModel;

    public function __construct()
    {
        AuthController::checkRole(['admin', 'doctor']); 
        $this->model = new Patient();
        $this->logModel = new Log();
    }







    // список пациентов
    public function index()
    {
        $patients = $this->model->getAll();

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = (new DashboardController())->getMenuByRole($role);

        $content = __DIR__ . '/../views/patients/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }








    // форма создания пациента
    public function createForm()
    {
        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = (new DashboardController())->getMenuByRole($role);

        $content = __DIR__ . '/../views/patients/createForm.php';
        include __DIR__ . '/../views/layouts/main.php';
    }






    // создать 
    public function create(array $data)
{
    $fullName = trim($data['fullName'] ?? '');
    $gender = $data['gender'] ?? '';
    $birthDate = $data['birthDate'] ?? '';

    if (!$fullName || !$gender || !$birthDate) {
        $_SESSION['error'] = __('invalid_patient_data');
        header("Location: index.php?controller=patient&action=createForm");
        exit;
    }

    $id = $this->model->create($fullName, $gender, $birthDate);

    // лог
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('patient_created') . ': ' . $fullName . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=patient&action=index");
    exit;
}






// форма ред
public function editForm($id)
{
    $id = (int)$id;
    $patient = $this->model->getById($id);

    if (!$patient) {
        $_SESSION['error'] = __('patient_not_found');
        header("Location: index.php?controller=patient&action=index");
        exit;
    }

    $role = $_SESSION['user']['Role'] ?? '';
    $menuItems = (new DashboardController())->getMenuByRole($role);

    $content = __DIR__ . '/../views/patients/editForm.php';
    include __DIR__ . '/../views/layouts/main.php';
}










// редак пац
public function edit($id, array $data)
{
    $id = (int)$id;
    $fullName = trim($data['fullName'] ?? '');
    $gender = $data['gender'] ?? '';
    $birthDate = $data['birthDate'] ?? '';

    if (!$id || !$fullName || !$gender || !$birthDate) {
        $_SESSION['error'] = __('invalid_patient_data');
        header("Location: index.php?controller=patient&action=editForm&id=$id");
        exit;
    }

    $oldPatient = $this->model->getById($id);
    $this->model->update($id, $fullName, $gender, $birthDate);

    // лог редак 
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('patient_edited') . ': ' . $oldPatient['FullName'] . ' (ID: ' . $id . ') → ' . $fullName
    );

    header("Location: index.php?controller=patient&action=index");
    exit;
}











// удаление 
public function delete($id)
{
    $id = (int)$id;
    $patient = $this->model->getById($id);

    if (!$patient) {
        $_SESSION['error'] = __('patient_not_found');
        header("Location: index.php?controller=patient&action=index");
        exit;
    }

    $this->model->delete($id);

    // лог удал 
    $userId = $_SESSION['user']['Id'] ?? null;
    $this->logModel->create(
        $userId,
        __('patient_deleted') . ': ' . $patient['FullName'] . ' (ID: ' . $id . ')'
    );

    header("Location: index.php?controller=patient&action=index");
    exit;
}

}

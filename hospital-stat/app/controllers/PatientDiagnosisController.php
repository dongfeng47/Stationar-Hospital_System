<?php
require_once __DIR__ . '/../models/PatientDiagnosis.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/DashboardController.php';

class PatientDiagnosisController
{
    private $model;

    public function __construct()
    {
        AuthController::checkRole(['admin', 'doctor', 'statistician']); 
        $this->model = new PatientDiagnosis();
    }







    // получить диагнозы пац
    public function getByPatient($patientId)
    {
        $diagnoses = $this->model->getByPatient($patientId);

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $content = __DIR__ . '/../views/patient_diagnosis/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }









    // добавить диагноз 
    public function addDiagnosis($patientId, $diagnosisId)
    {
        AuthController::checkRole(['admin', 'doctor']); // доб  только админ  доктор
        $this->model->addDiagnosis($patientId, $diagnosisId);

        header("Location: index.php?controller=patientdiagnosis&action=getByPatient&id=$patientId");
        exit;
    }






    

    // удалить диагноз 
    public function removeDiagnosis($patientId, $diagnosisId)
    {
        AuthController::checkRole(['admin', 'doctor']); 
        $this->model->removeDiagnosis($patientId, $diagnosisId);

        header("Location: index.php?controller=patientdiagnosis&action=getByPatient&id=$patientId");
        exit;
    }
}

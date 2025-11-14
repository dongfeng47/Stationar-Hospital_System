<?php
require_once __DIR__ . '/Model.php';


class PatientDiagnosis extends Model
{
    protected $table = 'PatientDiagnosis';

    public function getByPatient($patientId)
    {
        return $this->fetchAll(
            "SELECT pd.DiagnosisId, d.DiagnosisName 
             FROM {$this->table} pd
             JOIN Diagnosis d ON pd.DiagnosisId = d.Id
             WHERE pd.PatientId = ?", 
            [$patientId]
        );
    }

    public function addDiagnosis($patientId, $diagnosisId)
    {
        $sql = "INSERT INTO {$this->table} (PatientId, DiagnosisId) VALUES (?, ?)";
        $this->query($sql, [$patientId, $diagnosisId]);
    }

    public function removeDiagnosis($patientId, $diagnosisId)
    {
        $sql = "DELETE FROM {$this->table} WHERE PatientId = ? AND DiagnosisId = ?";
        $this->query($sql, [$patientId, $diagnosisId]);
    }
}

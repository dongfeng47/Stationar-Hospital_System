<?php
require_once __DIR__ . '/Model.php';

class Hospitalization extends Model
{
    protected $table = 'Hospitalization';

    // получить все госпитализации с названиями
    public function getAll(): array
    {
        $sql = "SELECT h.Id, h.PatientId, h.WardId, h.DoctorId, h.DiagnosisId, 
                       h.AdmissionDate, h.DischargeDate,
                       p.FullName AS PatientName,
                       w.WardNumber AS WardNumber,
                       d.FullName AS DoctorName,
                       diag.DiagnosisName AS DiagnosisName
                FROM {$this->table} h
                LEFT JOIN Patient p ON h.PatientId = p.Id
                LEFT JOIN Ward w ON h.WardId = w.Id
                LEFT JOIN Doctors d ON h.DoctorId = d.Id
                LEFT JOIN Diagnosis diag ON h.DiagnosisId = diag.Id
                ORDER BY h.AdmissionDate DESC";
        return $this->fetchAll($sql);
    }




    //  по ID
    public function getById(int $id): ?array
    {
        $sql = "SELECT h.Id, h.PatientId, h.WardId, h.DoctorId, h.DiagnosisId, 
                       h.AdmissionDate, h.DischargeDate,
                       p.FullName AS PatientName,
                       w.WardNumber AS WardNumber,
                       d.FullName AS DoctorName,
                       diag.DiagnosisName AS DiagnosisName
                FROM {$this->table} h
                LEFT JOIN Patient p ON h.PatientId = p.Id
                LEFT JOIN Ward w ON h.WardId = w.Id
                LEFT JOIN Doctors d ON h.DoctorId = d.Id
                LEFT JOIN Diagnosis diag ON h.DiagnosisId = diag.Id
                WHERE h.Id = ?";
        $result = $this->fetch($sql, [$id]);
        return $result ?: null;
    }





    // создать госп
    public function create(array $data): int
    {
        $this->validate($data);

        $sql = "INSERT INTO {$this->table} 
            (PatientId, WardId, DoctorId, DiagnosisId, AdmissionDate, DischargeDate)
            VALUES (?, ?, ?, ?, ?, ?)";
        $this->query($sql, [
            $data['PatientId'],
            $data['WardId'],
            $data['DoctorId'],
            $data['DiagnosisId'],
            $data['AdmissionDate'],
            $data['DischargeDate']
        ]);
        return (int)$this->pdo->lastInsertId();
    }





    //  редактировать 
    public function update(int $id, array $data): bool
    {
        $this->validate($data);

        $sql = "UPDATE {$this->table} SET 
            PatientId = ?, WardId = ?, DoctorId = ?, DiagnosisId = ?, AdmissionDate = ?, DischargeDate = ?
            WHERE Id = ?";
        return $this->query($sql, [
            $data['PatientId'],
            $data['WardId'],
            $data['DoctorId'],
            $data['DiagnosisId'],
            $data['AdmissionDate'],
            $data['DischargeDate'],
            $id
        ]) !== false;
    }





    // удалить
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        return $this->query($sql, [$id]) !== false;
    }

    //  обязатель поле
    private function validate(array $data)
    {
        $required = ['PatientId', 'WardId', 'DoctorId', 'DiagnosisId', 'AdmissionDate'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("Поле {$field} обязательно для заполнения");
            }
        }
    }
}

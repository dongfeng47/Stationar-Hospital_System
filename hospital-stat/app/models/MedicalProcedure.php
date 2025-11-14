<?php
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Hospitalization.php';

class MedicalProcedure extends Model
{
    protected $table = 'MedicalProcedure';

    // получить все процедуры с данными госпитализации и пациента
    public function getAll(): array
    {
        $sql = "SELECT mp.Id, mp.HospitalizationId, mp.ProcedureName, mp.ProcedureDate,
                       h.PatientId, p.FullName AS PatientName,
                       h.AdmissionDate, h.DischargeDate
                FROM {$this->table} mp
                JOIN Hospitalization h ON mp.HospitalizationId = h.Id
                LEFT JOIN Patient p ON h.PatientId = p.Id
                ORDER BY mp.ProcedureDate DESC";
        return $this->fetchAll($sql);
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT mp.Id, mp.HospitalizationId, mp.ProcedureName, mp.ProcedureDate,
                       h.PatientId, p.FullName AS PatientName,
                       h.AdmissionDate, h.DischargeDate
                FROM {$this->table} mp
                JOIN Hospitalization h ON mp.HospitalizationId = h.Id
                LEFT JOIN Patient p ON h.PatientId = p.Id
                WHERE mp.Id = ?";
        $result = $this->fetch($sql, [$id]);
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (HospitalizationId, ProcedureName, ProcedureDate)
                VALUES (?, ?, ?)";
        $this->query($sql, [
            $data['HospitalizationId'],
            $data['ProcedureName'],
            $data['ProcedureDate']
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET ProcedureName = ?, ProcedureDate = ?, HospitalizationId = ? WHERE Id = ?";
        return $this->query($sql, [
            $data['ProcedureName'],
            $data['ProcedureDate'],
            $data['HospitalizationId'],
            $id
        ]) !== false;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        return $this->query($sql, [$id]) !== false;
    }
}

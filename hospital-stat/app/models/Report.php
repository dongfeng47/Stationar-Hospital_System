<?php 
require_once __DIR__ . '/Model.php';

class Report extends Model
{
    
     //получение данных по теме отчёта с фильтрами
     
    public function getReportData(string $topic, array $filters = []): array
    {
        switch ($topic) {
            case 'diagnosis':
                return $this->getPatientsByDiagnosis($filters);
            case 'procedure':
                return $this->getProceduresReport($filters);
            case 'hospitalization':
                return $this->getHospitalizationsReport($filters);
            default:
                return [];
        }
    }

    
      // получить список всех врачей для фильтров
     
    public function getDoctorsList(): array
    {
        $sql = "SELECT Id, FullName FROM Doctors ORDER BY FullName";
        return $this->fetchAll($sql);
    }

    
    public function getWardsList(): array
    {
        $sql = "SELECT w.Id, CONCAT(w.WardNumber, ' (', d.Name, ')') AS WardName
                FROM Ward w
                JOIN Department d ON w.DepartmentId = d.Id
                ORDER BY d.Name, w.WardNumber";
        return $this->fetchAll($sql);
    }

    
    private function getPatientsByDiagnosis(array $filters = []): array
    {
        $sql = "SELECT d.DiagnosisName, COUNT(pd.PatientId) AS PatientCount
                FROM Diagnosis d
                LEFT JOIN PatientDiagnosis pd ON d.Id = pd.DiagnosisId
                GROUP BY d.Id, d.DiagnosisName
                ORDER BY PatientCount DESC";
        return $this->fetchAll($sql);
    }

    
    private function getProceduresReport(array $filters = []): array
    {
        $sql = "SELECT mp.ProcedureName,
                       COUNT(mp.Id) AS ProcedureCount,
                       COALESCE(doc.FullName, 'Не указан') AS Doctor
                FROM MedicalProcedure mp
                JOIN Hospitalization h ON mp.HospitalizationId = h.Id
                LEFT JOIN Doctors doc ON h.DoctorId = doc.Id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['startDate'])) {
            $sql .= " AND mp.ProcedureDate >= ?";
            $params[] = $filters['startDate'] . " 00:00:00";
        }
        if (!empty($filters['endDate'])) {
            $sql .= " AND mp.ProcedureDate <= ?";
            $params[] = $filters['endDate'] . " 23:59:59";
        }
        if (!empty($filters['doctorId'])) {
            $sql .= " AND h.DoctorId = ?";
            $params[] = $filters['doctorId'];
        }

        $sql .= " GROUP BY mp.ProcedureName, doc.FullName
                  ORDER BY ProcedureCount DESC";
        return $this->fetchAll($sql, $params);
    }

    
    private function getHospitalizationsReport(array $filters = []): array
    {
        $sql = "SELECT d.Name AS Department,
                       w.WardNumber,
                       COUNT(h.Id) AS HospitalizationsCount,
                       MIN(h.AdmissionDate) AS FirstAdmission,
                       MAX(h.DischargeDate) AS LastDischarge
                FROM Hospitalization h
                JOIN Ward w ON h.WardId = w.Id
                JOIN Department d ON w.DepartmentId = d.Id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['startDate'])) {
            $sql .= " AND h.AdmissionDate >= ?";
            $params[] = $filters['startDate'];
        }
        if (!empty($filters['endDate'])) {
            $sql .= " AND h.AdmissionDate <= ?";
            $params[] = $filters['endDate'];
        }
        if (!empty($filters['wardId'])) {
            $sql .= " AND w.Id = ?";
            $params[] = $filters['wardId'];
        }

        $sql .= " GROUP BY w.Id, w.WardNumber, d.Name
                  ORDER BY d.Name, w.WardNumber";
        return $this->fetchAll($sql, $params);
    }
}  
<?php
require_once __DIR__ . '/Model.php';

/**
 * Модель для таблицы Diagnosis
 */
class Diagnosis extends Model
{
    protected $table = 'Diagnosis';

    public function getAll()
    {
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY DiagnosisName");
    }

    public function getById($id)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE Id = ?", [$id]);
    }

    public function create($diagnosisName)
    {
        $sql = "INSERT INTO {$this->table} (DiagnosisName) VALUES (?)";
        $this->query($sql, [$diagnosisName]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $diagnosisName)
    {
        $sql = "UPDATE {$this->table} SET DiagnosisName = ? WHERE Id = ?";
        return $this->query($sql, [$diagnosisName, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        return $this->query($sql, [$id]);
    }
}

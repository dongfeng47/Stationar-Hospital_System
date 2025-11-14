<?php
require_once __DIR__ . '/Model.php';


class Patient extends Model
{
    protected $table = 'Patient';

    public function getAll()
    {
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY FullName");
    }

    public function getById($id)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE Id = ?", [$id]);
    }

    public function create($fullName, $gender, $birthDate)
    {
        $sql = "INSERT INTO {$this->table} (FullName, Gender, BirthDate) VALUES (?, ?, ?)";
        $this->query($sql, [$fullName, $gender, $birthDate]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $fullName, $gender, $birthDate)
    {
        $sql = "UPDATE {$this->table} SET FullName = ?, Gender = ?, BirthDate = ? WHERE Id = ?";
        return $this->query($sql, [$fullName, $gender, $birthDate, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        return $this->query($sql, [$id]);
    }
}

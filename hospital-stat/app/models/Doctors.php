<?php
require_once __DIR__ . '/Model.php';


class Doctors extends Model
{
    protected $table = 'doctors'; 

    public function getAll()
    {
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY FullName");
    }

    public function getById($id)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE Id = ?", [(int)$id]);
    }

    public function create($fullName, $position = null, $phone = null)
    {
        $sql = "INSERT INTO {$this->table} (FullName, Position, Phone) VALUES (?, ?, ?)";
        $this->query($sql, [$fullName, $position, $phone]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $fullName, $position, $phone)
    {
        $sql = "UPDATE {$this->table} SET FullName = ?, Position = ?, Phone = ? WHERE Id = ?";
        return $this->query($sql, [$fullName, $position, $phone, (int)$id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        return $this->query($sql, [(int)$id]);
    }
}

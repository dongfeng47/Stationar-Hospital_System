<?php
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Department.php';


class Ward extends Model
{
    protected $table = 'Ward';

    // получить все палаты
    public function getAll()
    {
        return $this->fetchAll("SELECT w.*, d.Name AS DepartmentName 
                                FROM {$this->table} w
                                JOIN Department d ON w.DepartmentId = d.Id
                                ORDER BY w.WardNumber");
    }




    // получитьу по ид
    public function getById($id)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE Id = ?", [$id]);
    }






    // создать палату
    public function create($departmentId, $wardNumber, $bedCount = 1)
    {
        $sql = "INSERT INTO {$this->table} (DepartmentId, WardNumber, BedCount) VALUES (?, ?, ?)";
        $this->query($sql, [$departmentId, $wardNumber, $bedCount]);
        return $this->pdo->lastInsertId();
    }





    // обновить палату
    public function update($id, $departmentId, $wardNumber, $bedCount)
    {
        $sql = "UPDATE {$this->table} SET DepartmentId = ?, WardNumber = ?, BedCount = ? WHERE Id = ?";
        return $this->query($sql, [$departmentId, $wardNumber, $bedCount, $id]);
    }





    // удалить палату
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        return $this->query($sql, [$id]);
    }




    // получить все палаты одного отделения
    public function getByDepartment($departmentId)
    {
        return $this->fetchAll("SELECT * FROM {$this->table} WHERE DepartmentId = ?", [$departmentId]);
    }
}

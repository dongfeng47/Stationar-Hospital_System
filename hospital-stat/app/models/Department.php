<?php
require_once __DIR__ . '/Model.php';

class Department extends Model
{
    protected $table = 'Department';

    public function getAll(): array
    {
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY Name");
    }

    public function getById(int $id): ?array
    {
        $result = $this->fetch("SELECT * FROM {$this->table} WHERE Id = ?", [$id]);
        return $result !== false ? $result : null;
    }

    public function create(string $name): int
    {
        $sql = "INSERT INTO {$this->table} (Name) VALUES (?)";
        $this->query($sql, [$name]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, string $name): bool
    {
        $sql = "UPDATE {$this->table} SET Name = ? WHERE Id = ?";
        $stmt = $this->query($sql, [$name, $id]);
        return $stmt !== false;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE Id = ?";
        $stmt = $this->query($sql, [$id]);
        return $stmt !== false;
    }
}

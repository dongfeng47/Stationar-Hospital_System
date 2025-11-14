<?php
require_once __DIR__ . '/Model.php';

class User extends Model
{
    protected $table = 'Users';

    public function getByUsername($username)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE Username = ?", [$username]);
    }

    public function create($username, $password, $role = 'doctor')
    {
        $hash = hash('sha256', $password);
        $sql = "INSERT INTO {$this->table} (Username, PasswordHash, Role) VALUES (?, ?, ?)";
        $this->query($sql, [$username, $hash, $role]);
        return $this->pdo->lastInsertId();
    }
}

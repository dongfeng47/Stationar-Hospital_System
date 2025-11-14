<?php
require_once __DIR__ . '/Model.php';

class Log extends Model
{
    protected $table = 'Logs';

    // получить все логи с информацией о пользователе
    public function getAll(): array
    {
        $sql = "SELECT l.Id, l.Action, l.CreatedAt, u.Username
                FROM {$this->table} l
                LEFT JOIN Users u ON l.UserId = u.Id
                ORDER BY l.CreatedAt DESC";
        return $this->fetchAll($sql);
    }

    // создать лог
    public function create(?int $userId, string $action): int
    {
        $sql = "INSERT INTO {$this->table} (UserId, Action) VALUES (?, ?)";
        $this->query($sql, [$userId, $action]);
        return (int)$this->pdo->lastInsertId();
    }
}

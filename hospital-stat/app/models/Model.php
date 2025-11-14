<?php 

 //базовый класс для всех моделей
 

use App\Controllers\ErrorDbTableNotFoundController;
use App\Controllers\ErrorDbColumnNotFoundController;

class Model
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }



    protected function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;

        } catch (\PDOException $e) {
            $message = $e->getMessage();

            // таблица не найдена
            if (str_contains($message, '1146')) {
                preg_match('/Table \'[^\']*\.([^\']*)\'/', $message, $matches);
                $table = $matches[1] ?? 'неизвестная';
                $content = ErrorDbTableNotFoundController::getContent($table);
                include __DIR__ . '/../views/layouts/main.php';
                exit;
            }

            //  колонка не найдена
            if (str_contains($message, '1054')) {
                preg_match("/Unknown column '([^']*)'/", $message, $matches);
                $column = $matches[1] ?? 'неизвестная';
                $content = ErrorDbColumnNotFoundController::getContent($column);
                include __DIR__ . '/../views/layouts/main.php';
                exit;
            }

            // стальные ошибки  пробрасываем
            throw $e;
        }
    }

    protected function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    protected function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }
}

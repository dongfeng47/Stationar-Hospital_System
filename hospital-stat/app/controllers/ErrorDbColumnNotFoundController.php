<?php
namespace App\Controllers;

class ErrorDbColumnNotFoundController
{
    public static function getContent(string $column = ''): string
    {
        $columnName = $column;
        return __DIR__ . '/../views/failed/column_not_found_content.php';
    }
}

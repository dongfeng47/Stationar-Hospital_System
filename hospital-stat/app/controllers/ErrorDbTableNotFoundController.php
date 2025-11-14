<?php
namespace App\Controllers;

class ErrorDbTableNotFoundController
{
    
    public static function getContent(string $table = ''): string
    {
        return __DIR__ . '/../views/failed/table_not_found_content.php';
    }
}

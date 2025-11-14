<?php
namespace App\Controllers;

class ErrorDbConnectionController
{
    public static function show()
    {
        http_response_code(500);
        require_once dirname(__DIR__) . '/views/failed/db_connection_error.php';
        exit;
    }
}

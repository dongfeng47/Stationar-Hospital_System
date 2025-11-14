<?php
namespace App\Controllers;

class ErrorDbNotCreatedController
{
    public static function show()
    {
        http_response_code(500);

       
        require_once __DIR__ . '/views/../../views/failed/db_not_create.php';
      
        exit;
    }
}

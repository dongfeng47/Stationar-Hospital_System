<?php
namespace App\Controllers;

class ErrorUsersNotCreatedController
{
    public static function show(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        ob_start();
        ?>
        <div id="users-table-error-overlay" class="error-overlay">
            <div class="error-card">
    <h2><?= __('db_error') ?></h2>
     <p><?= __('table_not_created') ?> <strong><?= __('login_table') ?></strong>.</p>
     <p><?= __('please_create_table') ?></p>
         </div>
        </div>

        <style>
            .error-overlay {
                position: fixed;
                top:0; left:0; width:100%; height:100%;
                display:flex;
                justify-content:center;
                align-items:center;
                background: rgba(0,0,0,0.4);
                z-index: 9999;
                pointer-events: auto;
            }

            .error-card {
                background: linear-gradient(145deg, #ffe5b4, #ffd6a5);
                padding: 2em 2.5em;
                border-radius: 16px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.35);
                max-width: 480px;
                width: 90%;
                text-align: center;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                transform: translateY(-30px);
                opacity: 0;
                animation: slideIn 0.5s forwards;
            }

            @keyframes slideIn {
                from { opacity:0; transform: translateY(-30px); }
                to { opacity:1; transform: translateY(0); }
            }

            @keyframes slideOut {
                from { opacity:1; transform: translateY(0); }
                to { opacity:0; transform: translateY(-20px); }
            }
        </style>

        <script>
            const overlay = document.getElementById('users-table-error-overlay');
            const card = overlay.querySelector('.error-card');

        
            setTimeout(() => {
                card.style.animation = 'slideOut 0.5s forwards';
                setTimeout(() => overlay.remove(), 500);
            }, 5000);
        </script>
        <?php

        $_SESSION['usersTableMissingContent'] = ob_get_clean();

        include __DIR__ . '/../views/auth/login.php';
        exit;
    }
}

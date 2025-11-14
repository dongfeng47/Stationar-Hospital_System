<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'ru' ?>">
<head>
    <meta charset="UTF-8">
    <title><?= __('db_connection_error_title') ?></title>
    <style>
        body {
            font-family: sans-serif;
            background: linear-gradient(135deg, #f9f9f9, #e0e0e0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            position: relative;
            background: #fff;
            padding: 3em 2.5em;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            max-width: 800px;
            width: 90%;
            animation: fadeIn 0.6s ease-out;
        }

        .card img.cat {
            width: 270px;
            height: 180px;
            object-fit: contain;
        }

        .content {
            flex: 1;
            margin: 0 25px;
            text-align: center;
        }

        h1 {
            color: #e74c3c;
            margin-bottom: 1rem;
            font-size: 2.2rem;
        }

        p {
            color: #555;
            margin: 0.5rem 0 1.5rem 0;
            line-height: 1.5;
        }

        code {
            background: #f1f1f1;
            padding: 3px 6px;
            border-radius: 5px;
            font-size: 0.95rem;
            font-family: monospace;
        }

        .btn {
            display: inline-block;
            background: #e74c3c;
            color: #fff;
            padding: 0.75em 1.5em;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="public/assets/icons/no_db.png" alt="No Database" class="db-icon">
        <div class="content">
            <h1><?= __('db_connection_error') ?></h1>
            <p><?= __('database_missing') ?></p>
            <p><?= __('check_env_file') ?></p>
            <button class="btn" onclick="location.reload()"><?= __('reload') ?></button>
        </div>
        <img src="public/assets/icons/error_cat.png" alt="Error Cat" class="cat">
    </div>
</body>
</html>

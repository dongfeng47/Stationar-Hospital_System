<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
<title><?= __('table_not_found_title') ?></title>
<style>
    body {
        font-family: Arial, sans-serif;
   background: #ffebee;
  display: flex;
  justify-content: center;
     align-items: center;
  height: 100vh;
        margin: 0;
    }

    .card {
 background: #fff;
 padding: 3em 2em;
  border-radius: 12px;
 box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        text-align: center;
   max-width: 450px;
        width: 90%;
    }

    h1 { color: #c0392b; margin-bottom: 1rem; }
    p { color: #333; margin-bottom: 2rem; }
.btn {
 background: #c0392b;
     color: #fff;
  padding: 0.75em 1.5em;
  border-radius: 6px;
 font-weight: bold;
  border: none;
        cursor: pointer;
    }
    .btn:hover { background: #922b21; }
</style>
</head>
<body>
    <div class="card">
 <h1><?= __('db_error') ?></h1>
 <p>
 <?= __('table_not_found') ?> <strong><?= htmlspecialchars($tableName ?: __('unknown_table')) ?></strong>.<br>
            <?= __('check_tables_created') ?>
 </p>
<button class="btn" onclick="location.reload()"><?= __('reload') ?></button>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'ru' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= __('app_name') ?></title>
<link rel="stylesheet" href="public/css/<?= htmlspecialchars($_SESSION['theme'] ?? 'juice-orange.css') ?>">
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
 <main>
<?php
// контента страницы
if (!empty($content)) {
     if (file_exists($content)) {
         include $content;
        } else {
    echo $content; // текст ошибки   запреn
            }
        }
        ?>
</main>
 <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

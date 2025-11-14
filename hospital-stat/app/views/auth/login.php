<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../config/lang.php';
$theme = $_SESSION['theme'] ?? 'juice-orange.css';
$lang  = $_SESSION['lang'] ?? 'ru';

//  Если есть ошибка о таблице Users карточку

if (!empty($_SESSION['usersTableMissingContent'])) {
    echo $_SESSION['usersTableMissingContent'];
    unset($_SESSION['usersTableMissingContent']);
}

?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= __('login_page_title') ?> — <?= __('app_name') ?></title>
<link rel="stylesheet" href="public/css/<?= htmlspecialchars($theme) ?>">
</head>
<body class="body404">

<header class="auth-header404">
<div class="auth-header-container404">
<img src="public/assets/icons/app_logo_icon.png" alt="Logo" class="auth-logo404">
 <h1><?= __('app_name') ?></h1>
</div>
</header>

<div class="login-wrapper404">
    <div class="login-container404">
<div class="login-card404">
     <h2><?= __('login') ?></h2>

 <?php if (!empty($error)): ?>
 <p class="error404"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="index.php?controller=auth&action=login" method="post">
<div class="form-group404">
 <label for="username" class="label404"><?= __('username') ?></label>
 <input type="text" id="username" name="username" class="input404" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
</div>
 <div class="form-group404">
<label for="password" class="label404"><?= __('password') ?></label>
<input type="password" id="password" name="password" class="input404" required>
</div>
 <button type="submit" class="btn404"><?= __('login_button') ?></button>
</form>
</div>
</div>
</div>

<footer class="auth-footer404">
<div class="auth-footer-container404">
     <p>&copy; <?= date('Y') ?> <?= __('app_name') ?>. <?= __('all_rights_reserved') ?></p>
    </div>
</footer>

</body>
</html>

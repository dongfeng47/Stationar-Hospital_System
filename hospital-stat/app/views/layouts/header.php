<?php
// Если меню не передано  
if (empty($menuItems) && class_exists('DashboardController')) {
    $role = $_SESSION['user']['Role'] ?? 'admin';
    $menuItems = DashboardController::getMenuByRole($role);
}
?>
<header style="position: relative; padding: 10px 20px;"> 
<h1>
<img src="public/assets/icons/app_logo_icon.png" alt="Logo" style="width:30px; height:30px; vertical-align: middle; margin-right:8px;">
<?= __('dashboard') ?>
</h1>
<nav>
<a href="index.php?controller=dashboard&action=index"><?= __('dashboard') ?></a>
 <?php if (!empty($menuItems)): ?>
<?php foreach ($menuItems as $label => $controller): ?>
<a href="index.php?controller=<?= $controller ?>&action=index"><?= $label ?></a>
<?php endforeach; ?>
<?php endif; ?>

<?php if (isset($_SESSION['user'])): ?>
            <span style="margin-left:20px;">
                <?= htmlspecialchars($_SESSION['user']['Username']) ?> (<?= $_SESSION['user']['Role'] ?>)
</span>
          
<a href="index.php?controller=auth&action=logout" 
style="position: absolute; top: 10px; right: 20px; display: flex; align-items: center; text-decoration: none; color: #f44336; font-weight:bold;">
<img src="public/assets/icons/logout.png" alt="Logout" style="width:20px; height:20px; margin-right:5px;">
<?= __('logout') ?>
</a>
<?php endif; ?>
    </nav>
    <hr>
</header>

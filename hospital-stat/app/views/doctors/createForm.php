<?php
AuthController::checkRole(['admin']);
?>

<h2><?= __('add_doctor') ?></h2>

<form action="index.php?controller=doctors&action=create" method="post">
<label><?= __('full_name') ?>:</label>
<input type="text" name="fullName" required>

<label><?= __('position') ?>:</label>
 <input type="text" name="position">

<label><?= __('phone') ?>:</label>
    <input type="text" name="phone">

    <button type="submit"><?= __('save') ?></button>
</form>

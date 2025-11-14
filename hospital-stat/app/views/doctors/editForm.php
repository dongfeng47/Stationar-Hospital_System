<?php
AuthController::checkRole(['admin']);

if (!isset($doctor) || !$doctor) {
    echo "<p>" . __('doctor_not_found') . "</p>";
    return;
}
?>

<h2><?= __('edit_doctor') ?></h2>

<form action="index.php?controller=doctors&action=edit&id=<?= $doctor['Id'] ?>" method="post">
<label><?= __('full_name') ?>:</label>
<input type="text" name="fullName" value="<?= htmlspecialchars($doctor['FullName']) ?>" required>

<label><?= __('position') ?>:</label>
<input type="text" name="position" value="<?= htmlspecialchars($doctor['Position'] ?? '') ?>">

    <label><?= __('phone') ?>:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($doctor['Phone'] ?? '') ?>">

    <button type="submit"><?= __('save') ?></button>
</form>

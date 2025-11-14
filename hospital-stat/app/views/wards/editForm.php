<h3><?= __('edit_ward') ?></h3>

<?php if ($ward): ?>
<form action="index.php?controller=ward&action=edit&id=<?= $ward['Id'] ?>" method="post">
    <label><?= __('department') ?>:</label>
    <select name="departmentId" required>
        <?php foreach($departments as $d): ?>
    <option value="<?= $d['Id'] ?>" <?= $d['Id'] == $ward['DepartmentId'] ? 'selected' : '' ?>>
 <?= htmlspecialchars($d['Name']) ?>
 </option>
 <?php endforeach; ?>
</select>

<label><?= __('ward_number') ?>:</label>
    <input type="text" name="wardNumber" value="<?= htmlspecialchars($ward['WardNumber']) ?>" required>

    <label><?= __('bed_count') ?>:</label>
    <input type="number" name="bedCount" value="<?= $ward['BedCount'] ?>" min="1" required>

    <button type="submit"><?= __('save') ?></button>
</form>
<?php else: ?>
    <p><?= __('ward_not_found') ?></p>
<?php endif; ?>

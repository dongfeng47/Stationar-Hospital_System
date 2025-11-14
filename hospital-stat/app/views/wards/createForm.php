<h3><?= __('add_ward') ?></h3>
<form action="index.php?controller=ward&action=create" method="post">
    <label><?= __('department') ?>:</label>
<select name="departmentId" required>
<?php foreach($departments as $d): ?>
 <option value="<?= $d['Id'] ?>"><?= htmlspecialchars($d['Name']) ?></option>
 <?php endforeach; ?>
 </select>

<label><?= __('ward_number') ?>:</label>
<input type="text" name="wardNumber" required>

<label><?= __('bed_count') ?>:</label>
<input type="number" name="bedCount" min="1" required>

<button type="submit"><?= __('save') ?></button>
</form>

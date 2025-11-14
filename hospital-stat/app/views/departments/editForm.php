<h3><?= __('edit_department') ?></h3>
<form action="index.php?controller=department&action=edit&id=<?= $department['Id'] ?>" method="post">
<input type="text" name="name" value="<?= htmlspecialchars($department['Name']) ?>" required>
<button type="submit"><?= __('save') ?></button>
</form>

<h3><?= __('add_department') ?></h3>
<form action="index.php?controller=department&action=create" method="post">
<label><?= __('name') ?>:</label>
<input type="text" name="name" required>
    <button type="submit"><?= __('save') ?></button>
</form>

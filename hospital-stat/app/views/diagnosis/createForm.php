<h3><?= __('add_diagnosis') ?></h3>

<?php if(!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="index.php?controller=diagnosis&action=create" method="post">
<label><?= __('diagnosis_name') ?>:</label>
<input type="text" name="diagnosisName" required>
 <button type="submit"><?= __('save') ?></button>
</form>

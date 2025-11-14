<h3><?= __('edit_diagnosis') ?></h3>

<?php if(!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="index.php?controller=diagnosis&action=edit&id=<?= $diagnosis['Id'] ?>" method="post">
 <input type="hidden" name="id" value="<?= $diagnosis['Id'] ?>">
<label><?= __('diagnosis_name') ?>:</label>
 <input type="text" name="diagnosisName" value="<?= htmlspecialchars($diagnosis['DiagnosisName']) ?>" required>
    <button type="submit"><?= __('save') ?></button>
</form>

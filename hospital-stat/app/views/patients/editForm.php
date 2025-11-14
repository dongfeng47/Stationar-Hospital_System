<h2><?= __('edit_patient') ?></h2>

<form action="index.php?controller=patient&action=edit&id=<?= $patient['Id'] ?>" method="post">
    <label for="fullName"><?= __('full_name') ?>:</label>
<input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($patient['FullName']) ?>" required>

<label for="gender"><?= __('gender') ?>:</label>
<select id="gender" name="gender" required>
<option value="M" <?= $patient['Gender'] === 'M' ? 'selected' : '' ?>><?= __('male') ?></option>
<option value="F" <?= $patient['Gender'] === 'F' ? 'selected' : '' ?>><?= __('female') ?></option>
</select>

<label for="birthDate"><?= __('birth_date') ?>:</label>
 <input type="date" id="birthDate" name="birthDate" value="<?= $patient['BirthDate'] ?>" required>

<button type="submit"><?= __('save') ?></button>
</form>

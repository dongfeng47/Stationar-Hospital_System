<h2><?= __('add_patient') ?></h2>

<form action="index.php?controller=patient&action=create" method="post">
<label for="fullName"><?= __('full_name') ?>:</label>
<input type="text" id="fullName" name="fullName" required>

<label for="gender"><?= __('gender') ?>:</label>
<select id="gender" name="gender" required>
<option value="M"><?= __('male') ?></option>
 <option value="F"><?= __('female') ?></option>
</select>
<label for="birthDate"><?= __('birth_date') ?>:</label>
<input type="date" id="birthDate" name="birthDate" required>

<button type="submit"><?= __('save') ?></button>
</form>

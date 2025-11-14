<h3><?= __('edit_procedure') ?></h3>

<?php if(!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="index.php?controller=medicalprocedure&action=edit&id=<?= $procedure['Id'] ?>" method="post">
    <label><?= __('hospitalization_id') ?>:</label>
    <select name="HospitalizationId" required>
        <option value=""><?= __('select_hospitalization') ?></option>
        <?php foreach($hospitalizations as $hosp): ?>
            <option value="<?= $hosp['Id'] ?>"
 <?= $hosp['Id'] == $procedure['HospitalizationId'] ? 'selected' : '' ?>>
  <?= $hosp['Id'] ?> — <?= htmlspecialchars($hosp['PatientName'] ?? 'Пациент не найден') ?>
  (<?= htmlspecialchars($hosp['AdmissionDate']) ?> — <?= htmlspecialchars($hosp['DischargeDate']) ?>)
 </option>
    <?php endforeach; ?>
    </select>
    <br>

    <label><?= __('procedure_name') ?>:</label>
    <input type="text" name="ProcedureName" value="<?= htmlspecialchars($procedure['ProcedureName']) ?>" required>
    <br>

    <label><?= __('procedure_date') ?>:</label>
    <input type="date" name="ProcedureDate" value="<?= htmlspecialchars($procedure['ProcedureDate']) ?>" required>
    <br>

    <button type="submit"><?= __('save') ?></button>
</form>

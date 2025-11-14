<h3><?= __('add_procedure') ?></h3>

<?php if(!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="index.php?controller=medicalprocedure&action=create" method="post">
    <label><?= __('hospitalization_id') ?>:</label>
    <select name="HospitalizationId" required>
        <option value=""><?= __('select_hospitalization') ?></option>
        <?php foreach($hospitalizations as $hosp): ?>
            <option value="<?= $hosp['Id'] ?>">
 <?= $hosp['Id'] ?> — <?= htmlspecialchars($hosp['PatientName'] ?? 'Пациент не найден') ?>
 (<?= htmlspecialchars($hosp['AdmissionDate']) ?> — <?= htmlspecialchars($hosp['DischargeDate']) ?>)
 </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label><?= __('procedure_name') ?>:</label>
    <input type="text" name="ProcedureName" required>
    <br>

    <label><?= __('procedure_date') ?>:</label>
    <input type="date" name="ProcedureDate" value="<?= date('Y-m-d') ?>" required>
    <br>

    <button type="submit"><?= __('save') ?></button>
</form>

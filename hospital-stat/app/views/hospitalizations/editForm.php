<form action="index.php?controller=hospitalization&action=edit&id=<?= $hospitalization['Id'] ?>" method="post">
    <label><?= __('patient') ?>:</label>
<select name="PatientId" required>
 <option value=""><?= __('select_patient') ?></option>
 <?php foreach($patients as $p): ?>
    <option value="<?= $p['Id'] ?>" <?= $p['Id'] == $hospitalization['PatientId'] ? 'selected' : '' ?>>
     <?= htmlspecialchars($p['FullName']) ?>
 </option>
 <?php endforeach; ?>
    </select><br>

<label><?= __('ward') ?>:</label>
    <select name="WardId" required>
 <option value=""><?= __('select_ward') ?></option>
 <?php foreach($wards as $w): ?>
            <option value="<?= $w['Id'] ?>" <?= $w['Id'] == $hospitalization['WardId'] ? 'selected' : '' ?>>
 №<?= htmlspecialchars($w['WardNumber']) ?>
 </option>
 <?php endforeach; ?>
 </select><br>

<label><?= __('doctor') ?>:</label>
    <select name="DoctorId" required>
 <option value=""><?= __('select_doctor') ?></option>
 <?php foreach($doctors as $d): ?>
 <option value="<?= $d['Id'] ?>" <?= $d['Id'] == $hospitalization['DoctorId'] ? 'selected' : '' ?>>
 <?= htmlspecialchars($d['FullName']) ?>
</option>
 <?php endforeach; ?>
    </select><br>

 <label><?= __('diagnosis') ?>:</label>
<select name="DiagnosisId" required>
 <option value=""><?= __('select_diagnosis') ?></option>
<?php foreach($diagnoses as $diag): ?>
 <option value="<?= $diag['Id'] ?>" <?= $diag['Id'] == $hospitalization['DiagnosisId'] ? 'selected' : '' ?>>
 <?= htmlspecialchars($diag['DiagnosisName']) ?>
 </option>
 <?php endforeach; ?>
    </select><br>

<label><?= __('admission_date') ?>:</label>
 <input type="date" name="AdmissionDate" value="<?= $hospitalization['AdmissionDate'] ?>" required><br>

 <label><?= __('discharge_date') ?>:</label>
<input type="date" name="DischargeDate" value="<?= $hospitalization['DischargeDate'] ?>" required><br>

<button type="submit"><?= __('save') ?></button>
</form>

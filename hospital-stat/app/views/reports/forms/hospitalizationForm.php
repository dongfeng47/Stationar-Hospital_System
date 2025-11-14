<!-- Форма фильтров для отчета по госпитализациям -->

<div class="report-filter">
    <label for="startDate"><?= __('from_admission_date') ?>:</label>
    <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($filters['startDate'] ?? '') ?>">

    <label for="endDate"><?= __('to_admission_date') ?>:</label>
    <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($filters['endDate'] ?? '') ?>">

    <label for="wardId"><?= __('ward') ?>:</label>
    <select id="wardId" name="wardId">
     <option value=""><?= __('all_wards') ?></option>
     <?php foreach($wards as $ward): ?>
     <option value="<?= $ward['Id'] ?>" <?= (isset($filters['wardId']) && $filters['wardId']==$ward['Id']) ? 'selected' : '' ?>>
     <?= htmlspecialchars($ward['WardNumber']) ?> (<?= htmlspecialchars($ward['DepartmentId']) ?>)
    </option>
    <?php endforeach; ?>
    </select>

    <label for="doctorId"><?= __('doctor') ?>:</label>
    <select id="doctorId" name="doctorId">
    <option value=""><?= __('all_doctors') ?></option>
    <?php foreach($doctors as $doctor): ?>
     <option value="<?= $doctor['Id'] ?>" <?= (isset($filters['doctorId']) && $filters['doctorId']==$doctor['Id']) ? 'selected' : '' ?>>
  <?= htmlspecialchars($doctor['FullName']) ?>
 </option>
        <?php endforeach; ?>
    </select>
</div>

<style>
.report-filter {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 400px;
}
.report-filter label {
    font-weight: 600;
    margin-top: 5px;
}
.report-filter input,
.report-filter select {
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}
</style>

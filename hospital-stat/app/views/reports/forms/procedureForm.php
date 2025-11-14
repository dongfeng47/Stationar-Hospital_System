<!-- Форма фильтров для отчета по медицинским процедурам -->
<div class="report-filter">
    <label for="startDate"><?= __('from_procedure_date') ?>:</label>
    <input type="date" id="startDate" name="startDate" 
           value="<?= htmlspecialchars($filters['startDate'] ?? '') ?>">

    <label for="endDate"><?= __('to_procedure_date') ?>:</label>
    <input type="date" id="endDate" name="endDate" 
           value="<?= htmlspecialchars($filters['endDate'] ?? '') ?>">

    <label for="doctorId"><?= __('doctor') ?>:</label>
    <select id="doctorId" name="doctorId">
        <option value=""><?= __('all_doctors') ?></option>
        <?php if (!empty($doctors)): ?>
  <?php foreach ($doctors as $doctor): ?>
    <option value="<?= htmlspecialchars($doctor['Id']) ?>"
   <?= (isset($filters['doctorId']) && $filters['doctorId'] == $doctor['Id']) ? 'selected' : '' ?>>
    <?= htmlspecialchars($doctor['FullName']) ?>
  <?php if (!empty($doctor['Position'])): ?>
      (<?= htmlspecialchars($doctor['Position']) ?>)
     <?php endif; ?>
     </option>
    <?php endforeach; ?>
     <?php endif; ?>
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

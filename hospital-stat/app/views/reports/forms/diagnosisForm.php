 <!-- Форма фильтров для отчета по диагнозам --> 
<label for="startDate"><?= __('from_date') ?>:</label>
<input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($filters['startDate'] ?? '') ?>">

<label for="endDate"><?= __('to_date') ?>:</label>
<input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($filters['endDate'] ?? '') ?>">   
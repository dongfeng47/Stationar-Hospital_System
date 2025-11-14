<div class="section-header">
<h2><?= __('diagnoses') ?></h2>
<a href="index.php?controller=diagnosis&action=createForm" class="add-button"><?= __('add_diagnosis') ?></a>
</div>

<table class="responsive-table">
<thead>
    <tr>
<th><?= __('id') ?></th>
  <th><?= __('diagnosis_name') ?></th>
<th><?= __('actions') ?></th>
</tr>
    </thead>
    <tbody>
<?php foreach($diagnoses as $d): ?>
    <tr>
 <td><?= htmlspecialchars($d['Id']) ?></td>
 <td><?= htmlspecialchars($d['DiagnosisName']) ?></td>
    <td>
 <a href="index.php?controller=diagnosis&action=editForm&id=<?= $d['Id'] ?>" class="edit"><?= __('edit') ?></a>
 <a href="index.php?controller=diagnosis&action=delete&id=<?= $d['Id'] ?>" onclick="return confirm('<?= __('confirm_delete') ?>')" class="delete"><?= __('delete') ?></a>
</td>
 </tr>
 <?php endforeach; ?>
</tbody>
</table>

<div class="section-header">
<h2><?= __('add_hospitalization') ?></h2>
<a href="index.php?controller=hospitalization&action=createForm" class="add-button"><?= __('add') ?></a>
</div>
<table class="responsive-table">
<thead>
        <tr>
<th><?= __('id') ?></th>
<th><?= __('patient') ?></th>
<th><?= __('ward') ?></th>
   <th><?= __('doctor') ?></th>
    <th><?= __('diagnosis') ?></th>
    <th><?= __('admission_date') ?></th>
 <th><?= __('discharge_date') ?></th>
   <th><?= __('actions') ?></th>
  </tr>
</thead>
<tbody>
 <?php foreach($hospitalizations as $h): ?>
<tr>
<td><?= $h['Id'] ?></td>
 <td><?= htmlspecialchars($h['PatientName']) ?></td>
 <td>№<?= htmlspecialchars($h['WardNumber']) ?></td>
 <td><?= htmlspecialchars($h['DoctorName']) ?></td>
<td><?= htmlspecialchars($h['DiagnosisName']) ?></td>
 <td><?= $h['AdmissionDate'] ?></td>
 <td><?= $h['DischargeDate'] ?: '—' ?></td>
<td>
<a href="index.php?controller=hospitalization&action=editForm&id=<?= $h['Id'] ?>" class="edit"><?= __('edit') ?></a>
<a href="index.php?controller=hospitalization&action=delete&id=<?= $h['Id'] ?>" onclick="return confirm('<?= __('confirm_delete') ?>')" class="delete"><?= __('delete') ?></a>
 </td>
</tr>
 <?php endforeach; ?>
 </tbody>
</table>

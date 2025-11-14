<div class="section-header">
    <h2><?= __('procedures') ?></h2>
    <a href="index.php?controller=medicalprocedure&action=createForm" class="add-button"><?= __('add_procedure') ?></a>
</div>

<table class="responsive-table">
    <thead>
        <tr>
 <th><?= __('id') ?></th>
 <th><?= __('hospitalization') ?></th>
<th><?= __('procedure_name') ?></th>
<th><?= __('procedure_date') ?></th>
 <th><?= __('actions') ?></th>
        </tr>
    </thead>
    <tbody>
 <?php foreach($procedures as $p): ?>
 <tr>
 <td><?= htmlspecialchars($p['Id']) ?></td>
 <td>
  <?= htmlspecialchars($p['HospitalizationId']) ?> —
 <?= htmlspecialchars($p['PatientName'] ?? 'Пациент не найден') ?>
(<?= htmlspecialchars($p['AdmissionDate']) ?> — <?= htmlspecialchars($p['DischargeDate']) ?>)
 </td>
 <td><?= htmlspecialchars($p['ProcedureName']) ?></td>
 <td>
<?= date('Y-m-d', strtotime($p['ProcedureDate'])) ?>
 </td>
<td>
<a href="index.php?controller=medicalprocedure&action=editForm&id=<?= $p['Id'] ?>" class="edit"><?= __('edit') ?></a>
<a href="index.php?controller=medicalprocedure&action=delete&id=<?= $p['Id'] ?>" onclick="return confirm('<?= __('confirm_delete') ?>')" class="delete"><?= __('delete') ?></a>
     </td>
     </tr>
     <?php endforeach; ?>
    </tbody>
</table>

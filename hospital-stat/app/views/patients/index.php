<div class="section-header">
<h2><?= __('patients') ?></h2>
<a href="index.php?controller=patient&action=createForm" class="add-button"><?= __('add_patient') ?></a>
</div>

<table class="responsive-table">
<thead><tr>
 <th>ID</th>
<th><?= __('full_name') ?></th>
<th><?= __('gender') ?></th>
<th><?= __('birth_date') ?></th>
<th><?= __('actions') ?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach($patients as $p): ?>
<tr>
 <td><?= $p['Id'] ?></td>
<td><?= htmlspecialchars($p['FullName']) ?></td>
    <td><?= $p['Gender'] ?></td>
 <td><?= $p['BirthDate'] ?></td>
    <td>
<a href="index.php?controller=patient&action=editForm&id=<?= $p['Id'] ?>" class="edit"><?= __('edit') ?></a>
<a href="index.php?controller=patient&action=delete&id=<?= $p['Id'] ?>" class="delete" onclick="return confirm('<?= __('confirm_delete') ?>');"><?= __('delete') ?></a>
    </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>

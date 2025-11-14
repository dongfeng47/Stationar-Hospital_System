<div class="section-header">
 <h2><?= __('doctors') ?></h2>
<a href="index.php?controller=doctors&action=createForm" class="add-button"><?= __('add_doctor') ?></a>
</div>

<table class="responsive-table">
<thead>
<tr>
<th><?= __('ID') ?></th>
 <th><?= __('full_name') ?></th>
<th><?= __('position') ?></th>
<th><?= __('phone') ?></th>
 <th><?= __('actions') ?></th>
</tr>
</thead>
    <tbody>
<?php foreach($doctors as $d): ?>
<tr>
<td><?= $d['Id'] ?></td>
<td><?= htmlspecialchars($d['FullName']) ?></td>
 <td><?= htmlspecialchars($d['Position']) ?></td>
<td><?= htmlspecialchars($d['Phone']) ?></td>
<td>
<a href="index.php?controller=doctors&action=editForm&id=<?= $d['Id'] ?>" class="edit"><?= __('edit') ?></a>
<a href="index.php?controller=doctors&action=delete&id=<?= $d['Id'] ?>" onclick="return confirm('<?= __('confirm_delete') ?>');" class="delete"><?= __('delete') ?></a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

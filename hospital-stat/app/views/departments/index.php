<div class="section-header">
    <h2><?= __('departments') ?></h2>
    <a href="index.php?controller=department&action=createForm" class="add-button"><?= __('add_department') ?></a>
</div>

<table class="responsive-table">
<thead>
<tr>
 <th>ID</th>
 <th><?= __('name') ?></th>
<th><?= __('actions') ?></th>
</tr>
</thead>
<tbody>
 <?php foreach($departments as $d): ?>
<tr>
 <td><?= $d['Id'] ?></td>
<td><?= htmlspecialchars($d['Name']) ?></td>
 <td>
<a href="index.php?controller=department&action=editForm&id=<?= $d['Id'] ?>" class="edit"><?= __('edit') ?></a>
<a href="index.php?controller=department&action=delete&id=<?= $d['Id'] ?>" onclick="return confirm('<?= __('confirm_delete') ?>')" class="delete"><?= __('delete') ?></a>
</td>
</tr>
 <?php endforeach; ?>
</tbody>
</table>

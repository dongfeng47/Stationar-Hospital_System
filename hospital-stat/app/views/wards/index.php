<div class="section-header">
    <h2><?= __('wards') ?></h2>
    <a href="index.php?controller=ward&action=createForm" class="add-button"><?= __('add_ward') ?></a>
</div>

<table class="responsive-table">
    <thead>
        <tr>
<th>ID</th>
<th><?= __('department') ?></th>
 <th><?= __('ward_number') ?></th>
 <th><?= __('bed_count') ?></th>
 <th><?= __('actions') ?></th>
</tr>
    </thead>
    <tbody>
    <?php foreach($wards as $w): ?>
        <tr>
 <td><?= $w['Id'] ?></td>
 <td><?= htmlspecialchars($w['DepartmentName']) ?></td>
     <td><?= htmlspecialchars($w['WardNumber']) ?></td>
     <td><?= $w['BedCount'] ?></td>
 <td>
     <a href="index.php?controller=ward&action=editForm&id=<?= $w['Id'] ?>" class="edit"><?= __('edit') ?></a>
 <a href="index.php?controller=ward&action=delete&id=<?= $w['Id'] ?>" onclick="return confirm('<?= __('confirm_delete') ?>')" class="delete"><?= __('delete') ?></a>
 </td>
     </tr>
 <?php endforeach; ?>
    </tbody>
</table>

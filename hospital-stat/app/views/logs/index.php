<div class="section-header">
<h2><?= __('logs') ?></h2>
</div>

<table class="responsive-table">
<thead>
<tr>
<th>ID</th>
<th><?= __('user') ?></th>
<th><?= __('action') ?></th>
 <th><?= __('created_at') ?></th>
</tr>
</thead>
    <tbody>
<?php foreach($logs as $log): ?>
        <tr>
 <td><?= $log['Id'] ?></td>
            <td><?= htmlspecialchars($log['Username'] ?? '-') ?></td>
 <td><?= htmlspecialchars($log['Action']) ?></td>
  <td><?= $log['CreatedAt'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>     
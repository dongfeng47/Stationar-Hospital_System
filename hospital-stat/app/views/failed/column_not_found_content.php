<div class="card" 
style="max-width:450px; 
margin:2em auto; 
padding:2em; 
background:#ffe6e6; 
border-radius:12px; 
text-align:center; 
box-shadow:0 10px 25px rgba(0,0,0,0.2);">
<h1 style="color:#c0392b; 
margin-bottom:1rem;">
<?= __('db_error') ?>
</h1>
<p>
<?= __('column_not_found') ?> <strong><?= htmlspecialchars($columnName ?? __('unknown_column')) ?></strong>
</p>
<p>
<?= __('check_table_structure') ?>
</p>
<button onclick="location.reload()" 
style="background:#c0392b; 
color:#fff; 
padding:0.75em 1.5em; 
border-radius:6px; 
font-weight:bold; 
border:none; 
cursor:pointer;">
<?= __('reload') ?>
</button>
</div>

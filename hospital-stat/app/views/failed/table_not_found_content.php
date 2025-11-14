<div class="card" 
 style="max-width:450px; 
   margin:2em auto; padding:2em; 
  background:#fff3e0; 
 border-radius:12px; 
   text-align:center; 
   box-shadow:0 10px 25px rgba(0,0,0,0.2);">
<h1 style="color:#d35400; 
  margin-bottom:1rem;"><?= __('db_error') ?></h1>
  <p><?= __('table_not_found') ?> <strong><?= htmlspecialchars($tableName ?? __('unknown_table')); ?></strong>.
   </p>
<p>
    <?= __('check_tables_created') ?>
</p>
   <button onclick="location.reload()" 
 style="background:#d35400; 
            color:#fff; padding:0.75em 1.5em; 
 border-radius:6px; font-weight:bold; 
                    border:none; 
  cursor:pointer;">
 <?= __('reload') ?>
    </button>
 </div>

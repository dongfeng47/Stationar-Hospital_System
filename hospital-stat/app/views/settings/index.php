<div class="settings">
    <h2><?= __('settings') ?></h2>

<form action="index.php?controller=settings&action=save" method="post" class="settings-form">
      
<div class="form-group">
            <label><?= __('language') ?>:</label>
  <select name="language">
     <option value="ru" <?= ($_SESSION['lang'] ?? 'ru') === 'ru' ? 'selected' : '' ?>><?= __('lang_ru') ?></option>
     <option value="kg" <?= ($_SESSION['lang'] ?? 'ru') === 'kg' ? 'selected' : '' ?>><?= __('lang_kg') ?></option>
 </select>
     </div>


 <div class="form-group">
            <label><?= __('theme') ?>:</label>
 <select name="theme">
  <?php foreach ($themes as $file => $name): ?>
  <option value="<?= htmlspecialchars($file) ?>" <?= ($_SESSION['theme'] ?? 'juice-orange.css') === $file ? 'selected' : '' ?>>
  <?= htmlspecialchars($name) ?>
   </option>
  <?php endforeach; ?>
 </select>
 </div>
  <button type="submit" class="settbutton"><?= __('save') ?></button>
    </form>
</div>




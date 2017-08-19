<?php
$appTitle = 'Pretraživanje';
$pageTitle = 'Pretraživanje';
$activeApp = 'search';
$activeAppURL = '';
$appColor = 'blue-grey darken-4';
include 'header.php';
?>
<div class="container">


<form action="<?php echo domainpath.activeInstance; ?>/search/query" method="post">
  <div class="input-field">
    <label for="query">Pretražite Poslovni oblak...</label>
    <input type="text" name="query">
  </div>
  <button class="btn blue-grey darken-4">Pretraži</button>
</form>

</div>
<?php
include 'footer.php';
?>
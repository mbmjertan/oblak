<?php
$appTitle = 'Desktop aplikacija';
$pageTitle = 'Desktop aplikacija';
$activeApp = 'install';
$activeAppURL = 'install';
$appColor = 'blue-grey darken-4';
include 'header.php';
?>
<div class="container">
  <h3>Preuzmite Poslovni oblak za desktop.</h3>
  <div class="row">
    <div class="col s4">
      <a href="/Windows.zip" class="btn blue">Windows (zip, 52.7 MB)</a>
    </div>
    <div class="col s4">
      <a href="/Linux.tgz" class="btn orange">Linux (tgz, 43.3 MB)</a>
    </div>
    <div class="col s4">
      <a href="/OSX.zip" class="btn grey">macOS (zip, 40.9 MB)</a>
    </div>
  </div>
  <p>Nakon preuzimanja, potrebno je samo raspakirati arhivu, pokrenuti aplikaciju i <i>prikvačiti</i> ju za traku pokretanja.</p>
  <p>U polje "Kratko ime instance" unesite: <div class="input-field"><label for="instanceName">Kratko ime instance</label><input type="text" name="instanceName" value="<?php echo activeInstance; ?>"></div></p>
</div>
<?php include 'footer.php'; ?>

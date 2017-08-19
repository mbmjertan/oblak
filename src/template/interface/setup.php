<?php
if (!isset($_COOKIE['oblak_csrf_anon'])) {
  $canon = bin2hex(openssl_random_pseudo_bytes(32));
  setcookie('oblak_csrf_anon', $canon, time() + 60 * 60, null, null, null, true);
}
else {
  $canon = $_COOKIE['oblak_csrf_anon'];
}
if ($canon != $_POST['csrfTokenAnon']) {
  header('Location: /');
  die();
}
$instanceShortname = strtolower($_POST['businessName']);
$instanceShortname = preg_replace("/[^A-Za-z0-9-]/", '', $instanceShortname);

while ($oblak->instanceExists($instanceShortname)) {
  $instanceShortname = $instanceShortname . bin2hex(openssl_random_pseudo_bytes(10));
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Roboto+Mono&subset=latin-ext"
    rel="stylesheet">
  <script type="text/javascript"
          src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?php echo domainpath; ?>template/common/js/momloc.js"></script>
  <script
    src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/picker.js"></script>
  <script
    src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/picker.date.js"></script>
  <script
    src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/picker.time.js"></script>
  <script
    src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/translations/hr_HR.js"></script>
  <link
    href="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/themes/default.css"
    rel="stylesheet">
  <link
    href="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/themes/default.date.css"
    rel="stylesheet">
  <link type="text/css" rel="stylesheet"
        href="/template/interface/materialize/css/materialize.min.css"
        media="screen,projection"/>

  <title>Započnite s korištenjem Poslovnog oblaka</title>
  <link href="/template/interface/pob.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="brand-logo">
    <a href="#"><img
        src="<?php echo domainpath; ?>template/icons/oblakLogoLight.png"
        class="brand-logo-nav"></a>
  </div>
  <form action="/core/createInstance" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrfTokenAnon" value="<?php echo $canon; ?>">
    <input type="hidden" name="email"
           value="<?php echo $oblak->ioPrepare($_POST['email']); ?>">
    <input type="hidden" name="username"
           value="<?php echo $oblak->ioPrepare($_POST['username']); ?>">
    <input type="hidden" name="password"
           value="<?php echo $oblak->ioPrepare($_POST['password']); ?>">
    <input type="hidden" name="adminUsername"
           value="<?php echo $oblak->ioPrepare($_POST['adminUsername']); ?>">
    <input type="hidden" name="adminPassword"
           value="<?php echo $oblak->ioPrepare($_POST['adminPassword']); ?>">
    <input type="hidden" name="businessName"
           value="<?php echo $oblak->ioPrepare($_POST['businessName']); ?>">

    <input type="hidden" name="instanceShortname"
           value="<?php echo $instanceShortname; ?>">

    <p>Pozdrav, <?php echo $oblak->ioPrepare($_POST['username']); ?>
      iz <?php echo $oblak->ioPrepare($_POST['businessName']); ?>.</p>
    <b>Trebali bismo se malo bolje upoznati.</b>
    <div class="input-field">
      <label for="adminName">Vaše ime</label>
      <input type="text" name="adminName" required>
    </div>
    <div class="input-field">
      <label for="adminSurname">Vaše prezime</label>
      <input type="text" name="adminSurname" required>
    </div>
    <div class="input-field">
      <label for="primaryContactEmail">Vaš email</label>
      <input type="email" name="primaryContactEmail" required>
    </div>
    <div class="input-field">
      <label for="primaryContactPhoneNumber">Vaš broj telefona/mobitela</label>
      <input type="tel" name="primaryContactPhoneNumber" required>
    </div>
    <b>Moramo znati i još nešto o vašoj tvrtci.</b>
    <p>Ime tvrtke: <?php echo $_POST['businessName']; ?></p>
    <div class="input-field">
      <label for="businessType">Vrsta tvrtke (primjerice, d.o.o. ili
        d.d.)</label>
      <input type="text" name="businessType" required>
    </div>
    <div class="input-field">
      <label for="businessMainAddress">Puna adresa vaše tvrtke (primjerice:
        Mašićeva 3a, 10000 Zagreb)</label>
      <input type="text" name="businessMainAddress" required>
    </div>
    <div class="input-field">
      <label for="businessMainPostcode">Poštanski broj vaše tvrtke</label>
      <input type="number" name="businessMainPostcode" min="10000" required>
    </div>
    <div class="input-field">
      <label for="businessMainCity">Grad sjedišta vaše tvrtke</label>
      <input type="text" name="businessMainCity" required>
    </div>
    <div class="input-field">
      <label for="businessWeb">Web vaše tvrtke</label>
      <input type="url" name="businessWeb">
    </div>
    <div class="input-field">
      <label for="businessPhone">Korisnički telefon vaše tvrtke</label>
      <input type="tel" name="businessPhone">
    </div>
    <div class="input-field">
      <label for="businessEmail">Korisnički email vaše tvrtke</label>
      <input type="email" name="businessEmail">
    </div>
    <div class="input-field">
      <label for="IBAN">IBAN računa vaše tvrtke</label>
      <input type="text" name="businessMainIBAN">
    </div>
    <b>Logotip vaše tvrtke</b>
    <p>Trebate dodati logotip vaše tvrtke. Ne brinite, može se mijenjati.</p>
    <div class="file-field input-field">
    <div class="btn blue-grey">
      <span>Odaberite</span>
      <input name="files[]" type="file" multiple required>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text"
             placeholder="Prijenos jedne datoteke">
    </div>
    </div>
    <b>I još samo nešto...</b>
    <p>Provjerite sve podatke i ako su ispravni, kliknite na gumb ispod.</p>
    <button
      class=" btn blue-grey btn-large">
      Započni s korištenjem &rarr;
    </button>

  </form>

</div>
<script type="text/javascript"
        src="/template/interface/materialize/js/materialize.min.js"></script>

<script>
  $(document).ready(function () {
    $("#keyboardShortcutHelp").hide();
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
    $('select').material_select();
  });


</script>

<script>
  window.intercomSettings = {
    app_id: "aiq5dr5a"
  };
</script>
<script>(function () {
    var w = window;
    var ic = w.Intercom;
    if (typeof ic === "function") {
      ic('reattach_activator');
      ic('update', intercomSettings);
    } else {
      var d = document;
      var i = function () {
        i.c(arguments)
      };
      i.q = [];
      i.c = function (args) {
        i.q.push(args)
      };
      w.Intercom = i;
      function l() {
        var s = d.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://widget.intercom.io/widget/aiq5dr5a';
        var x = d.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      }

      if (w.attachEvent) {
        w.attachEvent('onload', l);
      } else {
        w.addEventListener('load', l, false);
      }
    }
  })()</script>

</body>
</html>
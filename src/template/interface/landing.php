<?php
if (!isset($_COOKIE['oblak_csrf_anon'])) {
  $canon = bin2hex(openssl_random_pseudo_bytes(32));
  setcookie('oblak_csrf_anon', $canon, time() + 60 * 60, null, null, null, true);
} else {
  $canon = $_COOKIE['oblak_csrf_anon'];
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
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?php echo domainpath; ?>template/common/js/momloc.js"></script>
  <script src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/picker.js"></script>
  <script src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/picker.date.js"></script>
  <script src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/picker.time.js"></script>
  <script src="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/translations/hr_HR.js"></script>
  <link href="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/themes/default.css" rel="stylesheet">
  <link href="<?php echo domainpath; ?>template/common/pickadate/lib/compressed/themes/default.date.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet"
        href="/template/interface/materialize/css/materialize.min.css"
        media="screen,projection"/>

  <title>Poslovni oblak</title>
  <link href="/template/interface/pob.css" rel="stylesheet">
</head>
<body>
  <div class="landingHeader">
    <div class="landingHeaderNav">
      <div class="brand-logo">
        <a href="<?php echo domainpath;?>"><img src="<?php echo domainpath;?>template/icons/oblakLogoLight.png" class="brand-logo-nav"></a>
      </div>
    </div>
    <div class="row">
    <div class="col m9">
      <h1 class="landingIntro">Odvedite svoju tvrtku u oblake.</h1>
      <h2 class="landingSubtext">Poslovni oblak je set aplikacija koje će olakšati poslovanje i komunikaciju unutar vaše tvrtke.</h2>
    </div>
    <div class="col m3 white z-depth-2">
      <h2 class="landingSubtext">Otvorite vrata revoluciji.</h2>
      <form action="/core/instanceSetup" method="post">
        <input type="hidden" name="landingPageAction" value="createInstance">
        <input type="hidden" name="csrfTokenAnon" value="<?php echo $canon; ?>">
        <div class="input-field">
          <label for="email">E-mail adresa</label>
          <input type="email" name="email" placeholder="hrvoje.horvat@example.com">
        </div>
        <div class="input-field">
          <label for="username">Korisničko ime</label>
          <input type="text" name="username" placeholder="hrvoje">
        </div>

        <div class="input-field">
          <label for="password">Lozinka</label>
          <input type="password" name="password" placeholder="******">
          <small>Prijedlog: <pre style="display:inline;"><?php echo substr(base64_encode(openssl_random_pseudo_bytes(10)),0, -2); ?></pre></small>
        </div>

        <div class="input-field">
          <label for="businessName">Ime tvrtke</label>
          <input type="text" name="businessName" placeholder="Educateam d.o.o.">
        </div>

        <input type="submit" value="Krenimo u akciju! &rarr;" class="btn btn-landing">

      </form>
    </div>
    </div>
  </div>

  <div class="landingSubintro">
    <div class="container">
      <div class="row">
        <div class="col m5">
          <img src="<?php echo domainpath; ?>/template/interface/assets/racuni.png" class="landing-contextimg">
        </div>
        <div class="col m7">
          <h2 class="landingSubtext">Dobra komunikacija ključ je odličnog tima.</h2>
          <p>Zaboravite dijeljenje datoteka preko CD-ova i mailanje faktura. Uštedite na registratorima. Prestanite gubiti vrijeme na softver i organizaciju te posvetite se onome što volite: <b>poslu</b>.</p>
        </div>
      </div>
    </div>
    <div class="container topMargin">
      <h2 class="landingSubtext text-center">Poslovni oblak će olakšati...</h2>
      <div class="row">
        <div class="col s3">
          <div><i class="material-icons" style="font-size:48px;">view_compact</i></div>
          komunikaciju unutar tvrtke
        </div>
        <div class="col s3">
          <div><i class="material-icons" style="font-size:48px;">credit_card</i></div>
          izdavanje računa i ponuda
        </div>
        <div class="col s3">
          <div><i class="material-icons" style="font-size:48px;">cloud_upload</i></div>
          dijeljenje datoteka
        </div>
        <div class="col s3">
         <div><i class="material-icons" style="font-size:48px;">contacts</i></div>
          komunikaciju s klijentima
        </div>
      </div>
    </div>
  </div>

  <div class="container landingPrinciples topMargin">
    <h2 class="landingSubtext text-center">Kako Poslovni oblak funkcionira?</h2>
    <div class="row">
      <div class="col s1">
        <h5>1.</h5>
      </div>
      <div class="col s11">
        <p><b>Registrirate</b> svoju tvrtku na ovoj stranici popunjavanjem nekoliko osnovnih informacijama o Vama i tvrtci. Besplatno je dok god je Poslovni oblak u razvoju.</p>
      </div>
    </div>
    <div class="row">
      <div class="col s1">
        <h5>2.</h5>
      </div>
      <div class="col s11">
        <p><b>Dovedete</b> svoj tim u vaš oblak unošenjem imena i e-mail adresa članova tima. Mi pošaljemo Vašim kolegama e-mail s uputama za prijavu.</p>
      </div>
    </div>
    <div class="row">
      <div class="col s1">
        <h5>3.</h5>
      </div>
      <div class="col s11">
        <p><b>Uživate</b> u modernom alatu za vaše poslovanje. Dijelite novosti, stvarajte račune, spremajte datoteke, kontakte i još štošta pomoću vjerojatno jedinog poslovnog alata s podrškom za emoji. 😊</p>
      </div>
    </div>
  </div>
<div class="grey lighten-4 z-depth-1" style="margin-bottom:0;">
  <div class="grey lighten-4" style="margin-bottom:0;">
    <div class="container">
    <h2 class="landingSubtext text-center">Započnite s korištenjem Poslovnog oblaka već danas.</h2>
    <div class="row">
    <form action="/core/instanceSetup" method="post">
      <input type="hidden" name="landingPageAction" value="createInstance">
      <input type="hidden" name="csrfTokenAnon" value="<?php echo $canon; ?>">
      <div class="col s3 input-field">
        <label for="email">E-mail adresa</label>
        <input type="email" name="email" placeholder="hrvoje.horvat@example.com">
      </div>
      <div class="col s3 input-field">
        <label for="username">Korisničko ime</label>
        <input type="text" name="username" placeholder="hrvoje">
      </div>

      <div class="col s3 input-field">
        <label for="password">Lozinka</label>
        <input type="password" name="password" placeholder="******">
        <small>Prijedlog: <pre style="display:inline;"><?php echo substr(base64_encode(openssl_random_pseudo_bytes(10)),0, -2); ?></pre></small>
      </div>

      <div class="col s3 input-field">
        <label for="businessName">Ime tvrtke</label>
        <input type="text" name="businessName" placeholder="Educateam d.o.o.">
      </div>
    </div>

      <center><input type="submit" value="Krenimo u oblake &rarr;" class="btn btn-landing"></center>

    </form>
  </div>
  </div>

  <div class="grey lighten-2" style="margin-top:0;">
    <div class="container">
      <p style="-webkit-margin-after: 0;-moz-margin-after:0;margin-after:0;">&copy; 2017 Mario Borna Mjertan. Autorska prava pridržana. &middot; Poslovni oblak je u javnoj beti te je stoga besplatan i bez jamstva. &middot; <a href="/about/licenses">Licence slobodnog softvera</a></p>
      </div>
    </div>
  </div>
  </div>
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
  <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/aiq5dr5a';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

</body>
</html>
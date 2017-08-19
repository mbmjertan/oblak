
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

  <title>Pomoć i podrška za Poslovni oblak</title>
  <link href="/template/interface/pob.css" rel="stylesheet">
</head>
<body>
<div class="landingHeader supportHeader">
  <div class="landingHeaderNav">
    <div class="brand-logo">
      <a href="<?php echo domainpath;?>"><img src="<?php echo domainpath;?>template/icons/oblakLogoLight.png" class="brand-logo-nav"></a>
    </div>
  </div>
  <div class="row">
    <div class="col m9">
      <h1 class="landingIntro">Svima nam ponekad zatreba malo pomoći.</h1>
      <h2 class="landingSubtext">Ovdje smo da pomognemo.</h2>
    </div>

    <div class="col m3 white z-depth-2">
      <h2 class="landingSubtext">Želite razgovarati s čovjekom?</h2>
       <p>Pošaljite nam e-mail i odgovorit ćemo u najkraćem mogućem roku.</p>
        <b><a href="mailto:email@example.com">email@example.com</a></b>
        <br><br>

    </div>




  </div>
</div>

<div class="landingSubintro">
  <div class="container">
    <?php if(isset($alert)){echo $alert; } ?>
    <h2 class="landingSubtext text-center">Naši resursi pomoći</h2>
    <div class="row">
      <div class="col m4">
        <b>O korištenju Poslovnog oblaka</b>
        <ul>
          <li><a href="/pomoc/procitaj/registracija">Registracija i početak korištenja</a></li>
          <li><a href="/pomoc/procitaj/prijava">Prijava u Poslovni oblak</a></li>
          <li><a href="/pomoc/procitaj/promjena-lozinke">Promjena lozinke</a></li>
          <li><a href="/pomoc/procitaj/sucelje">Sučelje Poslovnog oblaka</a></li>
        </ul>
        </div>

      <div class="col m4">
        <b>Novosti</b>
        <ul>
          <li><a href="/pomoc/procitaj/novosti">Snalaženje u aplikaciji Novosti</a></li>
        </ul>
      </div>

      <div class="col m4">
        <b>Datoteke</b>
        <ul>
          <li><a href="/pomoc/procitaj/datoteke">Snalaženje u aplikaciji Datoteke</a></li>
          <li><a href="/pomoc/procitaj/datoteke-ogranicenja">Ograničenja</a></li>

        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col m4">
        <b>Računi</b>
        <ul>
          <li><a href="/pomoc/procitaj/racuni">Prvi susret s aplikacijom Računi i snalaženje u aplikaciji</a></li>
          <li><a href="/pomoc/procitaj/racuni-izvoz">Izvoz računa i ponuda iz aplikacije Računi</a></li>
          <li><a href="/pomoc/procitaj/racuni-ogranicenja">Zašto aplikacija Računi ne podržava...?</a></li>

        </ul>
      </div>

      <div class="col m4">
        <b>Kontakti</b>
        <ul>
          <li><a href="/pomoc/procitaj/kontakti">Snalaženje u aplikaciji Kontakti</a></li>
          <li><a href="/pomoc/procitaj/kontakti#dodavanje">Registracija korisnika u Poslovni oblak</a></li>



        </ul>
      </div>

      <div class="col m4">
        <b>Pretraživanje</b>
        <ul>
          <li><a href="/pomoc/procitaj/pretrazivanje">O pretraživanju Poslovnog oblaka tvrtke</a></li>


        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col m4">
        <b>Desktop aplikacija</b>
        <ul>
          <li><a href="/pomoc/procitaj/desktop-aplikacija">Instalacija, prva prijava i snalaženje</a></li>


        </ul>
      </div>

      <div class="col m4">
        <b>Administrativni alati</b>
        <ul>
          <li><a href="/pomoc/procitaj/admin">Administracija instance Poslovnog oblaka</a></li>
          <li><a href="/pomoc/procitaj/predlozak-pnb">Predložak poziva na broj</a></li>
          <li><a href="/pomoc/procitaj/backup-export">Preuzimanje sigurnosne kopije i izvoz podataka instance</a></li>
          <li><a href="/pomoc/procitaj/brisanje-instance">Brisanje instance Poslovnog oblaka</a></li>



        </ul>
      </div>
  </div>
    </div>
  </div>
</div>

<div class="grey lighten-5" style="margin-bottom:0;">
  <div class="grey lighten-5" style="margin-bottom:0;">
    <div class="container">
      <h2 class="landingSubtext text-center">Trebate čovjeka?</h2>
      <p class="text-center">Javite nam se na <a href="mailto:email@example.com"><b>email@example.com</b></a> i odgovorit ćemo u najkraćem mogućem roku.</p>
    </div>
    </div>
  </div>


  <div class="grey lighten-2 z-depth-1" style="margin-top:0;">
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
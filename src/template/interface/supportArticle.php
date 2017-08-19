
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

  <title><?php echo $title; ?> &bull; Pomoć i podrška za Poslovni oblak</title>
  <link href="/template/interface/pob.css" rel="stylesheet">
</head>
<body>
<div class="landingHeader supportHeader articleHeader">
  <div class="landingHeaderNav">
    <div class="brand-logo">
      <a href="<?php echo domainpath;?>"><img src="<?php echo domainpath;?>template/icons/oblakLogoLight.png" class="brand-logo-nav"></a><br>
      <a href="<?php echo domainpath;?>pomoc" class="blue-grey-text">&larr; Povratak na Pomoć</a>
    </div>
  </div>
  <div class="row">
    <div class="col m9">
      <h1 class="landingIntro"><?php echo $title; ?></h1>
    </div>

    </div>
  </div>
<div class="container article" style="margin-top:100px;">
  <?php echo $parsed; ?>
</div>


<div class="grey lighten-4 z-depth-1">
  <div class="container">
    <br><br>
    <h2 class="landingSubtext text-center">Trebate čovjeka?</h2>
    <center><a href="<?php echo domainpath; ?>pomoc/covjek?ref=<?php echo $req;?>" class="btn blue-grey darken-1">Obratite nam se &rarr;</a></center>
    <p class="text-center">ili nam se javite na <a href="mailto:email@example.com"><b>email@example.com</b></a> i odgovorit ćemo u najkraćem mogućem roku.</p>

    <br><br>
  </div>

  <div class="grey lighten-2 z-depth-1" style="margin-top:0;">
    <div class="container">
      <p style="-webkit-margin-after: 0;-moz-margin-after:0;margin-after:0;">&copy; 2017 Mario Borna Mjertan. Autorska prava pridržana. &middot; Poslovni oblak je u javnoj beti te je stoga besplatan i bez jamstva. &middot; <a href="/about/licenses">Licence slobodnog softvera</a></p>
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

  <script>
  window.intercomSettings = {
    app_id: "aiq5dr5a"
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/aiq5dr5a';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

</script>

</body>
</html>
</body>
</html>

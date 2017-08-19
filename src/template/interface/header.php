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
  <link rel="stylesheet" href="<?php echo domainpath; ?>template/interface/assets/awesomeplete/awesomplete.css" />
  <script src="<?php echo domainpath; ?>template/interface/assets/awesomeplete/awesomplete.js" async></script>
  <?php if( ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'walkthroughsEnabled') == 1) &&  ( ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'filesWalkthroughEnabled') == 1) || ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'billsWalkthroughEnabled') == 1) || ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'peopleWalkthroughEnabled') == 1) || ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'newsWalkthroughEnabled') == 1) )) {
    echo '<script src="'.domainpath.'template/interface/assets/introjs/intro.min.js"></script><link rel="stylesheet" href="'.domainpath.'template/interface/assets/introjs/introjs.min.css" type="text/css" media="screen">';
  }
  ?>
  <link type="text/css" rel="stylesheet"
        href="/template/interface/materialize/css/materialize.min.css"
        media="screen,projection"/>

  <title><?php echo $pageTitle; ?> &middot; Poslovni oblak</title>
  <link href="/template/interface/pob.css" rel="stylesheet">
</head>
<body>
<div class="appPicker">
  <a href="#" class="closeAppPickerIcon"><i class="material-icons">close</i></a>
  <div class="row">
    <div class="col m3 selap"><a
        href="<?php echo domainpath . activeInstance; ?>/"><i
          class="material-icons hugeIcon">view_compact</i><br>Novosti</a></div>
    <div class="col m3 selap"><a
        href="<?php echo domainpath . activeInstance; ?>/racuni"><i
          class="material-icons hugeIcon">credit_card</i><br>Računi</a></div>
    <div class="col m3 selap"><a
        href="<?php echo domainpath . activeInstance; ?>/datoteke"><i
          class="material-icons hugeIcon">cloud_upload</i><br>Datoteke</a></div>
    <div class="col m3 selap"><a
        href="<?php echo domainpath . activeInstance; ?>/kontakti"><i
          class="material-icons hugeIcon">contacts</i><br> Kontakti</a></div>
  </div>
</div>



<div class="userMenu">
  <a href="#" class="closeUserMenuIcon"><i class="material-icons">close</i></a>
  <div class="container">
    <div class="row">
      <div class="col m6">
        <p>Prijavljeni ste kao <?php echo userFullname; ?>.</p>
      </div>
      <div class="col m6">

        <p><a href="<?php echo domainpath . activeInstance . '/admin' ?>">Postavke ove instance</a>
          <br> <a
            href="<?php echo domainpath . activeInstance . '/login?action=logout'; ?>">Odjava</a>
          <br> <a href="#" onclick="$('.userMenu').css('visibility', 'hidden');$('.userMenu').css('opacity', '0');$('#keyboardShortcutHelp').openModal();">Tipkovnički prečaci</a>
          <?php if(!$_COOKIE['oblak_instance']){
            ?>
            <br><a href="<?php echo domainpath . activeInstance . '/install' ?>">Preuzmite desktop aplikaciju</a>
            <?php
          }
          ?>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="navbar-fixed">
  <nav>
    <div class="nav-wrapper <?php echo $appColor; ?>">
      <a href="<?php echo domainpath.activeInstance.'/'.$activeAppURL; ?>" class="brand-logo center"><?php echo $appTitle; ?></a>
      <ul class="left">
        <li><a href="#appPickerMini" class="appPickerIcon"><i
              class="material-icons">apps</i></a></li>
                  <span class="hide-on-med-and-down">
                    <?php include 'menuItems-' . $activeApp . '.php'; ?>
                  </span>
      </ul>
      <ul class="right">
        <li><a href="<?php echo domainpath.activeInstance;?>/search"><i class="material-icons">search</i></a></li>
        <li><a href="#userMenu" class="userMenuIcon"><i
              class="material-icons left">person</i><span
              class="hide-on-med-and-down"><?php echo userRealname; ?></span></a>
        </li>
      </ul>
    </div>
  </nav>
</div>

<div class="appPickerMini z-depth-2 grey lighten-4">

  <div class="appPickerMiniIcon"  id="firstIconAppPickerMini">
    <a href="<?php echo domainpath . activeInstance; ?>/"><i class="material-icons">view_compact</i><br>Novosti</a>
  </div>
  <div class="appPickerMiniIcon">
    <a href="<?php echo domainpath . activeInstance; ?>/racuni"><i class="material-icons">credit_card</i><br>Računi</a>
  </div>
  <div class="appPickerMiniIcon">
    <a href="<?php echo domainpath . activeInstance; ?>/datoteke"><i class="material-icons">cloud_upload</i><br>Datoteke</a>
  </div>
  <div class="appPickerMiniIcon">
    <a href="<?php echo domainpath . activeInstance; ?>/kontakti"><i class="material-icons">contacts</i><br>Kontakti</a>
  </div>
</div>

<div class="mobileMenu hide-on-large-only">
  <div class="container">
    <?php include 'mobileMenuItems-' . $activeApp . '.php'; ?>
  </div>
</div>


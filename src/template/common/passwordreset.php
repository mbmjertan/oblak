<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet">

  <link type="text/css" rel="stylesheet"
        href="/template/interface/materialize/css/materialize.min.css"
        media="screen,projection"/>

  <title>Zatražite novu lozinku &middot; Poslovni oblak</title>
  <link href="/template/interface/pob.css" rel="stylesheet">
  <style>
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #263238;
      color: #E3E2E2;

    }

    .form-signin {
      max-width: 330px;
      padding: 15px;
      margin: 0 auto;
      margin-top: 5%;

    }

    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }

    .form-signin .checkbox {
      font-weight: normal;
    }

    .form-signin .form-control {
      position: relative;
      height: auto;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      padding: 10px;
      font-size: 16px;
    }

    .signin-logo {
      height: 128px;
      padding: 5px;
      display: block;
      margin: 0 auto;
    }

    /* label color */
    .input-field label {
      color: #E3E2E2;
    }

    /* label focus color */
    .input-field input[type=text]:focus + label, .input-field input[type=password]:focus + label {
      color: #E3E2E2;
    }

    /* label underline focus color */
    .input-field input[type=text]:focus, .input-field input[type=password]:focus {
      border-bottom: 1px solid #E3E2E2;
      box-shadow: 0 1px 0 0 #E3E2E2;
    }

    /* valid color */
    .input-field input[type=text].valid, .input-field input[type=password].invalid {
      border-bottom: 1px solid #fff;
      box-shadow: 0 1px 0 0 #fff;
    }

    /* invalid color */
    .input-field input[type=text].invalid, .input-field input[type=password].invalid {
      border-bottom: 1px solid #fff;
      box-shadow: 0 1px 0 0 #fff;
    }

    /* icon prefix focus color */
    .input-field .prefix.active {
      color: #fff;
    }

    input[type=text], input[type=password] {
      color: #fff;
      margin-bottom: 6px;
    }

    .actionLink {
      margin-top: 38px;
      font-size: 14px;
    }

    a, a:link, a:visited {
      color: #E3E2E2;
      text-decoration: underline;
    }

    .btn {
      display: inline;
      margin-top: 30px;
      height: 42px;
      font-size: 14px;
    }

    .alert {
      background-color: #2E3436;
      color: #efefef;
      border-radius: 3px;
      border: 1px solid ghostwhite;
      padding: 4%;
      margin-bottom: 15px;
    }

  </style>
</head>
<body>
<div class="container">
  <form action="<?php echo domainpath . activeInstance;?>/login" class="form-signin" method="post">
    <img src="/template/icons/oblakLogoDark.png" class="signin-logo">
    <?php echo $msg; ?>
    <input type="hidden" name="return" value="<?php
    echo domainpath . activeInstance;
    ?>">
    <input type="hidden" name="instance" value="<?php echo activeInstance; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $canon; ?>">
    <input type="hidden" name="action" value="resetPassword">


    <p><b>Događa se i najboljima.</b> Unesite svoje korisničko ime kako biste promijenili lozinku.</p>
    <div class="input-field">
        <input type="text" name="resetusername" placeholder="Korisničko ime" class="form-control" required>
    </div>
    <div class="row">
      <div class="col l7 s12">
        <button class="btn blue-grey darken-2">Promijeni</button>
      </div>
      <div class="col l5 s12 actionLink">
        <a href="<?php echo domainpath . activeInstance; ?>/login"
           class="loginReset">Ipak se prisjećate?</a>
      </div>
    </div>
    </form>
</div>
</body>

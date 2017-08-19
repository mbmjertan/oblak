<?php
include_once 'config.php';
include_once 'inc/nightsparrow-main.php';
include_once 'inc/OblakCore.php';

$ns = new Nightsparrow;
$oblak = new OblakCore;
$msg = '<div class="alert alert-success">Prijavljujete se u desktop aplikaciju za Poslovni oblak. <b>Da biste nastavili, unesite kratko ime svoje instance.</b></div>';
if(isset($_COOKIE['oblak_instance'])){
  header('Location: '.domainpath.$_COOKIE['oblak_instance']);
}
if (isset($_POST)) {
  define('activeInstance', $_POST['instance']);

}
if (!isset($_COOKIE['oblak_csrf_anon'])) {
  $canon = bin2hex(openssl_random_pseudo_bytes(32));
  setcookie('oblak_csrf_anon', $canon, time() + 60 * 60, null, null, null, true);
} else {
  $canon = $_COOKIE['oblak_csrf_anon'];
}

if (isset($_COOKIE['oblakSession'])) {
  if (!isset($_COOKIE['sessionInvalid'])) {
    $returnloc = domainpath . activeInstance;
    die(header('Location: $returnloc'));
  }
}

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'logout') {
    $status = $oblak->validateUserSession(activeInstance,$_COOKIE['oblak_'.activeInstance.'_sid'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'],
      time());
    //var_dump($oblak->getSessionCSRF(activeInstance, $_COOKIE['oblak_'.activeInstance.'_sid']), $status, $_GET['csrfToken'], $_COOKIE['oblak_'.activeInstance.'_sid']);
    if ($status == true && $_GET['csrfToken'] == $oblak->getSessionCSRF(activeInstance, $_COOKIE['oblak_'.activeInstance.'_sid'])) {
      $code = $oblak->deleteSession(activeInstance, $_COOKIE['oblak_'.activeInstance.'_sid']);
      // echo ':D';
    } else {
      $msg = '<div class="alert alert-warning">Dogodila se pogreška (0xEE1A01).</div>';
    }
    if ($code == 0) {
      $msg = '<div class="alert alert-success">Odjavljeni ste.</div>';
    } else {
      $msg = '<div class="alert alert-warning">Dogodila se pogreška (0xEE1A00).</div>';
    }
    setcookie('oblak_'.activeInstance.'_sid', 'loggedout', time() - 2700, null, null, null, true);
    setcookie('oblak'.activeInstance.'_sessionx', 'loggedout', time() - 2700, null, null, null, true);
    setcookie('oblak_instance', 'loggedout', time() - 2700, null, null, null, true);

  }
  if ($_GET['action'] == 'resetpassword') {
    include_once 'template/common/passwordreset.php';
    die();
  }
}


if (isset($_POST)) {
  if (isset($_POST['username'])) {

    if ($oblak->usernameExists(activeInstance, $_POST['username']) == true) {

      if ($oblak->countRecentFailedLoginAttempts(activeInstance, $_POST['username']) > 5) {
        die('Ovaj korisnicki racun je zakljucan zbog prevelikog broja neuspjelih prijava. Pokusajte ponovno za pola sata.');
      }
      if ($oblak->getUserDataAPI(activeInstance, $oblak->getUserID(activeInstance, $_POST['username']), 'banned')) {
        die('Vas korisnicki racun je suspendiran od strane administratora.');
      }
      if (strlen($_POST['password']) > 72) {
        die('Predugacka lozinka. Maksimalna duljina lozinke za prijavu je 72 znaka.');
      }
      $dv = $oblak->checkPassword(activeInstance, $_POST['username'], $_POST['password']);
      if ($dv == true) {
        if ($_COOKIE['oblak_csrf_anon'] == $_POST['csrfToken']) {
          // echo ':=)';
          $sessionid = $oblak->setUserSession(activeInstance, $_POST['username'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], (60 * 60 * 24 * 365));
          //echo $sessionid;
          setcookie("oblak_instance", activeInstance, (time() + (60 * 60 * 24 * 365)), null, null, null, true);

          setcookie("oblak_".activeInstance."_sid", $sessionid, (time() + (60 * 60 * 24 * 365)), null, null, null, true);


          echo '<script type="text/javascript">window.location = "'.domainpath.activeInstance. '"</script>';

          $msg = '<div class="alert alert-success">Prijavljeni ste! :D <a href="' . $_POST['return'] . '">Kliknite ovdje kako biste nastavili &rarr;</a></div>';

        } else {
          $msg = '<div class="alert alert-warning">Dogodila se pogreška (0xEE1A01).</div>';
        }

      } else {
        $msg = '<div class="alert alert-info" role="alert">Podatci za pristup nisu valjani. Pokušajte ponovno.</div>';
        $oblak->setUserSession(activeInstance, $_POST['username'], '0.0.0.0', 'FAILED_ATTEMPT_NIGHTSPARROW_LOGIN');
      }
    } else {
      $msg = '<div class="alert alert-info" role="alert">Podatci za pristup nisu valjani. Pokušajte ponovno.</div>';
      if ($oblak->usernameExists(activeInstance, $_POST['username']) == true) {
        $oblak->setUserSession(activeInstance, $_POST['username'], '0.0.0.0', 'FAILED_ATTEMPT_NIGHTSPARROW_LOGIN');
      }
    }
  }
}


include_once rootdirpath.'template/common/appLogin.php';
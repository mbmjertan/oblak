<?php
include_once 'config.php';
include_once 'inc/nightsparrow-main.php';
include_once 'inc/OblakCore.php';

$ns = new Nightsparrow;
$oblak = new OblakCore;
$msg = null;

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

if($routeSegments[2] == 'token'){
    include 'template/common/newPasswordForm.php';
    die();

}

if ($routeSegments[2] == 'resetpassword') {
    include_once 'template/common/passwordreset.php';
    die();
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
        if(isset($_COOKIE['oblak_instance'])) {
            setcookie('oblak_instance', 'loggedout', time() - 2700, null, null, null, true);
           include_once 'template/common/appLogin.php';
          die();
        }

    }

}


if (isset($_POST)) {
    if(isset($_POST['action'])){
        if($_POST['action'] == 'resetPassword'){
            if($_POST['csrfToken'] != $canon){
                $oblak->throwError();
            }
            $msg = '<p>Ako unutar vaše organizacije postoji ovo korisničko ime, poslat ćemo Vam e-mail s daljnjim uputama.</p>';
            if($oblak->usernameExists(activeInstance, $_POST['resetusername'])){
                $email = $oblak->getUserDataAPI(activeInstance, $oblak->getUserID(activeInstance, $_POST['resetusername']), 'email');
            }
            $values['passwordToken'] = $oblak->addToken(activeInstance, $oblak->getUserID(activeInstance, $_POST['resetusername']));
            $values['resetpassword_url'] = domainpath.activeInstance.'/login/token/'.$values['passwordToken'];
            $oblak->sendEmail($email, 'Promijenite lozinku za Poslovni oblak', 'forgotPassword.html', $values);

        }
        if($_POST['action'] == 'finalpasswordreset'){
            if($_POST['csrfToken'] != $canon){
                $oblak->throwError();
            }
            $msg = '<p><b>Gotovo!</b> Možete se prijaviti u Poslovni oblak novom lozinkom.</p>';
            $oblak->resetUserPassword(activeInstance, $_POST['prtoken'], $_POST['resetpassword']);
        }
    }
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
                    $sessionid = $oblak->setUserSession(activeInstance, $_POST['username'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
                    //echo $sessionid;
                    setcookie("oblak_".activeInstance."_sid", $sessionid, (time() + (60 * 60 * 24 * 3)), null, null, null, true);

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


include_once 'template/common/login.php';
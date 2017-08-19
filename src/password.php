<?php
include_once 'config.php';
include_once 'inc/nightsparrow-main.php';

$ns = new Nightsparrow;
$msg = null;
if (isset($_COOKIE['nightsparrowSession'])) {
    if (!isset($_COOKIE['sessionInvalid'])) {
        $returnloc = domainpath . $_GET['return'];
        // echo 'a';
        die(header('Location: $returnpath'));
    }
}
//var_dump($_POST);

if ((isset($_POST['email']) || (isset($_POST['token'])))) {
    // echo 'a';

    if (isset($_POST['email'])) {
        $userExists = $ns->emailExists($_POST['email']);
        // echo 'a';

        if ($userExists == true) {

            $passwordResetToken = $ns->generatePasswordResetToken();

            $setPasswordResetToken = $ns->setUserPasswordResetToken($_POST['email'], $passwordResetToken,
              $_SERVER['REMOTE_ADDR']);

            $emailValues['token'] = $passwordResetToken;
            $emailValues['sitename'] = $ns->getSettingValue("core", "siteName");
            $emailValues['user_fullname'] = $ns->getUserRealname($ns->getUserID($_POST['email']));
            $emailValues['sitename'] = $ns->getSettingValue("core", "siteName");
            $emailValues['resetpassword_url'] = domainpath . 'password.php?token=' . $passwordResetToken;


            $emailResult = $ns->sendEmail($_POST['email'], 'Izaberite novu lozinku za {{sitename}}',
              'forgotPassword.html', $emailValues);

            echo '<div class="alert-box success">Ako korisnički račun postoji, bit će poslana poruka e-pošte. Slijedite upute iz poruke za informacije kako resetirati lozinku.</div>';
        } else {
            echo '<div class="alert-box success">Ako korisnički račun postoji, bit će poslana poruka e-pošte. Slijedite upute iz poruke za informacije kako resetirati lozinku.</div>';
        }

    } elseif (isset($_POST['token'])) {
        if ($ns->passwordResetTokenValid($_POST['token']) == true) {
            if (strlen($_POST['password']) > 72) {
                die('Predugacka lozinka. Maksimalna duljina lozinke za prijavu je 72 znaka.');
            }
            $ns->resetUserPassword($_POST['token'], $_POST['password']);
        }

    }
} elseif (isset($_GET)) {
    if (isset($_GET['token'])) {
        if ($ns->passwordResetTokenValid($_GET['token']) == true) {
            echo '<form action="password.php" method="post"><input type="hidden" name="token" value="' . strip_tags($_GET['token']) . '"><input type="password" name="password" placeholder="Nova lozinka..."><input type="submit">';
        } else {
            echo 'Nevaljan token.';
            die();
        }
    } else {
        die(header('Location: login.php?action=resetpassword'));
    }
} elseif ((!isset($_POST)) && !isset($_GET)) {
    die(header('Location: login.php?action=resetpassword'));
}
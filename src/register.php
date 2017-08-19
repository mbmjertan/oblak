<?php
include_once 'config.php';
include_once 'inc/nightsparrow-main.php';
$ns = new Nightsparrow;
$msg = null;

if ($ns->getSettingValue('core', 'publicRegistrationEnabled') != 1) {
    die($ns->throwError('forbidden'));
}

if (isset($_COOKIE['nightsparrowSession'])) {
    if (!isset($_COOKIE['sessionInvalid'])) {
        $returnloc = domainpath . $_GET['return'];
        die(header('Location: $returnpath'));
    }
}

if (isset($_POST)) {
    if (isset($_POST['email'])) {
        if ($ns->emailExists($_POST['email']) == true) {
            die("Korisnicki racun za ovu email adresu vec postoji.");


        } else {
            if (strlen($_POST['password']) > 72) {
                die('Predugacka lozinka. Maksimalna duljina lozinke za prijavu je 72 znaka.');
            } else {
                $ns->addUserAPI($_POST['name'], $_POST['email'], $_POST['password'], 1);
                echo 'Korisnik dodan! :)';
            }
        }
    }
}


include_once 'template/common/register.php';
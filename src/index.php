<?php
/* Poslovni oblak v. 0.0.1 */
include_once 'inc/nightsparrow-main.php';
include_once 'inc/OblakCore.php';
include_once 'inc/OblakRacuni.php';
include_once 'inc/OblakPeople.php';
include_once 'inc/OblakAPI.php';
include_once 'inc/OblakActionHandling.php';
include_once 'inc/OblakNovosti.php';
include_once 'inc/kepler.php';
include_once 'inc/depends/Parsedown.php';







$ns = new Nightsparrow;
$oblak = new OblakCore;
$racuni = new OblakRacuni;
$oblak->actionHandling = new OblakActionHandling;
$oblak->racuni = new OblakRacuni;
$oblak->people = new OblakPeople;
$oblak->api = new OblakAPI;
$oblak->novosti = new OblakNovosti;
$oblak->kepler = new Kepler;
$Parsedown = new Parsedown();



if (file_exists('config.php')) {
  include_once 'config.php';
}
if (!file_exists('config.php')) {
  $oblak->throwError('systemError', 'configMissing');
}



include 'inc/router.php';


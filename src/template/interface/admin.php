<?php
$appTitle = 'Administracija';
$pageTitle = 'Administracija';
$activeApp = 'admin';
$activeAppURL = 'admin';
$appColor = 'grey darken-3';
include 'header.php';

if($view == 'ViewView') {
  include 'adminPanel.php';
}
elseif($view == 'SorryView'){
  include 'adminSorry.php';
}
elseif($view=='DeleteView'){
  include 'adminDelete.php';
}
else{
  include 'adminPanel.php';
}

include 'footer.php';
?>

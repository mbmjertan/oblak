<?php
$appTitle = 'Računi';
$pageTitle = 'Računi';
$activeApp = 'racuni';
$activeAppURL = 'racuni';
$appColor = 'grey darken-4';
include 'header.php';
if($alert){
  echo $alert;
}
if($view == 'ListView'){
  include 'racuni-listings.php';
}
if($view == 'AddView' || $view == 'EditView'){
  include 'racuni-edit.php';
}
if($view == 'DeleteView'){
  include 'racuni-delete.php';
}

include 'footer.php';
?>

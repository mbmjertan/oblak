<?php
$appTitle = 'Kontakti';
$pageTitle = 'Kontakti';
$activeApp = 'people';
$activeAppURL = 'kontakti';
$appColor = 'deep-orange darken-4';
include 'header.php';
if(isset($alert)){
  echo $alert;
}
if($view == 'PeopleList'){
  include 'people-list.php';
}
if($view == 'PersonView'){
  include 'people-view.php';
}
if($view == 'GroupView'){
  include 'people-groupview.php';
}
if($view == 'AddView'){
  include 'people-editor.php';
}
if($view == 'UpdateView'){
  include 'people-edit.php';
}
if($view == 'DeleteView'){
  include 'people-delete.php';
}
?>


<?php
include 'footer.php';
?>

<?php
if($routeSegments[1] == 'procitaj'){
  $req = $oblak->ioPrepare($routeSegments[2], 'nospecialchars-dashallowed');
  $file = rootdirpath.'support/'.$req.'.md';
  $file = file_get_contents($file);

  $parsed = $Parsedown->text($file);
  $title = substr($file, 0, stripos($file, '[/title]'));
  $parsed = str_replace($title.'[/title]', '', $parsed);
  if(!$file){
    header('Location: '.domainpath.'pomoc');
  }
  include 'template/interface/supportArticle.php';
}
elseif(stripos($routeSegments[1],'covjek') !== FALSE){
  $ref = $oblak->ioPrepare($_GET['ref']);
  include 'template/interface/supportContact.php';
}
else{
  if($_POST['action'] == 'contact'){
    $msg = "Pošiljatelj: {$_POST['name']} \r\n E-mail: {$_POST['email']} \r\n Članak: {$_POST['ref']} \r\n Poruka: \r\n {$_POST['content']}";
    $header = "From: {$_POST['name']} <{$_POST['email']}>\r\nSender: supportbot@oblak.mbmjertan.co\r\nContent-Type:text/plain;charset-utf8";
    $a = mail('email@example.com', 'Kontakt sa weba za pomoć', $msg, $header);
    $alert = '<div class="blue-grey card-panel white-text">Poruka poslana. Kontaktirat ćemo Vas u najkraćem mogućem roku. :)</div>';
  }
  include 'template/interface/supportLanding.php';
}
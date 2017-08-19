<?php
if (stripos($routeSegments[1], "admin") !== false) {
  if($routeSegments[2] == 'backup'){
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip, application/octet-stream');
    header('Content-Disposition: attachment; filename=backup.zip');
    header('Content-Transfer-Encoding: chunked');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');

    echo file_get_contents($oblak->actionHandling->generateBackup(activeInstance));
    unlink(realpath(rootdirpath . '/../OblakUploads/' . activeInstance . '/databaseExport'));
    unlink($oblak->actionHandling->generateBackup(activeInstance));

  }
  if($routeSegments[2] == 'submitDelete'){
    if($_POST['csrfToken'] == csrfToken){
      $view = 'SorryView';
      $message = "ZAHTJEV ZA BRISANJEM INSTANCE \r\n";
      $message .="============================= \r\n";
      $message .="Korisnik: ".userFullname." (ID: ".userID.") \r\n";
      $message .="Instanca: ".activeInstance." \r\n";

      $message .="Identifikator sesije: ".sessionID." \r\n";
      $message .="IP: ".$_SERVER['REMOTE_ADDR']." \r\n";
      $message .="UA: ".$_SERVER['HTTP_USER_AGENT']." \r\n";
      $message .="UNIX timestamp: ".time()." \r\n";
      $message .="Razlozi: ".$_POST['deleteReasons']."\r\n";

      mail("email@example.com", "Zahtjev za brisanjem instance", $message);
      include 'template/interface/admin.php';
    }
  }
  elseif($routeSegments[2] == 'delete'){
    $view = 'DeleteView';
    include 'template/interface/admin.php';
  }
  else {
    $view = 'ViewView';
    include 'template/interface/admin.php';
  }
}
?>
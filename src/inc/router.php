<?php
if(file_exists('update.lock')){
  die(include('template/interface/updatelock.php'));
}
$request = $_SERVER['REQUEST_URI'];
if (($_SERVER['HTTPS'] == null) || ($_SERVER['HTTPS'] == 'off')) {
  $protocol = 'http';
}
else {
  $protocol = 'https';
}
$url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $request;
$pathName = str_replace(domainpath, "", $url);
$routeSegments = explode("/", $pathName);

if ($routeSegments[0] == 'core') {
  if($routeSegments[1] == 'instanceSetup'){
    include 'template/interface/setup.php';
  }
  if ($routeSegments[1] == 'createInstance') {
    if(isset($_POST['instanceShortname'])){
    if($_COOKIE['oblak_csrf_anon'] == $_POST['csrfTokenAnon']) {
      $res = $oblak->createInstance($_POST['businessName'], $_POST['instanceShortname'], null, null, $_POST['primaryContactEmail'], $_POST['primaryContactPhoneNumber'], $_POST['instanceShortname'], null, null, $_POST['username'], $_POST['password'], $_POST['adminName'], $_POST['adminSurname'], $_POST['businessType'], $_POST['businessMainAddress'], $_POST['businessMainPostcode'], $_POST['businessMainCity'], $_POST['businessWeb'], $_POST['businessEmail'], $_POST['businessPhone'], $_POST['businessMainIBAN']);
      sleep(4);
        $farr = $_FILES;
        $fileData = $oblak->uploadFile($_POST['instanceShortname'], $farr);
        $logoFileID = $oblak->addFile($_POST['instanceShortname'], $fileData, 1, 0, 1);
        $dbconn = $oblak->mysqliConnect();
        $sh = $dbconn->real_escape_string($_POST['instanceShortname']);
        $sql = "INSERT INTO {$sh}_siteSettings VALUES (null, 'logoFileID', '{$logoFileID}', null, null, null, null, null, null)";
        $secres = $dbconn->query($sql);
        if ($secres === false) {
          $oblak->throwError('databaseError', 'sqlError', $dbconn);
        }
        $lur = domainpath . $_POST['instanceShortname'];
        header('Location: ' . $lur);

    }

        }
    }


  elseif ($routeSegments[1] == 'systemerror') {
    include 'template/errors/unknown.php';
    die();
  }
}
elseif($routeSegments[0] == 'coreMaintenanceTasks'){
  if($routeSegments[1] == 'update'){
    if($routeSegments[2] == oblakDeployKey){
      file_put_contents('update.lock', '1');
      $go = [];
      exec('git pull', $go, $ec);
      if($ec){
        echo 'Deploy failed!';
        mail(systemAdminEmail, "Fail on deploy", 'A deploy failed on '.gethostname().' at '.time());
        unlink('update.lock');
      }
      else{
        mail(systemAdminEmail, "Success on deploy", 'A deploy succeeded on '.gethostname().' at '.time());
      }
      unlink('update.lock');
    }

  }
}
elseif($routeSegments[0] == 'login'){
  include rootdirpath.'generalLogin.php';
}
elseif($routeSegments[0] == 'pomoc'){
  include 'supportRoutes.php';
}
elseif(stripos($routeSegments[0], "applogin") !== false){
  include rootdirpath.'appLogin.php';
}
elseif($routeSegments[0] == 'about'){
  if($routeSegments[1] == 'licenses'){
    include 'template/interface/about-licenses.php';
  }
}
elseif (!$routeSegments[0]) {
  include 'template/interface/landing.php';
}
elseif($routeSegments[0] == 'public'){
  define('activeInstance', $routeSegments[1]);
  $fileToken = $routeSegments[3];
  $fileID = $oblak->getFileFromPublicToken(activeInstance, $fileToken);
  $fileData = $oblak->getFileData(activeInstance, $fileID);
  $fileData['preview'] == false;
  $view = 'DownloadView';
  include 'template/interface/files.php';
}
else {
  define('activeInstance', $routeSegments[0]);
  $status = $oblak->validateUserSession(activeInstance, $_COOKIE['oblak_' . activeInstance . '_sid'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], time());
  if ($status == true) {
    define('userRealname', $oblak->getUserRealname(activeInstance, $oblak->getSessionUser(activeInstance, $_COOKIE['oblak_' . activeInstance . '_sid']), 'firstName'));
    define('userFullname', $oblak->getUserRealname(activeInstance, $oblak->getSessionUser(activeInstance, $_COOKIE['oblak_' . activeInstance . '_sid'])));
    define('userID', $oblak->getSessionUser(activeInstance, $_COOKIE['oblak_' . activeInstance . '_sid']));
    define('sessionID', $_COOKIE['oblak_' . activeInstance . '_sid']);
    define('csrfToken', $oblak->getSessionCSRF(activeInstance, $_COOKIE['oblak_' . activeInstance . '_sid']));
  }
  else {
    //echo domainpath.activeInstance.'/login';
    if ($routeSegments[1] !== 'login') {
      header('Location: ' . domainpath . activeInstance . '/login');
      die();

    }
  }
  if (isset($routeSegments[1]) && $routeSegments[1] == '/') {
    $routeSegments[1] = null;
  }

  elseif ($routeSegments[1]) {
    if($routeSegments[1] == 'install'){
      include 'template/interface/install.php';
    }
    if (stripos($routeSegments[1], "login") !== false) {
      include 'login.php';
    }
    include 'fileRoutes.php';
    include 'peopleRoutes.php';
    include 'racuniRoutes.php';
    include 'adminRoutes.php';
    include 'keplerRoutes.php';
    include_once 'novostiRoutes.php';


  }
  else {
    if ($status == false) {
      die(header('Location: ' . domainpath . activeInstance . '/login'));
    }
    else {
      include 'template/interface/homepage.php';
      include_once 'novostiRoutes.php';
      include 'template/interface/footer.php';

    }
  }
} 
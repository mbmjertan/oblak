<?php

/**
 * Oblak jezgra.
 * Pokreće sve krucijalne funkcije: autentifikaciju, autorizaciju, deployanje instanci, postavke i rad s datotekama.
 */
class OblakCore {
  function __construct() {
    //        var_dump(rootdirpath);
    //require rootdirpath . 'vendor/autoload.php';
  }

  function createInstance($name, $callsign, $customBaseDomain = false, $baseDomain = 'NOTSET!', $primaryContactEmail, $primaryContactPhoneNumber, $databasePrefix = 'NOTSET!', $secondaryContactEmail = null, $secondaryContactPhoneNumber = null, $adminUsername, $adminPassword, $adminName, $adminSurname, $type, $mainaddress, $mainpostcode, $maincity, $web, $mail, $phone, $IBAN) {
    $dbconn = $this->mysqliConnect();
    $errors = '';
    $name = $dbconn->real_escape_string($name);
    $callsign = $dbconn->real_escape_string($callsign);
    if ($customBaseDomain !== false) {
      $customBaseDomain = 1;
    }
    else {
      $customBaseDomain = 0;
    }
    if ($baseDomain == 'NOTSET!' || $baseDomain == null) {
      $baseDomain = domainpath . $callsign;
    }
    if ($databasePrefix == 'NOTSET!' || $databasePrefix == null) {
      $databasePrefix = $callsign;
    }
    $baseDomain = $dbconn->real_escape_string($baseDomain);
    $primaryContactEmail = $dbconn->real_escape_string($primaryContactEmail);
    $primaryContactEmail = filter_var(
      $primaryContactEmail, FILTER_SANITIZE_EMAIL
    );
    $primaryContactPhoneNumber = $dbconn->real_escape_string(
      $primaryContactPhoneNumber
    );
    $primaryContactPhoneNumber = preg_replace(
      "/[^0-9]/", '', $primaryContactPhoneNumber
    );
    $databasePrefix = $dbconn->real_escape_string($databasePrefix);
    $IBAN = $dbconn->real_escape_string($IBAN);
    $databasePrefix = preg_replace(
      "/[^A-Za-z0-9]/", rand(0, 110), $databasePrefix
    );
    if (strlen($databasePrefix) > 32) {
      $errors .= " Prefiks za bazu podataka treba biti 32 znaka ili kraći.";
    }
    if ($this->instanceExists($databasePrefix)) {
      $errors .= " Instanca istog prefiska već postoji.";
    }
    mkdir(rootdirpath."/../OblakUploads/".$databasePrefix, 0755, true);

    $secondaryContactEmail = $dbconn->real_escape_string(
      $secondaryContactEmail
    );
    if ($secondaryContactEmail !== null) {
      $secondaryContactEmail = filter_var(
        $secondaryContactEmail, FILTER_SANITIZE_EMAIL
      );

    }
    $secondaryContactPhoneNumber = $dbconn->real_escape_string(
      $secondaryContactPhoneNumber
    );
    $adminUsername = $dbconn->real_escape_string($adminUsername);
    $adminPassword = $dbconn->real_escape_string(
      $this->hashPassword($dbconn->real_escape_string($adminPassword))
    );
    $adminName = $dbconn->real_escape_string($adminName);
    $adminSurname = $dbconn->real_escape_string($adminSurname);
    $type = $dbconn->real_escape_string($type);
    $mainaddress = $dbconn->real_escape_string($mainaddress);
    $mainpostcode = $dbconn->real_escape_string($mainpostcode);
    $maincity = $dbconn->real_escape_string($maincity);
    $web = $dbconn->real_escape_string($web);
    $mail = $dbconn->real_escape_string($mail);
    $phone = $dbconn->real_escape_string($phone);

    if ($errors != '') {
      return $errors;
    }
    $initalTableQueries = file_get_contents(
      rootdirpath . '/inc/fls/createDB.sql'
    );
    $initalTableQueries = str_replace(
      "{{OBLAK_DB_PREFIX}}", $databasePrefix, $initalTableQueries
    );
    $initalTableQueries = str_replace('{{OBLAK_GENTIME}}', time(), $initalTableQueries);
    $initalTableQueries = str_replace("{{name}}", $name, $initalTableQueries);
    $initalTableQueries = str_replace(
      "{{callsign}}", $callsign, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{customBaseDomain}}", $customBaseDomain, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{baseDomain}}", $baseDomain, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{primaryContactEmail}}", $primaryContactEmail, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{primaryContactPhoneNumber}}", $primaryContactPhoneNumber, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{secondaryContactEmail}}", $secondaryContactEmail, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{secondaryContactPhoneNumber}}", $secondaryContactPhoneNumber, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{adminUsername}}", $adminUsername, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{adminPassword}}", $adminPassword, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{adminName}}", $adminName, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{adminSurname}}", $adminSurname, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{timestamp}}", time(), $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{type}}", $type, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{BMA}}", $mainaddress, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{BMP}}", $mainpostcode, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{BMC}}", $maincity, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{BW}}", $web, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{BM}}", $mail, $initalTableQueries
    );
    $initalTableQueries = str_replace(
      "{{BP}}", $phone, $initalTableQueries
    );
    $initalTableQueries = str_replace("{{IBAN}}", $IBAN, $initalTableQueries);

    $dbconn->multi_query($initalTableQueries);
    return 0;

  }

  /** javna funkcija za spajanje na mysqli bazu **/
  public function mysqliConnect() {
    $dbconn = new mysqli(
      mysql_server, mysql_user, mysql_password, mysql_database
    );
    if ($dbconn->connect_error) {
      $this->throwError('databaseError', 'connectionError', $dbconn);
    }
    $dbconn->set_charset("utf8mb4");

    return $dbconn;
  }

  function throwError($errorClass = 'unknown', $errorType = 'unknown', $dbconn = null) {
    $trace = debug_backtrace();
    $logItem = "\n ## BEGIN ERROR DUMP ## \n Time: " . time() . " Environment: " . nsEnvironment . " Server: " . gethostname() . " Request IP: " . $_SERVER['REMOTE_ADDR'] . " User agent: " . $_SERVER['HTTP_USER_AGENT'] . " Request URI: " . $_SERVER['REQUEST_URI'] . " Error class: " . $errorClass . " Error type: " . $errorType . " \n Debug info: \n " . print_r($trace, true) . "\n Dbconn provided: \n" . print_r(
        $dbconn, true
      ) . "\n ## END ERROR DUMP ##";
    $el = file_put_contents(
      rootdirpath . "errorLog.txt", $logItem, FILE_APPEND
    );
    if ($el === false) {
      file_put_contents("errorLogFailure.txt", $logItem, FILE_APPEND);
    }
    if ($errorType == 'connectionError') {
      mail(
        systemAdminEmail, "Error notice: Can\'t connect to MySQL server", $logItem
      );
    }
    if ($errorType == 'multipleInstancesWithCallsign') {
      mail(
        systemAdminEmail, "Error alert: multiple instances with a same callsign!", $logItem
      );
    }
    if ($errorType == 'deployFailed') {
      mail(
        systemAdminEmail, "Error alert: deploy failed!", $logItem
      );
    }
    if ($errorType = 'queryFail') {
      $errorCode = $dbconn->mysqli_errno;
      if ($errorCode == 1064) {
        mail(systemAdminEmail, "Error alert: SQL syntax error!", $logItem);
      }
      else {
        mail(systemAdminEmail, "Error notice: SQL error", $logItem);

      }
    }
    header('Location: ' . domainpath . 'core/systemerror');
    echo "Fatalna pogreška.";
    die();

  }

  function instanceExists($instance) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $query = "SELECT COUNT(*) AS InstanceCount FROM instances WHERE callsign='$instance'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $count = $res->fetch_assoc();
    $count = $count['InstanceCount'];
    $dbconn->close();
    if ($count > 1) {
      $this->throwError('storageError', 'multipleInstancesWithCallsign');
    }
    if ($count == 1) {
      return true;
    }
    else {
      return false;
    }
  }

  function hashPassword($password) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    return $password;
  }

  /** funkcija za dodavanje korisnika, prima API zahtjev, koristiti kada je potrebno **/
  function addUserAPI($instance, $username, $email, $password, $personID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $username = $dbconn->real_escape_string($username);
    $email = $dbconn->real_escape_string($email);
    $password = $dbconn->real_escape_string(
      $this->hashPassword($dbconn->real_escape_string($password))
    );
    $personID = preg_replace("/[^0-9]/", '', $personID);
    $password = $dbconn->real_escape_string($password);
    $addUserQuery = "INSERT INTO {$instance}_users VALUES(null, '$email', '$username', '$password', '$personID')";
    $res = $dbconn->query($addUserQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $id = $dbconn->insert_id;
    $dbconn->close();
    return $id;

  }

  /** provjeravanje lozinke za nečiji račun, vraća true ili false **/
  function checkPassword($instance, $username, $password) {
    $dbconn = $this->mysqliConnect();
    $dbconn->real_escape_string($instance);
    $dbconn->real_escape_string($username);
    $dbconn->real_escape_string($password);
    $userQuery = "SELECT * FROM " . $instance . "_users WHERE username = '$username'";
    $res = $dbconn->query($userQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $matchingUsers = [];
    while ($row = $res->fetch_assoc()) {
      $matchingUsers[] = $row;
    }
    foreach ($matchingUsers as $row) {
      if (($row['salt'] != null)
        && (crypt($password, $row['salt']) == $row['password'])
      ) {
        return true;
      }
      elseif (password_verify($password, $row['password']) === true) {
        return true;
      }
      else {
        return false;
      }
    }
    $dbconn->close();

  }

  /** postavi sesiju korisnika, portanje u tijeku iz pulsira **/
  function setUserSession($instance, $user, $ip, $useragent, $limit = null) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = $this->getUserID($instance, $user);
    $user = $dbconn->real_escape_string($user);
    $ip = $dbconn->real_escape_string($ip);
    $useragent = $dbconn->real_escape_string($useragent);
    $time = $dbconn->real_escape_string(time());
    if(!$limit){
      $limit = 60 * 60 * 24 * 3;
    }
    $expon = time() + $limit;
    $csrf = $dbconn->real_escape_string(
      bin2hex(openssl_random_pseudo_bytes(32))
    );
    $x = $dbconn->real_escape_string(bin2hex(openssl_random_pseudo_bytes(32)));
    $cookieName = "oblak_" . $instance . "_sessionx";

    setcookie(
      $cookieName, $x, (time() + $limit), null, null, null, true
    );
    $sql = "INSERT INTO " . $instance . "_sessions VALUES (null, '$user', '$ip', '$useragent', '$time', '$expon', '$csrf', '$x')";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $id = $dbconn->insert_id;

    return $id;
    $dbconn->close();

  }

  /** funkcija za dobivanje id-a korisnika iz korisničkog imena! **/
  function getUserID($instance, $username) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $username = $dbconn->real_escape_string($username);
    $sql = "SELECT * FROM " . $instance . "_users WHERE username = '$username'";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    elseif ($res->num_rows == 0) {
      $this->throwError('databaseError', 'unexpectedResult');
    }
    elseif ($res->num_rows > 1) {
      $this->throwError('databaseError', 'unexpectedResult');
    }
    $users = $res->fetch_array();
    $id = $users['id'];
    $dbconn->close();

    return $id;

  }

  function getUsernameFromID($instance, $id) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $id = preg_replace ("/[^0-9]/", '', $id);
    $sql = "SELECT * FROM " . $instance . "_users WHERE id = '$id'";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    elseif ($res->num_rows == 0) {
      $this->throwError('databaseError', 'unexpectedResult');
    }
    elseif ($res->num_rows > 1) {
      $this->throwError('databaseError', 'unexpectedResult');
    }
    $users = $res->fetch_array();
    $username = $users['username'];
    $dbconn->close();

    return $username;

  }

  function getEmailFromID($instance, $id) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $id = preg_replace ("/[^0-9]/", '', $id);
    $sql = "SELECT * FROM " . $instance . "_users WHERE id = '$id'";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    elseif ($res->num_rows == 0) {
      $this->throwError('databaseError', 'unexpectedResult');
    }
    elseif ($res->num_rows > 1) {
      $this->throwError('databaseError', 'unexpectedResult');
    }
    $users = $res->fetch_array();
    $email = $users['email'];
    $dbconn->close();

    return $email;

  }

  /** validirajmo sesiju korisnika **/
  function validateUserSession($instance, $sessionid, $ip, $useragent, $time) {
    $dbconn = $this->mysqliConnect(); // inicijalizirajmo vezu s bazom
    /** escapeanje vrijednosti radi sprječavanja sql injectiona **/
    $sessionid = $dbconn->real_escape_string($sessionid);
    $ip = $dbconn->real_escape_string($ip);
    $useragent = $dbconn->real_escape_string($useragent);
    $time = $dbconn->real_escape_string($time);
    $getSessionQuery = "SELECT * FROM " . $instance . "_sessions WHERE id = '$sessionid'";
    $res = $dbconn->query($getSessionQuery);
    $sessions = [];
    if ($res === false) {
      return false; // pravit ćemo se da nije problem s bazom
    }

    while ($row = $res->fetch_assoc()) {
      $sessions[] = $row;
    }

    if ($res->num_rows == 0) {
      return false; // ako nema rezultata, sesija nije valjana
    }
    foreach ($sessions as $session) {
      if ($session['expires'] < time()) {
        return false; // UNIX timestamp trenutnog vremena je veći od UNIX timestampa vremena isteka sesije -- sesija je istekla, vraćamo false
      }
      elseif ($session['useragent'] != $useragent) {
        return false; // user agent nije isti, možemo pretpostaviti da se ne radi o istom pregledniku, postoji šansa da je netko iskopirao sesiju
      }
      elseif ($session['ip'] != $ip) {
        return false; // ip nije isti. najvjerojatnije se nekomu ruter resetirao ili ima problema s mrežom, no radi sigurnosti je bolje poništiti sesiju ako se dogodi promjena ip adrese.
      }
      elseif ($_COOKIE['oblak_' . $instance . '_sessionx'] != $session['cookieid']) {
        return false; // gledamo sigurnosni token :D
      }
      else {
        return true; // ako su useragent, ip i vrijeme u redu, pretpostavimo da je sve ok i potvrdimo sesiju
      }
    }
    $dbconn->close();

  }

  /** funkcija za provjeru postoji li korisnik po emailu **/
  function emailExists($instance, $email) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $email = $dbconn->real_escape_string($email);
    $sql = "SELECT * FROM " . $instance . "_users WHERE email = '$email' LIMIT 1";
    $res = $dbconn->query($sql);
    $dbconn->close();
    if ($res === false) {
      $this->throwError('databaseError');
    }
    if ($res->num_rows == 0) {
      return false;
    }
    else {
      return true;
    }

  }

  /** funkcija za provjeru postoji li korisnik po emailu **/
  function usernameExists($instance, $username) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $username = $dbconn->real_escape_string($username);
    $sql = "SELECT * FROM " . $instance . "_users WHERE username = '$username' LIMIT 1";
    $res = $dbconn->query($sql);
    $dbconn->close();
    if ($res === false) {
      $this->throwError('databaseError');
    }
    if ($res->num_rows == 0) {
      return false;
    }
    else {
      return true;
    }

  }

  /** funkcija za prebrojavanje neuspjelih prijava u prošlih pola sata **/
  function countRecentFailedLoginAttempts($instance, $username) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $username = $dbconn->real_escape_string($username);
    $user = $this->getUserID($instance, $username);
    $user = $dbconn->real_escape_string($user);
    $time = time() - 30 * 60;
    $sql = "SELECT * FROM " . $instance . "_sessions WHERE ip = '0.0.0.0' AND useragent = 'FAILED_ATTEMPT_NIGHTSPARROW_LOGIN' AND user = '$user' AND time >= '$time'";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      return $res->num_rows;
    }
    $dbconn->close();

  }

  /** funkcija za dobivanje ID korisnika ulogiranog u sesiju **/
  function getSessionUser($instance, $id) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = preg_replace("/[^0-9]/", '', $id);
    $sql = "SELECT * FROM " . $instance . "_sessions WHERE id = '$user' LIMIT 1";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError');
    }
    if ($res->num_rows == 0) {
      $this->throwError('unexpectedResult');
    }
    $sessions = $res->fetch_array();

    return $sessions['user'];
    $dbconn->close();

  }

  /** funkcija za dobivanje stvarnog imena korisnika **/
  function getUserRealname($instance, $id, $nameParam = 'guessedSpelling') {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $nameParam = $dbconn->real_escape_string($nameParam);
    $user = preg_replace("/[^0-9]/", '', $id);
    $sql = "SELECT * FROM " . $instance . "_users WHERE id = '$user' LIMIT 1";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError');
    }
    if ($res->num_rows == 0) {
      $this->throwError('');
    }
    $users = $res->fetch_array();
    $pid = $users['personID'];
    $sql = "SELECT * FROM " . $instance . "_people WHERE id = '$pid' LIMIT 1";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError');
    }
    if ($res->num_rows == 0) {
      $this->throwError('');
    }
    $users = $res->fetch_array();
    $dbconn->close();

    return $users[$nameParam];

  }

  /** vraća podatak o korisniku kad je zadan ID i vrsta podatka **/
  function getUserDataAPI($instance, $id, $data) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM " . $instance . "_users WHERE id = '$id' ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    if ($res->num_rows == 0) {
      return 404;
    }
    $user = $res->fetch_assoc();
    $dbconn->close();

    return $user[$data];

  }

  /** dohvatimo i vratimo CSRF token za određenu sesiju **/
  function getSessionCSRF($instance, $sessionid) {
    $dbconn = $this->mysqliConnect(); // inicijalizirajmo vezu s bazom
    /** escapeanje vrijednosti radi sprječavanja sql injectiona **/
    $sessionid = $dbconn->real_escape_string($sessionid);
    $instance = $dbconn->real_escape_string($instance);
    $getSessionQuery = "SELECT * FROM " . $instance . "_sessions WHERE id = '$sessionid'";
    $res = $dbconn->query($getSessionQuery);
    $sessions = [];
    while ($row = $res->fetch_assoc()) {
      $sessions[] = $row;
    }
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    if ($res->num_rows == 0) {
      return false; // ako nema rezultata, sesija nije valjana
    }
    $dbconn->close();
    foreach ($sessions as $session) {
      return $session['csrf'];
    }

  }

  /** obrišimo sesiju korisnika **/
  function deleteSession($instance, $id) {
    $dbconn = $this->mysqliConnect();
    $id = preg_replace("/[^0-9]/", '', $id);
    $instance = $dbconn->real_escape_string($instance);
    $res = $dbconn->query(
      "DELETE FROM " . $instance . "_sessions WHERE id = '$id'"
    ) or die($dbconn->error . $this->throwError('databaseError', 'queryFail'));
    // var_dump($res, $dbconn);
    $dbconn->close();

  }

  /** dohvati podatke o mapi **/
  function getFolderData($instance, $id) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $id = preg_replace("/[^0-9]/", '', $id);
    $query = "SELECT * FROM " . $instance . "_files WHERE id = '$id' AND type = 'folder'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $folderData = $res->fetch_assoc();
    $queryContents = "SELECT * FROM " . $instance . "_files WHERE parent = '$id'";
    $res = $dbconn->query($queryContents);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $contents = $res->fetch_all(MYSQLI_ASSOC);
    foreach ($contents as &$content) {
      $content['parentID'] = $content['parent'];
    }
    $folderData['contents'] = $contents;
    $folderData['parentID'] = $folderData['parent'];
    if ($folderData['parent'] != -1) {
      $pid = $folderData['parent'];
      $folderDataParentQuery = "SELECT name FROM " . $instance . "_files WHERE id = '$pid'";
      $res = $dbconn->query($folderDataParentQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
      $pd = $res->fetch_assoc();
      $folderData['parent'] = $pd['name'];
    }
    else {
      $folderData['parent'] = '';

    }

    return $folderData;
  }

  function addFile($instance, $filesData, $userID, $sessionID, $parent) {
    $dbconn = $this->mysqliConnect();
    if ($this->checkUserPrivilegeLevelFiles($instance, $parent, $userID) > 5) {
      var_dump($instance, $parent, $userID);
    }
    $instance = $dbconn->real_escape_string($instance);
    foreach ($filesData as $file) {
      $path = $dbconn->real_escape_string($file['path']);
      $size = preg_replace("/[^0-9]/", '', $file['size']);
      $name = $dbconn->real_escape_string($file['name']);
      $name = preg_replace("/[\/]/", '', $name);
      $type = $dbconn->real_escape_string($file['type']);
      $mimetype = $dbconn->real_escape_string($file['mimetype']);
      $userID = preg_replace("/[^0-9]/", '', $userID);
      $sessionID = preg_replace("/[^0-9]/", '', $sessionID);
      $parent = preg_replace("/[^0-9]/", '', $parent);
      $addFileQuery = "INSERT INTO " . $instance . "_files SET type='$type', mimetype='$mimetype', size=$size, name='$name', filePath='$path', parent=$parent";
      $res = $dbconn->query($addFileQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
      $id = $dbconn->insert_id;
      $id = preg_replace("/[^0-9]/", '', $id);
      $time = time();
      $time = preg_replace("/[^0-9]/", '', $time);
      $addRevisionQuery = "INSERT INTO " . $instance . "_filesOldRevisions SET fileID='$id', filePath = '$path', revisionAuthor = $userID, revisionSession=$sessionID, isCurrentRevision = 1, revisionTime = $time";
      $res = $dbconn->query($addRevisionQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
      $revID = $dbconn->insert_id;
      $updateRevIDQuery = "UPDATE " . $instance . "_files SET revisionID = $revID WHERE id = $id";
      $res = $dbconn->query($updateRevIDQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }

      $addShareQuery = "INSERT INTO {$instance}_fileShares SET fileID={$id}, fileShareType=0, userID={$userID}";
      $res = $dbconn->query($addShareQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
    }
    return $id;
  }

  function checkUserPrivilegeLevelFiles($instance, $fileID, $userID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $fileID = preg_replace("/[^0-9]/", '', $fileID);
    $userID = preg_replace("/[^0-9]/", '', $userID);
    if ($fileID == -1) {
      return 10;
    }
    if ($fileID == 0) {
      return 10;
    }
    $getDirectSharesQuery = "SELECT * FROM {$instance}_fileShares WHERE fileID = {$fileID} AND userID = {$userID} ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($getDirectSharesQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    if ($res->num_rows > 0) {
      $shares = $res->fetch_assoc();

      return $shares['fileShareType'];
    }
    else {
      $fileData = $this->getFileData($instance, $fileID);
      if ($fileData['parentID'] != -1 && $fileData['parentID'] != 0) {
        $this->checkUserPrivilegeLevelFiles(
          $instance, $fileData['parentID'], $userID
        );
      }
      elseif ($fileData['parentID'] == -1) {
        return 10;
      }
      elseif ($fileData['parentID'] == 0 && $fileData['type'] == 'file') {
        return 10;
      }
      else {
        return 11;
      }
    }
  }

  function getFileData($instance, $id) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $id = preg_replace("/[^0-9]/", '', $id);
    $query = "SELECT * FROM " . $instance . "_files WHERE id = '$id'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $fileData = $res->fetch_assoc();
    $pid = $fileData['parent'];
    $fileData['parentID'] = $pid;
    $fileDataParentQuery = "SELECT name FROM " . $instance . "_files WHERE id = '$pid'";
    $res = $dbconn->query($fileDataParentQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $pd = $res->fetch_assoc();
    $fileData['parent'] = $pd['name'];
    if (!empty($fileData['revisionID'])) {
      $fileDataRT = "SELECT revisionTime FROM {$instance}_filesOldRevisions WHERE revisionID = {$fileData['revisionID']}";
      $res = $dbconn->query($fileDataRT);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
      $rt = $res->fetch_assoc();
      $fileData['revisionTimestamp'] = $rt['revisionTime'];

    }
    else {
      $fileData['revisionTimestamp'] = -1;
    }
    $fileData['shares'] = $this->countShares($instance, $id);

    return $fileData;
  }

  function countShares($instance, $fileID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $fileID = preg_replace("/[^0-9]/", '', $fileID);
    $query = "SELECT COUNT(*) AS ShareCount FROM {$instance}_fileShares WHERE fileID={$fileID}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      $count = $res->fetch_assoc();
      $count = $count['ShareCount'];
    }
    $dbconn->close();

    return $count;
  }

  function isFileParseable($filepath) {
    $TLE = substr($filepath, -4);
    switch ($TLE) {
    case '.txt':
      return true;
      break;
    case '.doc':
      return true;
      break;
    case 'docx':
      return true;
      break;
    default:
      return false;
    }
  }

  function parseTextDocument($instance, $fileID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $fileID = preg_replace("/[^0-9]/", '', $fileID);
    $getFileQuery = "SELECT * FROM " . $instance . "_files WHERE id=$fileID";
    $res = $dbconn->query($getFileQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      $file = $res->fetch_assoc();
      $filePath = $file['filePath'];
    }
    $ft = substr($filePath, -4);
    if ($ft == '.doc') {

    }

  }

  function deleteFile($instance, $fileID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $fileID = preg_replace("/[^0-9]/", '', $fileID);
    $getFileQuery = "SELECT * FROM " . $instance . "_files WHERE id=$fileID";
    $res = $dbconn->query($getFileQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      $file = $res->fetch_assoc();
    }
    if ($file['type'] == 'file') {
      unlink($file['filePath']);
      $removeQuery = "DELETE FROM {$instance}_files WHERE id=$fileID";
      $res = $dbconn->query($removeQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
    }
    else {
      $getAllChildrenQuery = "SELECT * FROM {$instance}_files WHERE parent=$fileID";
      $res = $dbconn->query($getAllChildrenQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
      else {
        $files = $res->fetch_all(MYSQLI_ASSOC);
      }
      foreach ($files as $file) {
        $this->deleteFile($instance, $file['id']);
      }
      $removeQuery = "DELETE FROM {$instance}_files WHERE id=$fileID";
      $res = $dbconn->query($removeQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
    }
    $removeSharesQuery = "DELETE FROM {$instance}_fileShares WHERE fileID=$fileID";
    $res = $dbconn->query($removeSharesQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $removeRevisionsQuery = "DELETE FROM {$instance}_filesOldRevisions WHERE fileID=$fileID";
    $res = $dbconn->query($removeRevisionsQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
  }

  function filterMimetype($mimetype) {
    if (stripos($mimetype, " ") !== false) {
      substr($mimetype, 0, stripos($mimetype, " "));
    }
    if (stripos($mimetype, "\n") !== false) {
      substr($mimetype, 0, stripos($mimetype, " "));
    }
    if (stripos($mimetype, ";") !== false) {
      substr($mimetype, 0, stripos($mimetype, " "));
    }
    $mimetype = preg_replace("/[^0-9a-zA-z+\/.]/", '', $mimetype);

    return $mimetype;
  }

  function updateFile($instance, $fileID, $filePOST, $userID, $sessionID, $filename, $parent) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $fileID = preg_replace("/[^0-9]/", '', $fileID);
    if ($filePOST['files']['error'][0] != 4) {
      $file = $this->uploadFile($instance, $filePOST);
      $file = $file[0];
      $path = $dbconn->real_escape_string($file['path']);
      $size = preg_replace("/[^0-9]/", '', $file['size']);
      $mimetype = $dbconn->real_escape_string($file['mimetype']);
    }
    else {
      $file = null;
    }
    $name = $dbconn->real_escape_string($filename);
    $userID = preg_replace("/[^0-9]/", '', $userID);
    $sessionID = preg_replace("/[^0-9]/", '', $sessionID);
    $parent = preg_replace("/[^0-9]/", '', $parent);
    if ($file) {
      $addFileQuery = "UPDATE " . $instance . "_files SET mimetype='$mimetype', size=$size, name='$name', filePath='$path', parent=$parent WHERE id={$fileID}";
    }
    else {
      $addFileQuery = "UPDATE " . $instance . "_files SET name='$name', parent=$parent WHERE id={$fileID}";
    }
    $res = $dbconn->query($addFileQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $id = $dbconn->insert_id;
    $id = preg_replace("/[^0-9]/", '', $id);
    $time = time();
    $time = preg_replace("/[^0-9]/", '', $time);
    $addRevisionQuery = "INSERT INTO " . $instance . "_filesOldRevisions SET fileID='$id', filePath = '$path', revisionAuthor = $userID, revisionSession=$sessionID, isCurrentRevision = 1, revisionTime = $time";
    $res = $dbconn->query($addRevisionQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $revID = $dbconn->insert_id;
    $updateRevIDQuery = "UPDATE " . $instance . "_files SET revisionID = $revID WHERE id = $id";
    $res = $dbconn->query($updateRevIDQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
  }

  function uploadFile($instance, $filesArray) {
    $instance = preg_replace("/[^A-Za-z0-9]/", '', $instance);
    $count = 0;
    $files = $filesArray;
    foreach ($files['files']['size'] as $file) {
      $count++;
    }
    for ($i = 0; $i < $count; $i++) {
      $filenameOriginal = $files['files']['name'][$i];
      $fileSize = $files['files']['size'][$i];
      $files['files']['name'][$i] = substr(
          sha1($files['files']['name'][$i]), rand(0, 20), rand(0, 40)
        ) . '_' . strtolower(
          preg_replace("/[^A-Za-z0-9.]/", '', $files['files']['name'][$i])
        );
      //var_dump($files['files']['name'][$i]);
      if (strpos($files['files']['name'][$i], ".php") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".html") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".js") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".css") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".exe") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".jsp") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".sh") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if (strpos($files['files']['name'][$i], ".bat") !== false) {
        die('Žao nam je -- trenutno ne podržavamo prenošenje datoteka ove vrste.');
      }
      if ($files['files']['size'][$i] > 2628000000) {
        die('Žao nam je -- datoteka je prevelika. Podržavamo prenošenje datoteka do 250 MB.');
      }
      if (strlen($files['files']['name'][$i]) > 128) {
        die('Žao nam je -- ime datoteke je predugo. Podržavamo nazive datoteka duljine do 128 znakova.');
      }
      copy(
        $files['files']['tmp_name'][$i], rootdirpath . '../OblakUploads/' . $instance . '/' . $files['files']['name'][$i]
      );
      $fpath = rootdirpath . '../OblakUploads/' . $instance . '/' . $files['files']['name'][$i];
      chmod($fpath, 0644);
      $filesData[$i]['path'] = $fpath;
      $filesData[$i]['size'] = $fileSize;
      $filesData[$i]['name'] = $filenameOriginal;
      $filesData[$i]['type'] = 'file';
      $filesData[$i]['mimetype'] = $files['files']['type'][$i];

    }

    return $filesData;
  }

  // funkcije sortByParent i createTree bazirane na primjerima sa Stack Overflowa

  function getAllFoldersAUserCanAccess($instance, $userID, $limit = '150') {
    /* Ovakvo ponašanje jest značajno sporije nego što bi bilo da logiku obavlja SQL, ali je ta logika previše komplicirana da bih je kodirao u SQL-u :D */
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $userID = preg_replace("/[^0-9]/", '', $userID);
    $limit = preg_replace("/[^0-9]/", '', $limit);
    $query = "SELECT * FROM {$instance}_files WHERE type = 'folder' ORDER BY id ASC LIMIT {$limit}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      $files = $res->fetch_all(MYSQLI_ASSOC);
    }
    foreach ($files as $key => $file) {
      $priv = $this->checkUserPrivilegeLevelFiles($instance, $file['id'], $userID);
      if ($priv > 10) {
        unset($files[$key]);
      }
    }
    $files = $this->sortByParent($files);

    return $files;
  }

  function sortByParent($files) {
    //var_dump($files);
    $new = array();
    foreach ($files as $a) {
      $new[$a['parent']][] = $a;
    }
    $tree = $this->createTree($new, $new[0]); // changed
    return $tree;
  }

  function createTree(&$list, $parent) {
    $tree = array();
    foreach ($parent as $k => $l) {
      if (isset($list[$l['id']])) {
        $l['children'] = $this->createTree($list, $list[$l['id']]);
      }
      $tree[] = $l;
    }

    return $tree;
  }

  function createTreeOutput($tree, $output = 'name', $delimiter = '_', $out = '', $depth = 0, $i = 0) {
    foreach ($tree as $node) {
      if ($depth > 0) {
        $dem = "\n|" . str_repeat($delimiter, $depth) . " ";
      }
      else {
        $dem = "\n" . " ";
      }
      $out .= $dem . $node[$output] . "/ID:" . $node['id'];
      if (!empty($node['children'])) {
        $out = $this->createTreeOutput($node['children'], $output, $delimiter, $out, $depth + 1, $i + 1);
      }
    }

    return $out;
  }

  function getInstanceSetting($instance, $settingName) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $settingName = $dbconn->real_escape_string($settingName);
    $query = "SELECT * FROM {$instance}_siteSettings WHERE name = '{$settingName}' ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      $setting = $res->fetch_assoc();
    }

    return $setting;

  }

  function getGlobalSetting($settingName) {
    $dbconn = $this->mysqliConnect();
    $settingName = $dbconn->real_escape_string($settingName);
    $query = "SELECT * FROM globalConfig WHERE name = '{$settingName}' ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    else {
      $setting = $res->fetch_assoc();
    }

    return $setting;
  }

  function ioPrepare($string, $filtertype='XSS', $length=0){
    if($length){
      $string = substr($string, 0, $length);
    }
    if($filtertype=='nospecialchars-dashallowed'){
      $string = preg_replace("/[^A-Za-z0-9-_]/", '', $string);
    }
    elseif($filtertype=='nospecialchars'){
      $string = preg_replace("/[^A-Za-z0-9]/", '', $string);
    }
    elseif($filtertype=='number'){
      $string = preg_replace("/[^0-9]/", '', $string);
    }
    else{
      $string = str_replace("&", "&amp;", $string);
      $string = str_replace("<", "&lt;", $string);
      $string = str_replace(">", "&gt;", $string);
      $string = str_replace("\"", "&quot;", $string);
      $string = str_replace("'", "&#x27;", $string);
      $string = str_replace("/", "&#x2F;", $string);
    }

    return $string;
  }

  function sendEmail($email, $title, $template, $values)
  {

    $template = file_get_contents(rootdirpath . 'template/email/' . $template);
    foreach ($values as $name => $value) {
      $varcall = '{{' . $name . '}}';
      $title = str_replace($varcall, $value, $title);
      $template = str_replace($varcall, $value, $template);
    }
    $email = strip_tags($email);
    $headers = "From: Poslovni oblak (obavijesti)" . " <noreply.notifications@oblak.mbmjertan.co>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= 'Content-Type: text/html;charset=UTF-8\r\n';


    $res = mail($email, $title, $template, $headers);
    //echo $template;

  }

  function addToken($instance, $user){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = $dbconn->real_escape_string($user);
    $token = $dbconn->real_escape_string(bin2hex(openssl_random_pseudo_bytes(64)));
    $expon = time() + 60*60*2;
    $sql = "INSERT INTO {$instance}_resets VALUES (null, '{$token}', '{$user}', '{$expon}', 0)";

    $res = $dbconn->query($sql);
    if ($res === false) {

      $this->throwError('databaseError');
    }
    else{
      return $token;
    }
  }

  function resetUserPassword($instance, $token, $password)
  {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $token = $dbconn->real_escape_string($token);
    $password = $dbconn->real_escape_string($password);

    $sql = "SELECT * FROM {$instance}_resets WHERE token = '$token'";
    $res = $dbconn->query($sql);
    if ($res === false) {

      $this->throwError('databaseError');
    }
    if ($res->num_rows == 0) {

      $this->throwError('unexpectedResult');
    } else {
      $reset = $res->fetch_assoc();

      $user = $reset['user'];

    }
    if($reset['expon'] < time()){
      $this->throwError();
    }
    if($reset['used']){
      $this->throwError();
    }

    $password = $this->hashPassword($password);
    $password = $dbconn->real_escape_string($password);

    $sql = "UPDATE {$instance}_users SET password = '$password' WHERE id = '$user'";

    $res = $dbconn->query($sql);

    $sql = "UPDATE {$instance}_resets SET used = 1 WHERE token = '$token'";
    $res = $dbconn->query($sql);

    $time = $dbconn->real_escape_string(time());
    $ip = $dbconn->real_escape_string($_SERVER['REMOTE_ADDR']);

    $sql = "INSERT INTO {$instance}_logs VALUES (null, 'UPASSRES', $user, 'User {$user} password reset by user {$user} from {$ip}', $time)";
    $res = $dbconn->query($sql);
    echo 'Lozinka promijenjena';
    $this->deleteAllSessions($instance, $user);

    $dbconn->close();

  }

  function deleteAllSessions($instance, $user){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = preg_replace ("/[^0-9]/", '', $user);
    $res = $dbconn->query("DELETE FROM {$instance}_sessions WHERE user = '$user'");
    if($res === false){
      $this->throwError();
    }
    $dbconn->close();
  }

  function addPublicShare($instance, $fileID){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $fileID = preg_replace ("/[^0-9]/", '', $fileID);
    $pal = bin2hex(openssl_random_pseudo_bytes(32));
    $sql = "INSERT INTO {$instance}_fileShares VALUES (null, $fileID, 5, null, null, '$pal', null)";

    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $dbconn->close;
    return $pal;
  }
  function getFileFromPublicToken($instance, $token){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $token = $dbconn->real_escape_string($token);
    $sql = "SELECT * FROM {$instance}_fileShares WHERE publicAccessLink = '{$token}'";
    $res = $dbconn->query($sql);
    if($res === false){
     $this->throwError();
    }
    $set = $res->fetch_array();
    $dbconn->close;
    return $set['fileID'];

  }

  function settingExists($instance, $setting) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $setting = $dbconn->real_escape_string($setting);
    $query = "SELECT COUNT(*) AS SettingsCount FROM {$instance}_siteSettings WHERE name='{$setting}'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $count = $res->fetch_assoc();
    $count = $count['SettingsCount'];
    $dbconn->close();
    if ($count) {
      return true;
    }
    else {
      return false;
    }
  }
}


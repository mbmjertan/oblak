<?php

class Nightsparrow
{
    function __construct()
    {

    }

    /** javna funkcija za spajanje na mysqli bazu **/
    public function mysqliConnect()
    {
        $dbconn = new mysqli(mysql_server, mysql_user, mysql_password, mysql_database);
        if ($dbconn->connect_error) {
            $this->throwError('databaseError', 'connectionError', $dbconn);
        }

        return $dbconn;
    }


    /** funkcija za dodavanje korisnika, prima API zahtjev, koristiti kada je potrebno **/
    function addUserAPI($name, $email, $password, $level = 1)
    {
        $dbconn = $this->mysqliConnect();
        $name = $dbconn->real_escape_string($name);
        $email = $dbconn->real_escape_string($email);
        $password = $dbconn->real_escape_string($password);
        $level = $dbconn->real_escape_string($level);
        if ($level > 10) {
            die($this->throwError());
        }
        if ($level < 1) {
            die($this->throwError());
        }


        /**$arr = str_split('ABCDEFGHIJKLMNOPRSTUVZQYabcdefghijklmnoprstuvzqy1234567890');
         * shuffle($arr);
         * $arr = array_slice($arr, 0, rand(3, 58));
         * $r = implode('', $arr);
         * $uus = '$2a$07$' . $r . '$';**/
        $uus = null;

        //  $password = crypt($password, $uus);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $password = $dbconn->real_escape_string($password);

        $currentTime = time();
        $addUserQuery = "INSERT INTO nb_users VALUES(null, '$email', '$password', '$uus', '$name', '$level', 0, false, '$currentTime')";
        $res = $dbconn->query($addUserQuery);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        $dbconn->close();

    }


    /** funkcija za dodavanje vrijednosti postavke u bazu **/
    function addSetting($engine, $key, $value)
    {
        $dbconn = $this->mysqliConnect();
        $engine = $dbconn->real_escape_string($engine);
        $key = $dbconn->real_escape_string($key);
        $value = $dbconn->real_escape_string($value);


        $addSettingQuery = "INSERT INTO nb_settings VALUES(null, '$engine', '$key', '$value')";
        $res = $dbconn->query($addSettingQuery);

        if ($res === false) {
            $this->throwError('databaseError');
        }
        $dbconn->close();

    }

    /** debugging funkcija, izbacuje sve korisnike iz baze u array **/
    function getAllUsers()
    {
        $dbconn = $this->mysqliConnect();
        $res = $dbconn->query("SELECT * FROM nb_users") or die($dbconn->error . $this->throwError('databaseError'));
        $res->data_seek(0);
        while ($row = $res->fetch_row()) {
            return ($row);
        }
        $dbconn->close();

    }

    /** error handling. :D 'databaseError' = neuspješna radnja s databazom **/
    function throwError($errcode)
    {
        if (nsEnvironment == 'development') {
            $trace = debug_backtrace();
            $caller = $trace[1];
            var_dump($trace);
        }
        switch ($errcode) {
            case 'databaseError':
                include rootdirpath . 'template/errors/db.php';
                $dbconn->
                die();
                break;

            case '0x403403':
                include rootdirpath . 'template/errors/forbidden.php';
                die();
                break;

            case 'forbidden':
                include rootdirpath . 'template/errors/forbidden.php';
                die();
                break;

            case 'missingConfig':
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Pogreška</title></head><body style="background-color:#f7f7f7;color:#df5000;font-family:\'Helvetica\', \'Arial\'"><h1>:(</h1><h3>Pogreška sustava Nightsparrow</h3><p>Nightsparrow ne može pronaći datoteku konfiguracije, iako je instaliran. Ponovno pokrenite instalaciju ili ručno dodajte <i>config.php</i> datoteku.</p></body></html>';
                die();
                break;

            case 'unexpectedResult':
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Pogreška</title></head><body style="background-color:#f7f7f7;color:#df5000;font-family:\'Helvetica\', \'Arial\'"><h1>:(</h1><h3>Pogreška sustava Nightsparrow</h3><p>Dogodila se pogreška te Nightsparrow ne može nastaviti s obavljanjem zadatka. Kod pogreške: unexpectedesult</p></body></html>';
                die();
                break;

            case 'notfound':
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Pogreška</title></head><body style="background-color:#f7f7f7;color:#df5000;font-family:\'Helvetica\', \'Arial\'"><h1>:(</h1><h3>Greška 404</h3><p>Stranica koju ste tražili ne postoji.</p></body></html>';
                die();

            case '0x404404':
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Pogreška</title></head><body style="background-color:#f7f7f7;color:#df5000;font-family:\'Helvetica\', \'Arial\'"><h1>:(</h1><h3>Greška 404</h3><p>Stranica koju ste tražili ne postoji.</p></body></html>';
                die();

            default:
                include rootdirpath . "template/errors/404.php";
                die();
                break;
        }
        $dbconn->close();

    }

    /** provjeravanje lozinke za nečiji račun, vraća true ili false **/
    function checkPassword($email, $password)
    {
        $dbconn = $this->mysqliConnect();
        $dbconn->real_escape_string($email);
        $dbconn->real_escape_string($password);

        $userQuery = "SELECT * FROM nb_users WHERE email = '$email'";
        $res = $dbconn->query($userQuery);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        $matchingUsers = [];
        while ($row = $res->fetch_assoc()) {
            $matchingUsers[] = $row;
        }
        foreach ($matchingUsers as $row) {

            if (($row['salt'] != null) && (crypt($password, $row['salt']) == $row['password'])) {
                return true;
            } elseif (password_verify($password, $row['password']) === true) {
                return true;
            } else {
                return false;
            }
        }
        $dbconn->close();

    }

    /** postavi sesiju korisnika, portanje u tijeku iz pulsira **/
    function setUserSession($user, $ip, $useragent)
    {
        $dbconn = $this->mysqliConnect();
        $user = $dbconn->real_escape_string($user);
        $user = $this->getUserID($user);
        $user = $dbconn->real_escape_string($user);
        $ip = $dbconn->real_escape_string($ip);
        $useragent = $dbconn->real_escape_string($useragent);
        $time = $dbconn->real_escape_string(time());
        $expon = time() + (3 * 24 * 60 * 60);
        $arr = str_split('ABCDEFGHIJKLMNOPRSTUVZQYabcdefghijklmnoprstuvzqy1234567890');
        shuffle($arr);
        $arr = array_slice($arr, 0, rand(3, 58));
        $r = implode('', $arr);
        $csrf = $dbconn->real_escape_string(bin2hex(openssl_random_pseudo_bytes(32)));


        $x = $dbconn->real_escape_string(bin2hex(openssl_random_pseudo_bytes(32)));

        setcookie("ns_sessionx", $x, (time() + (60 * 60 * 24 * 3)), null, null, null, true);

        $sql = "INSERT INTO nb_sessions VALUES (null, '$user', '$ip', '$useragent', '$time', '$expon', '$csrf', '$x')";
        $res = $dbconn->query($sql);
        $id = $dbconn->insert_id;

        return $id;
        $dbconn->close();

    }

    /** validirajmo sesiju korisnika **/
    function validateUserSession($sessionid, $ip, $useragent, $time)
    {
        $dbconn = $this->mysqliConnect(); // inicijalizirajmo vezu s bazom
        /** escapeanje vrijednosti radi sprječavanja sql injectiona **/
        $sessionid = $dbconn->real_escape_string($sessionid);
        $ip = $dbconn->real_escape_string($ip);
        $useragent = $dbconn->real_escape_string($useragent);
        $time = $dbconn->real_escape_string($time);

        $getSessionQuery = "SELECT * FROM nb_sessions WHERE id = '$sessionid'";
        $res = $dbconn->query($getSessionQuery);

        $sessions = [];
        while ($row = $res->fetch_assoc()) {
            $sessions[] = $row;
        }
        if ($res === false) {
            return false; // pravit ćemo se da nije problem s bazom
        }
        if ($res->num_rows == 0) {
            return false; // ako nema rezultata, sesija nije valjana
        }
        foreach ($sessions as $session) {
            if ($session['expires'] < time()) {
                return false; // UNIX timestamp trenutnog vremena je veći od UNIX timestampa vremena isteka sesije -- sesija je istekla, vraćamo false
            } elseif ($session['useragent'] != $useragent) {
                return false; // user agent nije isti, možemo pretpostaviti da se ne radi o istom pregledniku, postoji šansa da je netko iskopirao sesiju
            } elseif ($session['ip'] != $ip) {
                return false; // ip nije isti. najvjerojatnije se nekomu ruter resetirao ili ima problema s mrežom, no radi sigurnosti je bolje poništiti sesiju ako se dogodi promjena ip adrese.
            } elseif ($_COOKIE['ns_sessionx'] != $session['cookieid']) {
                return false; // gledamo sigurnosni token :D
            } else {
                return true; // ako su useragent, ip i vrijeme u redu, pretpostavimo da je sve ok i potvrdimo sesiju
            }
        }
        $dbconn->close();

    }


    /** dohvatimo i vratimo CSRF token za određenu sesiju **/
    function getSessionCSRF($sessionid)
    {
        $dbconn = $this->mysqliConnect(); // inicijalizirajmo vezu s bazom
        /** escapeanje vrijednosti radi sprječavanja sql injectiona **/
        $sessionid = $dbconn->real_escape_string($sessionid);

        $getSessionQuery = "SELECT * FROM nb_sessions WHERE id = '$sessionid'";
        $res = $dbconn->query($getSessionQuery);

        $sessions = [];
        while ($row = $res->fetch_assoc()) {
            $sessions[] = $row;
        }
        if ($res === false) {
            return false; // pravit ćemo se da nije problem s bazom
        }
        if ($res->num_rows == 0) {
            return false; // ako nema rezultata, sesija nije valjana
        }
        foreach ($sessions as $session) {
            return $session['csrf'];
        }
        $dbconn->close();

    }

    /** funkcija za dobivanje id-a korisnika **/
    function getUserID($email)
    {
        $dbconn = $this->mysqliConnect();
        $email = $dbconn->real_escape_string($email);
        $sql = "SELECT * FROM nb_users WHERE email = '$email' LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            $this->throwError('unexpectedResult');
        }
        $users = $res->fetch_array();

        return $users['id'];
        $dbconn->close();

    }

    /** funkcija za provjeru postoji li korisnik **/
    function emailExists($email)
    {
        $dbconn = $this->mysqliConnect();
        $email = $dbconn->real_escape_string($email);
        $sql = "SELECT * FROM nb_users WHERE email = '$email' LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return false;
        } else {
            return true;
        }
        $dbconn->close();

    }


    /** funkcija za prebrojavanje neuspjelih prijava u prošlih pola sata **/
    function countRecentFailedLoginAttempts($email)
    {
        $dbconn = $this->mysqliConnect();
        $email = $dbconn->real_escape_string($email);
        $user = $this->getUserID($email);
        $user = $dbconn->real_escape_string($user);
        $time = time() - 30 * 60;
        $sql = "SELECT * FROM nb_sessions WHERE ip = '0.0.0.0' AND useragent = 'FAILED_ATTEMPT_NIGHTSPARROW_LOGIN' AND user = '$user' AND time >= '$time'";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        } else {
            return $res->num_rows;
        }
        $dbconn->close();

    }

    /** funkcija za dobivanje vrijednosti neke postavke **/
    function getSettingValue($engine, $setkey, $returnIfNotSet = null)
    {
        $dbconn = $this->mysqliConnect();
        $engine = $dbconn->real_escape_string($engine);
        $setkey = $dbconn->real_escape_string($setkey);
        $sql = "SELECT * FROM nb_settings WHERE engine = '$engine' AND setkey = '$setkey' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return $returnIfNotSet;
        }
        $settings = $res->fetch_assoc();

        return $settings['value'];
        $dbconn->close();

    }

    /** funkcija za dobivanje vrijednosti postojanja neke postavke **/
    function doesSettingExist($engine, $setkey)
    {
        $dbconn = $this->mysqliConnect();
        $engine = $dbconn->real_escape_string($engine);
        $setkey = $dbconn->real_escape_string($setkey);
        $sql = "SELECT * FROM nb_settings WHERE engine = '$engine' AND setkey = '$setkey' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {

            return false;
        } else {
            return true;
        }

        $dbconn->close();

    }


    /** funkcija za dobivanje razine privilegije korisnika, **prima ID korisnika** **/
    function getUserPrivilege($id)
    {
        $dbconn = $this->mysqliConnect();
        $user = $dbconn->real_escape_string($id);
        $sql = "SELECT * FROM nb_users WHERE id = '$user' LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            $this->throwError('unexpectedResult');
        }
        $users = $res->fetch_array();

        return $users['level'];
        $dbconn->close();

    }

    /** funkcija za dobivanje ID korisnika ulogiranog u sesiju **/
    function getSessionUser($id)
    {
        $dbconn = $this->mysqliConnect();
        $user = $dbconn->real_escape_string($id);
        $sql = "SELECT * FROM nb_sessions WHERE id = '$user' LIMIT 1";
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
    function getUserRealname($id)
    {
        $dbconn = $this->mysqliConnect();
        $user = $dbconn->real_escape_string($id);
        $sql = "SELECT * FROM nb_users WHERE id = '$user' LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            $this->throwError('');
        }
        $users = $res->fetch_array();

        return $users['name'];
        $dbconn->close();

    }

    /** sve postavke :D **/
    function getAllSettings()
    {
        $dbconn = $this->mysqliConnect();
        $res = $dbconn->query("SELECT * FROM nb_settings ORDER BY id DESC") or die($dbconn->error . $this->throwError('databaseError'));
        $res->data_seek(0);
        echo '<table><th>id</th><th>engine</th><th>setkey</th><th>value</th>';
        while ($row = $res->fetch_row()) {

            echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[3] . '</td></tr>';

        }
        echo '</table>';
        $dbconn->close();

    }

    /** vraća strukturu stranice, pozivati samo iz admin panela, namijenjeno za uređivanje **/
    function adminGetSiteStructureMap($parent = 0, $caller = 'index')
    {
        $dbconn = $this->mysqliConnect();
        $res = $dbconn->query("SELECT * FROM nb_pages WHERE parent = $parent ORDER BY id ASC") or die($dbconn->error . $this->throwError('databaseError'));
        //$structureMap = $res->fetch_all(MYSQLI_ASSOC);
        $structureMap = [];
        $csrfToken = $this->getSessionCSRF($_COOKIE['ns_sid']);
        while ($row = $res->fetch_assoc()) {
            $structureMap[] = $row;
        }

        if ((count($structureMap) == 0) && ($parent == 0)) {
            echo '<h2>:(</h2><h3>Još nema sadržaja na ovoj web stranici.</h3><p>Brzo, klikni na olovku i dodaj nešto!</p>';
        }
        foreach ($structureMap as $row) {
            $icons = '';
            if ($row['status'] == 1) {
                $icons = 'mdi-content-drafts indigo';
            }
            if ($row['status'] == 0) {
                $icons .= 'mdi-action-done green';
            }
            if ($row['status'] == 3) {
                $icons = 'mdi-content-archive teal lighten-4';
            }
            if ($row['showinnav'] == 0) {
                $icons = 'mdi-action-visibility-off ';
            }
            if ($row['postpassword'] != '') {
                $icons = 'mdi-action-lock-outline cyan';
            }
            $title = $row['title'];
            $author = $this->getUserDataApi($row['author'], 'name');
            $summary = $row['summary'];
            $slug = $row['slug'];
            $subpg = $this->countNumberOfChildPages($row['id']);
            if ($row['parent'] == 0) {
                echo '<li class="collection-item avatar">
        <i class="' . $icons . ' circle"></i>
        <span class="title">' . $title . '</span>
        <p>' . $summary . '<br> <b>Autor: </b>' . $author . '</p>
        <span class="secondary-content"><a href="add.php?update=' . $slug . '"><i class="mdi-editor-mode-edit"></i></a> <a href="index.php?setAsHomepage=' . $slug . '&csrfToken=' . $csrfToken . '"><i class="material-icons" style="font-size:16px;">home</i></a><a href="add.php?parent=' . $slug . '"><i class="material-icons" style="font-size:16px;">note_add</i></a></span></li>';
                if ($subpg > 3) {
                    echo '<li class="collection-item avatar indent"> <i class="mdi-image-navigate-next blue lighten-2 circle"></i><span class="title">Ova stranica ima djecu.</span> <a href="index.php?showSubstructureMap=' . $this->getPageAPI($row['slug'])['parent'] . '">Prikaži substrukturu</a></i>';
                } else {
                    $this->adminGetSiteStructureMap($row['id'], 'admin');
                }
            } else {

                if ($caller == 'admin') {
                    if ($subpg > 3) {
                        echo '<li class="collection-item avatar indent"> <i class="mdi-image-navigate-next blue lighten-2 circle"></i><span class="title">Ova stranica ima djecu.</span> <a href="index.php?showSubstructureMap=' . $row['id'] . '">Prikaži substrukturu</a></i>';
                    } else {
                        echo '<li class="collection-item avatar indent">
             <i class="' . $icons . ' circle"></i>
             <span class="title">' . $title . '</span>
             <p>' . $summary . '<br> <b>Autor: </b>' . $author . '</p>
             <span class="secondary-content"><a href="add.php?update=' . $slug . '"><i class="mdi-editor-mode-edit"></i></a> <a href="index.php?setAsHomepage=' . $slug . '&csrfToken=' . $csrfToken . '"><i class="material-icons" style="font-size:16px;">home</i></a><a href="add.php?parent=' . $slug . '"><i class="material-icons" style="font-size:16px;">note_add</i></a></span></li>';
                        if ($this->countNumberOfChildPages($row['id']) > 0) {
                            echo '<li class="collection-item avatar indent"> <i class="mdi-image-navigate-next blue lighten-2 circle"></i><span class="title">Ova stranica ima djecu.</span> <a href="index.php?showSubstructureMap=' . $row['id'] . '">Prikaži substrukturu</a></i>';
                        }
                    }

                } else {
                    echo '<li class="collection-item avatar">
          <i class="' . $icons . ' circle"></i>
          <span class="title">' . $title . '</span>
          <p>' . $summary . '<br> <b>Autor: </b>' . $author . '</p>
          <span class="secondary-content"><a href="add.php?update=' . $slug . '"><i class="mdi-editor-mode-edit"></i></a> <a href="index.php?setAsHomepage=' . $slug . '&csrfToken=' . $csrfToken . '"><i class="material-icons" style="font-size:16px;">home</i></a><a href="add.php?parent=' . $slug . '"><i class="material-icons" style="font-size:16px;">note_add</i></a></span></li>';
                    $this->adminGetSiteStructureMap($row['id'], 'admin');
                }
            }
        }
        $dbconn->close();

    }

    function countNumberOfChildPages($id)
    {
        $dbconn = $this->mysqliConnect();
        $id = $dbconn->real_escape_string($id);
        $res = $dbconn->query("SELECT parent, COUNT(*) AS count FROM nb_pages WHERE parent = '$id' ORDER BY count DESC") or die($this->throwError());

        return $res->fetch_assoc()['count'];
    }


    /** vraća popis korisnika stranice **/
    function adminGetUserList()
    {
        $dbconn = $this->mysqliConnect();
        $res = $dbconn->query("SELECT * FROM nb_users ORDER BY name ASC") or die($dbconn->error . $this->throwError('databaseError'));
        $structureMap = [];
        while ($row = $res->fetch_assoc()) {
            $structureMap[] = $row;
        }
        $neededPrivilege = $this->getSettingValue('core', 'adminPanelPermissionManageNonselfUser');
        $actualPrivilege = $this->getUserPrivilege($this->getSessionUser($_COOKIE['ns_sid']));
        if ($actualPrivilege < $neededPrivilege) {
            $canEdit = false;
        } else {
            $canEdit = true;
        }
        foreach ($structureMap as $row) {
            $gravatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($row['email']))) . "?d=identicon&s=40";
            $name = $row['name'];
            $email = $row['email'];
            echo '<li class="collection-item avatar">
      <img src="' . $gravatar . '" class="circle">
      <span class="title">' . $name . '</span>';
            if ($canEdit == true) {
                echo '<p>' . $email . '  <a href="user.php?id=' . $row['id'] . '"class="secondary-content"><i class="mdi-editor-mode-edit"></i></a></p></li>';
            } else {
                if ($canEdit == true) {
                    echo '<p>' . $email . '';
                }
            }
            $dbconn->close();

        }

    }


    /** email -> avatar **/

    function getAvatarFromEmail($email)
    {
        $isRegisteredUser = $this->emailExists($email);
        $userID = $this->getUserID($email);
        if ($isRegisteredUser == true) {
            $hasSystemAvatar = $this->doesSettingExist("metadataManager", "users/avatarManager/" . $id);
            if ($hasSystemAvatar == true) {
                $systemAvatarURL = $this->getSettingValue("metadataManager", "users/avatarManager/" . $id);

                return $systemAvatarURL;
            } else {
                $gravatarDisabled = $this->doesSettingExist("metadataManager", "users/gravatarDisabled");
                if ($gravatarDisabled == true) {
                    return domainpath . 'template/icons/user.png';
                }
                $gravatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($row['email']))) . "?d=identicon&s=40";

                return $gravatar;
            }
        } else {
            $gravatarDisabled = $this->doesSettingExist("metadataManager", "users/gravatarDisabled");
            if ($gravatarDisabled == true) {
                return domainpath . 'template/icons/user.png';
            }
            $gravatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($row['email']))) . "?d=identicon&s=40";

            return $gravatar;
        }
    }




    /**briše zadnju stranicu sa zadanim slugom **/
    function deletePageWithSlug($slug)
    {
        $dbconn = $this->mysqliConnect();
        $slug = $dbconn->real_escape_string($slug);
        $sql = "DELETE FROM nb_pages WHERE slug = '$slug' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        $dbconn->close();

    }

    /**briše korisnika sa zadanim ID-jem **/
    function deleteUser($id)
    {
        $dbconn = $this->mysqliConnect();
        $id = $dbconn->real_escape_string($id);
        $sql = "DELETE FROM nb_users WHERE id = '$id'";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        $time = $dbconn->real_escape_string(time());
        $subject = $this->getSessionUser($_COOKIE['ns_sid']);
        if ($this->getUserPrivilege($subject) >= $this->getSettingValue('core', 'adminPanelManageNonselfUser')) {
            $ip = $dbconn->real_escape_string($_SERVER['REMOTE_ADDR']);
            $sql = "INSERT INTO nb_securitylogs VALUES (null, 'userDelete:AdminPanel', '$subject', '$id', '$time', '$ip')";
            $res = $dbconn->query($sql);
            $dbconn->close();
        } else {
            $this->throwError('forbidden');
        }
    }

    /** vraća metapodatke stranice kada je zadan slug (identifier) **/
    function getPageAPI($identifier)
    {
        switch ($identifier) {
            case 'homepage':
                $grabFile = 'home.txt';
                break;

            case '404':
                $grabFile = '404.txt';
                break;

            default:
                $grabFile = 'page.txt';
                break;
        }

        $dbconn = $this->mysqliConnect();
        $identifier = str_replace("'", "", $identifier);
        $identifier = str_replace("\"", "", $identifier);
        $identifier = str_replace("%", "", $identifier);
        $sql = "SELECT * FROM nb_pages WHERE slug = '$identifier' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return 404;
        }
        $pages = $res->fetch_assoc();

        return $pages;
        $dbconn->close();


    }

    /** vraća metapodatke mjesta kada je zadan id broj (identifier) **/
    function getPlaceAPI($identifier)
    {
        switch ($identifier) {
            case 'homepage':
                $grabFile = 'home.txt';
                break;

            case '404':
                $grabFile = '404.txt';
                break;

            default:
                $grabFile = 'page.txt';
                break;
        }

        $dbconn = $this->mysqliConnect();
        $identifier = str_replace("'", "", $identifier);
        $identifier = str_replace("\"", "", $identifier);
        $identifier = str_replace("%", "", $identifier);
        $sql = "SELECT * FROM nb_places WHERE id = '$identifier' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return 404;
        }
        $pages = $res->fetch_assoc();

        return $pages;
        $dbconn->close();


    }

    /** vraća podatak o korisniku kad je zadan ID i vrsta podatka **/
    function getUserDataAPI($id, $data)
    {
        $dbconn = $this->mysqliConnect();
        $sql = "SELECT * FROM nb_users WHERE id = '$id' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return 404;
        }
        $user = $res->fetch_assoc();

        return $user[$data];
        $dbconn->close();


    }




    /** dobavlja posljednjih x stranica s odrednicom vrste y i statusom z te ih vraća kao višedimenzionalni array **/
    function getLatestPagesWithTypeAndStatusAPI($numberOfPages, $type, $status)
    {
        $dbconn = $this->mysqliConnect();
        $numberOfPages = $dbconn->real_escape_string($numberOfPages);
        $type = $dbconn->real_escape_string($type);
        $status = $dbconn->real_escape_string($status);
        $sql = "SELECT * FROM nb_pages WHERE type = '$type' AND status = '$status' ORDER BY id DESC LIMIT $numberOfPages";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return 404;
        }
        $pages = array();
        while ($page = $res->fetch_assoc()) {
            $pages[] = $page;
        }

        return $pages;
        $dbconn->close();


    }


    /** dobavlja posljednjih x stranica djece određene stranice s odrednicom vrste y i statusom z te ih vraća kao višedimenzionalni array **/
    function getLatestChildrenPagesOfPageWithTypeAndStatusAPI($parent, $numberOfPages, $type, $status)
    {
        $dbconn = $this->mysqliConnect();
        $numberOfPages = $dbconn->real_escape_string($numberOfPages);
        $type = $dbconn->real_escape_string($type);
        $status = $dbconn->real_escape_string($status);
        $parent = $dbconn->real_escape_string($parent);
        $sql = "SELECT * FROM nb_pages WHERE type = '$type' AND status = '$status' AND parent = '$parent' ORDER BY id DESC LIMIT $numberOfPages";
        //var_dump($sql);
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return 404;
        }
        $pages = array();
        while ($page = $res->fetch_assoc()) {
            $pages[] = $page;
        }

        return $pages;
        $dbconn->close();


    }


    function slugExists($slug)
    {

        $dbconn = $this->mysqliConnect();

        $sql = "SELECT * FROM nb_pages WHERE slug = '$slug' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            return false;
        } else {
            return true;
        }

    }

    function getSlugFromDBID($id)
    {

        $dbconn = $this->mysqliConnect();
        $identifier = str_replace("'", "", $identifier);
        $identifier = str_replace("\"", "", $identifier);
        $identifier = str_replace("%", "", $identifier);
        $sql = "SELECT * FROM nb_pages WHERE id = '$id' ORDER BY id DESC LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            $dbconn->close();

            return 404;
        } else {
            $pages = $res->fetch_assoc();
            $dbconn->close();

            return $pages['slug'];
        }
    }

    /** dodajmo stranicu :D **/
    function addPage(
      $type,
      $slug,
      $status,
      $title,
      $body,
      $author,
      $summary,
      $sources,
      $mainimg,
      $password,
      $tags,
      $category,
      $parent,
      $showinnav
    ) {
        $dbconn = $this->mysqliConnect();
        $type = $dbconn->real_escape_string($type);
        $slug = $dbconn->real_escape_string($slug);
        if ($this->slugExists($slug) == true) {
            $slug = $slug . '-' . time();
            $slug = $dbconn->real_escape_string($slug);
            echo '<div class="card-panel"><span class="blue-text text-darken-2"><i class="mdi-alert-warning"></i> Budući da je već postojala stranica s istom kratkom oznakom, Nightsparrow je promijenio kratku oznaku ove stranice u <code>' . $slug . '</code>.</span></div>';

        }

        $status = $dbconn->real_escape_string($status);
        $title = $dbconn->real_escape_string($title);
        $body = $dbconn->real_escape_string($body);
        $author = $dbconn->real_escape_string($author);
        $summary = $dbconn->real_escape_string($summary);
        $sources = $dbconn->real_escape_string($sources);
        $mainimg = $dbconn->real_escape_string($mainimg);
        $password = $dbconn->real_escape_string($password);
        $tags = $dbconn->real_escape_string($tags);
        $showinnav = $dbconn->real_escape_string($showinnav);
        $category = $dbconn->real_escape_string($category);
        $parentData = $this->getPageAPI($parent);
        $parent = $dbconn->real_escape_string($parentData['id']);
        $time = $dbconn->real_escape_string(time());
        $sql = "INSERT INTO nb_pages VALUES(null, '$type', '$showinnav', '$password', '', '$status',  '$time', '$tags', '$category', '$parent',  '$title', '$body', '$author', '$summary', '$sources', '$mainimg', '$slug'); ";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        } else {
            echo '<div class="card-panel"><span class="blue-text text-darken-2"><i class="mdi-image-tag-faces"></i> Stranica uspješno dodana</span></div>';
        }

        $dbconn->close();

    }


    /** uredimo stranicu :D **/
    function updatePage(
      $type,
      $slug,
      $status,
      $title,
      $body,
      $author,
      $summary,
      $sources,
      $mainimg,
      $password,
      $tags,
      $category,
      $parent,
      $showinnav,
      $originalSlug
    ) {
        $dbconn = $this->mysqliConnect();
        $type = $dbconn->real_escape_string($type);
        $slug = $dbconn->real_escape_string($slug);
        $status = $dbconn->real_escape_string($status);
        $title = $dbconn->real_escape_string($title);
        $body = $dbconn->real_escape_string($body);
        $summary = $dbconn->real_escape_string($summary);
        $showinnav = $dbconn->real_escape_string($showinnav);
        $sources = $dbconn->real_escape_string($sources);
        $mainimg = $dbconn->real_escape_string($mainimg);
        $password = $dbconn->real_escape_string($password);
        $tags = $dbconn->real_escape_string($tags);
        $category = $dbconn->real_escape_string($category);
        $parent = $dbconn->real_escape_string($parent);
        $originalSlug = $dbconn->real_escape_string($originalSlug);
        $time = $dbconn->real_escape_string(time());

        $homepage = $this->getSettingValue('core', 'homepageSlug');


        $sql = "UPDATE nb_pages SET title = '$title', status='$status', body = '$body', author = '$author', time = '$time', tags = '$tags', summary = '$summary', slug = '$slug', sources='$sources', showinnav = '$showinnav' WHERE slug = '$originalSlug'";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        } else {
            echo '<div class="card-panel"><span class="blue-text text-darken-2"><i class="mdi-image-tag-faces"></i> Stranica uspješno uređena</span></div>';
        }

        if (($originalSlug == $homepage) && ($originalSlug != $slug)) {
            $this->addSetting('core', 'homepageSlug', $slug);
            echo '<div class="card-panel"><span class="blue-text text-darken-2"><i class="mdi-image-tag-faces"></i> Stranica zadržana kao početna</span></div>';

        }

        $dbconn->close();

    }



    /** obrišimo sesiju korisnika **/
    function deleteSession($id)
    {
        $dbconn = $this->mysqliConnect();
        $id = $dbconn->real_escape_string($id);
        $res = $dbconn->query("DELETE FROM nb_sessions WHERE id = '$id'") or die($dbconn->error . $this->throwError('databaseError'));

        $dbconn->close();

    }

    /** obrišimo sve sesije korisnika **/
    function deleteAllSessions($user)
    {
        $dbconn = $this->mysqliConnect();
        $user = $dbconn->real_escape_string($user);
        if ($_COOKIE['ns_sid'] != 'loggedout') {
            $subject = $this->getSessionUser($_COOKIE['ns_sid']);
        } else {
            $subject = $user;
        }
        $res = $dbconn->query("DELETE FROM nb_sessions WHERE user = '$user'");
        $time = $dbconn->real_escape_string(time());
        $ip = $dbconn->real_escape_string($_SERVER['REMOTE_ADDR']);
        $sql = "INSERT INTO nb_securitylogs VALUES (null, 'user:DeleteAllSessions', '$subject', '$user', '$time', '$ip')";
        $res = $dbconn->query($sql);
        $dbconn->close();

    }

    function uploadPhoto($files)
    {
        require_once "bulletproof/src/bulletproof.php";
        $image = new ImageUploader\BulletProof;
        $path = $image->fileTypes(["png", "jpeg", "jpg", "gif"])//only accept png/jpeg image types
        ->uploadDir(rootdirpath . "uploads")->limitSize([
          "min" => 1000,
          "max" => 200000000
        ])//limit image size (in bytes)
        ->limitDimension(["height" => 4096, "width" => 4096])//limit image dimensions
        ->upload($files['file']);  // upload to folder
        return $path;
    }

    function generatePasswordResetToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(32));

        return $token;
    }

    function uploadFile($files)
    {
        $files['file']['name'] = substr(sha1($files['file']['name']), rand(0, 20),
            rand(0, 40)) . '_' . strtolower($files['file']['name']);
        if (strpos($files['file']['name'], ".php") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".html") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".js") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".css") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".exe") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".jsp") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".sh") !== false) {
            die('Unaccepted file type.');
        }
        if (strpos($files['file']['name'], ".bat") !== false) {
            die('Unaccepted file type.');
        }
        if ($files['file']['size'] > 10485760) {
            die('File too big.');
        }
        if (strlen($files['file']['name']) > 225) {
            die('Filename too long.');
        }
        copy($files['file']['tmp_name'], rootdirpath . 'uploads/' . $files['file']['name']);

        return rootdirpath . 'uploads/' . $files['file']['name'];
    }

    function setUserPasswordResetToken($email, $token, $ip)
    {
        $dbconn = $this->mysqliConnect();
        $email = $dbconn->real_escape_string($email);
        $user = $this->getUserID($email);
        $user = $dbconn->real_escape_string($user);
        $token = $dbconn->real_escape_string($token);

        $time = $dbconn->real_escape_string(time());

        $sql = "INSERT INTO nb_resets VALUES (null, '$user', '$token', '$ip', '$time', '0')";
        $res = $dbconn->query($sql);

        $id = $dbconn->insert_id;

        return $id;
        $dbconn->close();

    }


    function sendEmail($email, $title, $template, $values)
    {

        $template = file_get_contents(rootdirpath . 'template/email/' . $template);
        foreach ($values as $name => $value) {
            $varcall = '{{' . $name . '}}';
            $title = str_replace($varcall, $value, $title);
            $template = str_replace($varcall, $value, $template);
        }
        //var_dump($title, $template);
        $email = strip_tags($email);
        $domain = $_SERVER['SERVER_NAME'];
        $headers = "From: " . $this->getSettingValue('core',
            'siteName') . " (obavijesti)" . " <noreply.notifications@" . $domain . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= 'Content-Type: text/html;charset=UTF-8\r\n';


        $res = mail($email, $title, $template, $headers);
        //echo $template;

        /**
         * Ako je Nightsparrow instaliran na serveru koji nema konfigurirano slanje e-mailova, poput, *
         * recimo, gotovo svakog lokalnog servera, nećete biti u mogućnosti primiti poruku koju Nightsparrow "pošalje". *
         * Ako želite isprobati ovu funkcionalnost na način da Nightsparrow prikaže e-mail u pregledniku, zakomentirajte liniju *
         * $res = mail(...) *
         * i odkomentirajte liniju
         * echo $template; */
    }


    /** promjene lozinki su zabavne **/
    function resetUserPassword($token, $password)
    {
        $dbconn = $this->mysqliConnect();
        $token = $dbconn->real_escape_string($token);
        $password = $dbconn->real_escape_string($password);
        $time = $dbconn->real_escape_string(time());

        $sql = "SELECT * FROM nb_resets WHERE passwordToken = '$token'";
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

        $password = password_hash($password, PASSWORD_DEFAULT);
        $password = $dbconn->real_escape_string($password);

        $sql = "UPDATE nb_users SET password = '$password' WHERE id = '$user'";

        $res = $dbconn->query($sql);

        $sql = "UPDATE nb_resets SET used = 1 WHERE passwordToken = '$token'";
        $res = $dbconn->query($sql);

        $time = $dbconn->real_escape_string(time());
        $ip = $dbconn->real_escape_string($_SERVER['REMOTE_ADDR']);

        $sql = "INSERT INTO nb_securitylogs VALUES (null, 'passwordChange:Reset', '$user', '$user', '$time', '$ip')";
        $res = $dbconn->query($sql);
        echo 'Lozinka promijenjena';
        $this->deleteAllSessions($user);
        $dbconn->close();

    }

    /** uredimo korisnika :D **/
    function updateUser($id, $email, $password, $name, $level, $banned)
    {
        $dbconn = $this->mysqliConnect();
        $id = $dbconn->real_escape_string($id);
        $email = $dbconn->real_escape_string($email);
        $password = $dbconn->real_escape_string($password);
        $name = $dbconn->real_escape_string($name);
        $level = $dbconn->real_escape_string($level);
        $banned = $dbconn->real_escape_string($banned);


        $time = $dbconn->real_escape_string(time());

        if (($level != null) && ($this->getUserPrivilege($this->getSessionUser($_COOKIE['ns_sid'])) != $this->getSettingValue('core',
              'adminPanelPermissionManageNonselfUser'))
        ) {
            die($this->throwError('forbidden'));
        }

        if ($level == null) {
            $level = $this->getUserPrivilege($id);
        }

        if ($banned == 1) {
            $this->deleteAllSessions($id);
        }

        $sql = "UPDATE nb_users SET email = '$email', name = '$name', level = '$level', banned = '$banned' WHERE id = '$id'";

        $subject = $this->getSessionUser($_COOKIE['ns_sid']);


        $res = $dbconn->query($sql);

        $ip = $dbconn->real_escape_string($_SERVER['REMOTE_ADDR']);
        $sql = "INSERT INTO nb_securitylogs VALUES (null, 'userChange:adminPanel', '$subject', '$id', '$time', '$ip')";
        $res = $dbconn->query($sql);

        if ($res === false) {
            $this->throwError('databaseError');
        }

        if ($res === false) {
            $this->throwError('databaseError');
        } else {
            echo '<div class="card-panel"><span class="blue-text text-darken-2"><i class="mdi-image-tag-faces"></i> Korisnik uspješno uređen</span></div>';
        }


        if ($password != null) {
            $uus = null;
            $password = password_hash($password, PASSWORD_DEFAULT);
            $password = $dbconn->real_escape_string($password);

            $sql = "UPDATE nb_users SET password = '$password', salt = '$uus' WHERE id = '$id'";

            $res = $dbconn->query($sql);


            $time = $dbconn->real_escape_string(time());
            $ip = $dbconn->real_escape_string($_SERVER['REMOTE_ADDR']);
            $this->deleteAllSessions($id);
            $sql = "INSERT INTO nb_securitylogs VALUES (null, 'passwordChange:AdminPanel', '$subject', '$id', '$time', '$ip')";
            $res = $dbconn->query($sql);
            if ($res === false) {
                $this->throwError('databaseError');
            }

        }

        $dbconn->close();

    }

    function passwordResetTokenValid($token)
    {

        $dbconn = $this->mysqliConnect();
        $token = $dbconn->real_escape_string($token);
        $sql = "SELECT * FROM nb_resets WHERE passwordToken = '$token' LIMIT 1";
        $res = $dbconn->query($sql);
        if ($res === false) {
            $this->throwError('databaseError');
        }
        if ($res->num_rows == 0) {
            $this->throwError('unexpectedResult');
        }
        $reset = $res->fetch_array();
        $dbconn->close();

        $t1 = time();
        $t2 = $reset['time'] + 2 * 60 * 60;

        if ($reset['used'] == 1) {
            return 0;
        } elseif (($t2 - $t1) > 2 * 60 * 60) {

            return 0;
        } else {
            return 1;
        }
    }

    function getComments($page)
    {
        $dbconn = $this->mysqliConnect();
        $page = $dbconn->real_escape_string($page);
        $sql = "SELECT FROM nb_comments WHERE parentPost = '$page' ORDER BY time ASC LIMIT 500";
        $res = $dbconn->query($sql) or die($this->throwError());
        $comments = [];
        $res->data_seek(0);
        while ($row = $res->fetch_row()) {
            array_push($comments, $row);
        }

        return $comments;
    }

    /** gets all sessions. unlike some getAllX functions, returns an array instead of HTML output. HTML output is generated by generateSessionsTable function in templates.php **/
    function getAllSessions($user)
    {
        $dbconn = $this->mysqliConnect();
        $user = $dbconn->real_escape_string($user);
        $res = $dbconn->query("SELECT * FROM nb_sessions WHERE user = '$user' ORDER BY id DESC") or die($dbconn->error . $this->throwError('databaseError'));
        $sessions = [];
        $res->data_seek(0);
        while ($row = $res->fetch_assoc()) {
            $sessions[] = $row;

        }
        $dbconn->close();

        return $sessions;

    }


} // kraj klase

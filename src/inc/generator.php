<?php

/**
 * Created by PhpStorm.
 * User: mbm
 * Date: 08/07/15
 * Time: 23:33
 */
class PageGenerator extends Nightsparrow
{
    function __construct()
    {
        include 'depends/PhpUserAgent.php';
    }

    function PageViewGenerator($pageID, $template)
    {
        $temp = $template;
        if ($pageID == 'homepage') {
            if ($this->getSettingValue('core', 'homepageSlug') !== null) {
                $data = $this->getPageAPI($this->getSettingValue('core', 'homepageSlug'));
            } else {
                die(include rootdirpath . 'template/errors/nohomepage.php');
            }
        } elseif ($pageID == '') {
            $this->throwError(0x404404);
        } else {
            $data = $this->getPageAPI($pageID);
        }
        if ($data['status'] != 0) {
            die('0x403403');
        }
        if (($data['postpassword'] != "") && ($data['postpassword'] != null)) {
            die(header('Location: ' . domainpath . 'authenticate' . $pageID . ''));
        }
        $data['authorName'] = $this->getUserRealname($data['author']);
        $templatePath = rootdirpath . 'template/' . $template . '/' . 'page.txt';

        if ($data['type'] == 'blog') {
            $templatePath = rootdirpath . 'template/' . $template . '/' . 'blog.txt';
        }
        if ($pageID == 'homepage') {
            $templatePath = rootdirpath . 'template/' . $template . '/' . 'homepage.txt';
        }

        $pageTemplate = file_get_contents($templatePath);

        $pageTitle = $data['title'] . ' - ' . $this->getSettingValue('core', 'siteName');
        $pageTemplate = str_replace('%%header%%',
          file_get_contents(rootdirpath . 'template/' . $template . '/' . 'header.txt'), $pageTemplate);
        $pageTemplate = str_replace('{{pageTitleElement}}', $pageTitle, $pageTemplate);
        $pageTemplate = str_replace('{{timestamp}}', $data['time'], $pageTemplate);
        $pageTemplate = str_replace('%%navigation%%', $this->NavigationGenerator($pageID, $template), $pageTemplate);
        $pageTemplate = str_replace('%%footer%%',
          file_get_contents(rootdirpath . 'template/' . $template . '/' . 'footer.txt'), $pageTemplate);
        $pageTemplate = str_replace('{{domainpath}}', domainpath, $pageTemplate);
        $pageTemplate = str_replace('{{siteName}}', $this->getSettingValue('core', 'siteName'), $pageTemplate);
        $pageTemplate = str_replace('{{siteDescription}}', $this->getSettingValue('core', 'siteDescription'),
          $pageTemplate);
        $pageTemplate = str_replace('{{design.headerContent}}', $this->getSettingValue('design', 'headerContent'),
          $pageTemplate);
        $pageTemplate = str_replace('{{design.footerContent}}', $this->getSettingValue('design', 'footerContent'),
          $pageTemplate);
        $pageTemplate = str_replace('{{design.logoLink}}', $this->getSettingValue('design', 'logoLink'), $pageTemplate);
        if ($data['type'] != 'blog') {
            foreach ($data as $item => $value) {

                $key = '{{' . $item . '}}';
                $pageTemplate = str_replace($key, $value, $pageTemplate);

            }


            $subpg = $this->countNumberOfChildPages($this->getPageAPI($pageID)['id']);

            if (($subpg > 0) && ($subpg < 21) && ($pageID != 'homepage')) {
                $navpg = $this->getLatestChildrenPagesOfPageWithTypeAndStatusAPI($data['id'], 20, 'page', 0);
                //$navbg = $this->getLatestChildrenPagesOfPageWithTypeAndStatusAPI($data['id'], 20, 'blog', 0);
                $subnavpg = $this->SubnavigationGenerator($navpg, $template);
                $pageTemplate = str_replace('%%subnavigation%%', $subnavpg, $pageTemplate);
                //$pageTemplate = str_replace('%%subnavigation%%', $this->SubnavigationGenerator($navbg, $template), $pageTemplate);
            } else {

                $pageTemplate = str_replace('%%subnavigation%%', "", $pageTemplate);

            }


            echo $pageTemplate;
        } else {

            $blogObjectData = $data;
            $data = $this->getLatestChildrenPagesOfPageWithTypeAndStatusAPI($data['id'],
              $this->getSettingValue('generators', 'postsPerPage'), 'page', 0);
            //var_dump($data);

            $pageTemplate = str_replace('%%header%%',
              file_get_contents(rootdirpath . 'template/' . $temp . '/' . 'header.txt'), $pageTemplate);
            $pageTemplate = str_replace('{{pageTitleElement}}', $pageTitle, $pageTemplate);
            $pageTemplate = str_replace('%%navigation%%', $this->NavigationGenerator($pageID, $temp), $pageTemplate);
            $pageTemplate = str_replace('%%footer%%',
              file_get_contents(rootdirpath . 'template/' . $temp . '/' . 'footer.txt'), $pageTemplate);
            $pageTemplate = str_replace('{{domainpath}}', domainpath, $pageTemplate);
            $pageTemplate = str_replace('{{siteName}}', $this->getSettingValue('core', 'siteName'), $pageTemplate);
            $pageTemplate = str_replace('{{siteDescription}}', $this->getSettingValue('core', 'siteDescription'),
              $pageTemplate);

            $pageTemplate = str_replace('%%subnavigation%%', $subnavpg, $pageTemplate);
            $pageTemplate = str_replace('{{design.headerContent}}', $this->getSettingValue('design', 'headerContent'),
              $pageTemplate);
            $pageTemplate = str_replace('{{design.footerContent}}', $this->getSettingValue('design', 'footerContent'),
              $pageTemplate);
            $pageTemplate = str_replace('{{design.logoLink}}', $this->getSettingValue('design', 'logoLink'),
              $pageTemplate);

            $postTemplate = substr($pageTemplate, strpos($pageTemplate, "[[post]]"),
              strpos($pageTemplate, "[[/post]]") - strpos($pageTemplate, "[[post]]"));
            $postTemplate = str_replace("[[post]]", "", $postTemplate);
            $replace = "";
            foreach ($data as $pages => $values) {
                $template = $postTemplate;
                $values['authorName'] = $this->getUserRealname($values['author']);

                foreach ($values as $item => $value) {
                    $key = '{{' . $item . '}}';
                    $template = str_replace($key, $value, $template);

                }
                $replace = $replace . $template;
            }


            $pageTemplate = str_replace("[[post]]" . $postTemplate . "[[/post]]", $replace, $pageTemplate);
            $pageTitle = $blogObjectData['title'] . ' - ' . $this->getSettingValue('core', 'siteName');


            echo $pageTemplate;
        }
    }

    function NavigationGenerator($pageID, $template)
    {
        $dbconn = $this->mysqliConnect();
        $sql = "SELECT * FROM nb_pages WHERE status = 0 AND showinnav = 1 AND parent = 0 ORDER BY id ASC";
        $res = $dbconn->query($sql) or die($dbconn->error . $this->throwError(0x010010));
        $navMap = [];
        $templatePath = rootdirpath . 'template/' . $template . '/' . 'navigation.txt';
        $template = file_get_contents($templatePath);
        $homepage = $this->getSettingValue('core', 'homepageSlug');
        $homepageName = $this->getPageAPI($homepage)['title'];

        $itemTemplate = $this->tagParser($template, '[[navitem]]', '[[/navitem]]');

        if (strpos($itemTemplate, '((if active true))') != false) {
            $activePageItem = str_replace("((if active true))", "", $itemTemplate);
            $activePageItem = str_replace("((endif))", "", $activePageItem);
            $pageItem = str_replace($this->tagParser($itemTemplate, "((if active true))", "((endif))"), "",
              $itemTemplate);
            $pageItem = str_replace("((if active true))", "", $pageItem);
            $pageItem = str_replace("((endif))", "", $pageItem);
        } else {
            $pageItem = $itemTemplate;
            $activePageItem = $pageItem;
        }
        //var_dump($template, $itemTemplate);
        while ($row = $res->fetch_assoc()) {
            $navMap[] = $row;
        }

        $navCont = '';
        if ($pageID == $homepage) {
            $navItem = str_replace("{{navitem url}}", domainpath, $activePageItem);
            $navItem = str_replace("{{navitem name}}", $homepageName, $navItem);
            $navCont .= $navItem;
        } else {
            $navItem = str_replace("{{navitem url}}", domainpath, $pageItem);
            $navItem = str_replace("{{navitem name}}", $homepageName, $navItem);
            $navCont .= $navItem;
        }
        foreach ($navMap as $row) {
            if ($row['slug'] != $homepage) {
                if ($row['slug'] == $pageID) {
                    $navItem = str_replace("{{navitem url}}", domainpath . "page/" . $row['slug'], $activePageItem);
                    $navItem = str_replace("{{navitem name}}", $row['title'], $navItem);
                    $navCont .= $navItem;
                } else {
                    $navItem = str_replace("{{navitem url}}", domainpath . "page/" . $row['slug'], $pageItem);
                    $navItem = str_replace("{{navitem name}}", $row['title'], $navItem);
                    $navCont .= $navItem;
                }
            }
        }
        $navTemp = str_replace($this->tagParser($template, "[[navitem]]", "[[/navitem]]"), $navCont, $template);
        $navTemp = str_replace("[[navitem]]", "", $navTemp);
        $navTemp = str_replace("[[/navitem]]", "", $navTemp);

        return $navTemp;
    }

    function tagParser($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }


    function SubnavigationGenerator($navigation, $template)
    {

        $templatePath = rootdirpath . 'template/' . $template . '/' . 'subnavigation.txt';
        $template = file_get_contents($templatePath);


        $itemTemplate = $this->tagParser($template, '[[navitem]]', '[[/navitem]]');


        $pageItem = $itemTemplate;
        $activePageItem = $pageItem;


        $navCont = '';


        foreach ($navigation as $row) {
            $navItem = str_replace("{{navitem url}}", domainpath . "page/" . $row['slug'], $activePageItem);
            $navItem = str_replace("{{navitem name}}", $row['title'], $navItem);
            $navCont .= $navItem;

        }
        $navTemp = str_replace($this->tagParser($template, "[[navitem]]", "[[/navitem]]"), $navCont, $template);
        $navTemp = str_replace("[[navitem]]", "", $navTemp);
        $navTemp = str_replace("[[/navitem]]", "", $navTemp);

        return $navTemp;
    }

    function generateSessionsTable($sessions)
    {
        $csrfToken = $this->getSessionCSRF($_COOKIE['ns_sid']);
        $n = count($sessions);
        foreach ($sessions as $session) {
            if ($session['useragent'] == 'FAILED_ATTEMPT_NIGHTSPARROW_LOGIN') {
                $n = $n - 1;
            }
        }
        echo '<h5>Active sessions (' . $n . ')</h5><a href="index.php?deleteAllSessions=self&csrfToken=' . $csrfToken . '" class="waves-effect waves-light btn">Terminate all</a>';
        echo '<table><tr><th>Browser</th><th>Time</th><th>Expires</th><th>IP</th><th>Cookie ID (first 8 chars.)</th><th>Actions</th></tr>';
        foreach ($sessions as $session) {
            if ($session['useragent'] == 'FAILED_ATTEMPT_NIGHTSPARROW_LOGIN') {
                continue;
            }
            $device = parse_user_agent($session['useragent']);
            echo '<tr><td>' . $device['browser'] . ' ' . $device['version'] . ' on ' . $device['platform'] . '</td><td> <script> moment.locale(\'en\');var relative = moment.unix('.$session['time'].').fromNow();document.write(relative);</script></td><td><script> moment.locale(\'en\');var relative = moment.unix('.$session['expires'].').fromNow();document.write(relative);</script></td><td>' . $session['ip'] . '</td><td>' . substr($session['cookieid'],
                0,
                8) . '<td><a href="?deleteSession=' . $session['id'] . '&csrfToken=' . $csrfToken . '">Terminate</a>';
        }
        echo '</table>';

    }
}

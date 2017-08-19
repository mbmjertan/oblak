<?php

class Analyze extends Nightsparrow
{

    function grabEverything()
    {
        $data = array();
        $data['requestTime'] = $_SERVER['REQUEST_TIME_FLOAT'];
        $data['time'] = microtime(true);
        $data['deliveryTime'] = $data['time'] - $data['requestTime'];
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['script'] = $_SERVER['SCRIPT_FILENAME'];
        $data['method'] = $_SERVER['REQUEST_METHOD'];
        $data['uri'] = $_SERVER['REQUEST_URI'];
        $data['ns_sid'] = $_COOKIE['ns_sid'];

        return $data;
    }

    function addVisit($data)
    {
        $dbconn = $this->mysqliConnect();
        $time = $dbconn->real_escape_string($data['time']);
        $ip = $dbconn->real_escape_string($data['ip']);
        $useragent = $dbconn->real_escape_string($data['userAgent']);
        $ns_sid = $dbconn->real_escape_string($data['ns_sid']);
        $deliveryTime = $dbconn->real_escape_string($data['deliveryTime']);
        $script = $dbconn->real_escape_string($data['script']);
        $method = $dbconn->real_escape_string($data['method']);
        $uri = $dbconn->real_escape_string($data['uri']);
        $addVisitQuery = "INSERT INTO nb_visits VALUES(null, '$time', '$ip', '$useragent', '$ns_sid', '$deliveryTime', '$script', '$method', '$uri')";
        $res = $dbconn->query($addVisitQuery);
        if ($res === false) {
            echo $dbconn->error;
            $this->throwError(0x010010);
        }
        $dbconn->close();
    }

    function analyzeVisits()
    {
        $dbconn = $this->mysqliConnect();
        $data = array();
        $numberOfVisitsEverQuery = "SELECT COUNT(*) AS count FROM nb_visits";
        $res = $dbconn->query($numberOfVisitsEverQuery) or die($this->throwError());
        $data['numberOfVisitsEver'] = $res->fetch_assoc()['count'];
        $lastMonth = time() - 30 * 24 * 60 * 60;
        $res = $dbconn->query("SELECT time, COUNT(*) AS count FROM nb_visits WHERE time > '$lastMonth' ORDER BY count DESC") or die($this->throwError());
        $data['lastMonthVisits'] = $res->fetch_assoc()['count'];
        $lastDay = time() - 24 * 60 * 60;
        $res = $dbconn->query("SELECT time, COUNT(*) AS count FROM nb_visits WHERE time > '$lastDay' ORDER BY count DESC") or die($this->throwError());
        $data['lastDayVisits'] = $res->fetch_assoc()['count'];
        $res = $dbconn->query("SELECT uri, COUNT(*) FROM nb_visits GROUP BY uri ORDER BY COUNT(*) DESC LIMIT 20");

        $uriMapMostVisitsEver = [];
        while ($row = $res->fetch_assoc()) {
            $uriMapMostVisitsEver[] = $row;
        }

        $res = $dbconn->query("SELECT uri, time, COUNT(*) FROM nb_visits WHERE time > '$lastDay' GROUP BY uri ORDER BY COUNT(*) DESC LIMIT 20");

        $uriMapMostVisitsDay = [];

        while ($row = $res->fetch_assoc()) {
            $uriMapMostVisitsDay[] = $row;
        }

        $data['uriMapMostVisitsEver'] = $uriMapMostVisitsEver;
        $data['uriMapMostVisitsDay'] = $uriMapMostVisitsDay;
        $dbconn->close();

        return $data;

    }

    function getDataExportDump($type)
    {
        $dbconn = $this->mysqliConnect();
        $res = $dbconn->query("SELECT * FROM nb_visits ORDER BY id DESC") or die($dbconn->error . $this->throwError(0x010010));
        $res->data_seek(0);
        if ($type == 'html') {
            echo '<table><th>ID</th><th>Vrijeme</th><th>IP</th><th>User Agent</th><th>Oznaka sesije (ako je korisnik prijavljen)</th><th>Vrijeme isporuke</th><th>Skripta</th><th>Metoda</th><th>URI</th>';
            while ($row = $res->fetch_row()) {

                echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[3] . '</td><td>' . $row[4] . '</td><td>' . $row[5] . '</td><td>' . $row[6] . '</td><td>' . $row[7] . '</td><td>' . $row[8] . '</td></tr>';

            }
            echo '</table>';
        } elseif ($type == 'csv') {
            $data = [];
            while ($row = $res->fetch_row()) {
                array_push($data, $row);
            }

            $now = gmdate("D, d M Y H:i:s");
            header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");

            // force download
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");

            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename=analytics_data_export.csv");
            header("Content-Transfer-Encoding: binary");
            $this->array2csv($data);

        } else {
            die('Ova vrsta izvoza analitičkih podataka nije podržana.');
        }
        $dbconn->close();
    }

    function array2csv($array)
    {

        $header = array("ID", "Time", "IP", "UserAgent", "ns_sid", "DeliveryTime", "Script", "Method", "URI");

        $fp = fopen("php://output", "w");
        fputcsv($fp, $header, "\t");
        foreach ($array as $row) {
            fputcsv($fp, $row, "\t");
        }
        fclose($fp);
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: mbm
 * Date: 17/01/16
 * Time: 20:19
 */
class APIHandler extends Nightsparrow
{

    public function APIEntryPoint($array)
    {
        if ($array[0] == 'page') {
            if (isset($array[1])) {
                $pageData = $this->getPageAPI($array[1]);
                if (($pageData['status'] == 0) || ($pageData['status'] == 3)) {
                    $this->generateJSON($pageData);
                } else {
                    $this->throwError('forbidden');
                }
            }
        }
        if ($array[0] == 'pages') {
            if ((isset($array[1])) && (isset($array[2])) && (isset($array[3]))) {
                if ($array[3] == 0) {
                    $this->generateJSON($this->getLatestPagesWithTypeAndStatusAPI($array[1], $array[2], $array[3]));
                } else {
                    $this->throwError('forbidden');
                }
            }
        }
        if ($array[0] == 'user') {
            if (isset($array[1])) {
                $this->generateJSON($this->getUserRealname($array[1]));
            }
        }
    }

    protected function generateJSON($data)
    {
        header('Content-Type: application/json');
        $r = json_encode($data, JSON_PRETTY_PRINT);
        echo $r;
    }

}
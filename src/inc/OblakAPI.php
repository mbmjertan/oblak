<?php

class OblakAPI extends OblakCore{
  function generateJSON($data) {
    header('Content-Type: application/json');
    $r = json_encode($data, JSON_PRETTY_PRINT);
    echo $r;
  }
}
<?php
if($routeSegments[1] == 'search'){
  if($routeSegments[2] == 'query'){
    if(empty($_POST['query'])){
      header('Location: '.domainpath.activeInstance.'/search');
      die();
    }
    else {
      $results = $oblak->kepler->KeplerParse(activeInstance, $_POST['query']);
    }
    include 'template/interface/kepler-results.php';

  }
  else{
    include 'template/interface/kepler-query.php';

  }
}

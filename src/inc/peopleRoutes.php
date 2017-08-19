<?php

if (stripos($routeSegments[1], "kontakti") !== false) {
  $groups = $oblak->people->getGroups(activeInstance);
  foreach($groups as $key=>&$group){
    $group['memberCount'] = $oblak->people->countGroupMembers(activeInstance, $group['id']);
    if($group['memberCount'] == 0){
      unset($groups[$key]);
    }
  }
  unset($group);
  if(!empty($routeSegments[2])){
    if($routeSegments[2] == 'novi'){
      $view = 'AddView';
      include 'template/interface/people.php';
    }
    if($routeSegments[2] == 'uredi'){
      $personID = $oblak->ioPrepare($routeSegments[3], 'number');
      $personData = $oblak->people->getPersonData(activeInstance, $routeSegments[3]);
      $personData[] = $oblak->people->getPersonStructure(activeInstance, $routeSegments[3]);
      $view = 'UpdateView';
      include 'template/interface/people.php';
    }
    if($routeSegments[2] == 'pregled'){
      $personID = $oblak->ioPrepare($routeSegments[3], 'number');
      $personData = $oblak->people->getPersonData(activeInstance, $routeSegments[3]);
      $personData[] = $oblak->people->getPersonStructure(activeInstance, $routeSegments[3]);
      $view = 'PersonView';
      include 'template/interface/people.php';
    }
    if($routeSegments[2] == 'grupa'){
      $groupID = $routeSegments[3];
      $members = $oblak->people->getGroupMembers(activeInstance, $groupID);
      $groupMD = $oblak->people->getGroupMetadata(activeInstance, $groupID);
      $groupMD['memberCount'] = $oblak->people->countGroupMembers(activeInstance, $groupID);
      $view = 'GroupView';
      include 'template/interface/people.php';
    }
    if($routeSegments[2] == 'obrisi'){
      $personID = $oblak->ioPrepare($routeSegments[3], 'number');
      $personData = $oblak->people->getPersonData(activeInstance, $routeSegments[3]);
      $personData[] = $oblak->people->getPersonStructure(activeInstance, $routeSegments[3]);
      $view = 'DeleteView';
      include 'template/interface/people.php';
    }
    if($routeSegments[2] == 'appAPI'){
      if($routeSegments[3] == csrfToken){
        if($routeSegments[4] == 'groupSuggestions'){
          $oblak->api->generateJSON($oblak->people->getGroups(activeInstance));
          die();
        }
      }
    }
  }
  else{
    if(isset($_POST['action'])){
      if($_POST['action'] == 'addPerson'){
        if($_POST['csrfToken'] == csrfToken){
          if($_POST['createAccount'] == 'on') {
            $oblak->people->addOrEditPerson(activeInstance, $personID = null, $_POST['firstName'], $_POST['lastName'], $_POST['groups'], $_POST['customType'], $_POST['customTypeValue'], $_POST['newFieldName'], $_POST['newFieldID'], $_POST['username'], $_POST['password']);
          }
          else {
            $oblak->people->addOrEditPerson(activeInstance, $personID = null, $_POST['firstName'], $_POST['lastName'], $_POST['groups'], $_POST['customType'], $_POST['customTypeValue'], $_POST['newFieldName'], $_POST['newFieldID']);
          }
        }
        else{
          $oblak->throwError();
          die();
        }
      }
      if($_POST['action'] == 'deletePerson'){
        if($_POST['csrfToken'] == csrfToken){
          $oblak->people->deletePerson(activeInstance, $_POST['deletePerson']);
          $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood</i> Izbrisano.</span></div>';
        }
        else{
          $oblak->throwError();
          die();
        }
      }
    }
    $peopleVar = $oblak->people->getPeopleIndex(activeInstance);
    $view = 'PeopleList';
    include 'template/interface/people.php';
  }
}
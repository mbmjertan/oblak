<?php

class OblakPeople extends OblakCore {

  function getPeopleIndex($instance,$after=0) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $itemsPerPage = 50;
    $after = preg_replace("/[^0-9]/", '', $after);
    if($after == 0) {
      $query = "SELECT * FROM {$instance}_people ORDER BY id DESC LIMIT {$itemsPerPage}";
    }
    else{
      $query = "SELECT * FROM {$instance}_people WHERE id<{$after} ORDER BY id DESC LIMIT {$itemsPerPage}";
    }
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_all(MYSQLI_ASSOC);
    foreach($resultSet as $key => &$row){
      if($key != 'metadata'){
        $row = str_replace("&", "&amp;", $row);
        $row = str_replace("<", "&lt;", $row);
        $row = str_replace(">", "&gt;", $row);
        $row = str_replace("\"", "&quot;", $row);
        $row = str_replace("'", "&#x27;", $row);
        $row = str_replace("/", "&#x2F;", $row);
      }
      $row['metadata'] = $this->getPersonData($instance, $row['id']);
    }

    return $resultSet;
  }

  function getPersonData($instance, $person){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $person = preg_replace("/[^0-9]/", '', $person);
    $query = "SELECT * FROM {$instance}_peopleMetadata WHERE personID={$person}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }

    $resultSet = $res->fetch_all(MYSQLI_ASSOC);
    foreach($resultSet as $key => &$row) {
      if ($key != 'metadata') {
        $row = str_replace("&", "&amp;", $row);
        $row = str_replace("<", "&lt;", $row);
        $row = str_replace(">", "&gt;", $row);
        $row = str_replace("\"", "&quot;", $row);
        $row = str_replace("'", "&#x27;", $row);
        $row = str_replace("/", "&#x2F;", $row);
      }
    }
    return $resultSet;
  }

  function checkGroupMembership($instance, $user, $group){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = preg_replace("/[^0-9]/", '', $user);
    $group = preg_replace("/[^0-9]/", '', $group);
    $query = "SELECT COUNT(*) AS GroupMembershipBoolean FROM {$instance}_peopleMetadata WHERE personID={$user} AND attributeName='groupMembership' AND attributeValue={$group}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_assoc();
    if($resultSet['GroupMembershipBoolean']){
      return true;
    }
    else{
      return false;
    }
  }

  function countGroupMembers($instance, $group){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $group = preg_replace("/[^0-9]/", '', $group);
    $query = "SELECT COUNT(*) AS GroupMembershipCount FROM {$instance}_peopleMetadata WHERE attributeName='groupMembership' AND attributeValue={$group}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_assoc();
    if($resultSet['GroupMembershipCount']){
      return $resultSet['GroupMembershipCount'];
    }
    else{
      return 0;
    }
  }

  function getGroupMembers($instance, $group){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $group = preg_replace("/[^0-9]/", '', $group);
    $query = "SELECT * FROM {$instance}_peopleMetadata WHERE attributeName='groupMembership' AND attributeValue={$group}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_all(MYSQLI_ASSOC);
    return $resultSet;
  }

  function getGroupMembershipsForPerson($instance, $user){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = preg_replace("/[^0-9]/", '', $user);
    $query = "SELECT * FROM {$instance}_peopleMetadata WHERE attributeName='groupMembership' AND personID={$user}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_all(MYSQLI_ASSOC);
    return $resultSet;
  }

  function getUserIDFromPersonID($instance, $person){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $person = preg_replace("/[^0-9]/", '', $person);
    $query = "SELECT * FROM {$instance}_users WHERE personID={$person}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_assoc();
    return $resultSet['personID'];
  }

  function getGroups($instance){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $query = "SELECT * FROM {$instance}_peopleGroups";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_all(MYSQLI_ASSOC);
    return $resultSet;
  }

  function getGroupMetadata($instance, $id){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $id = preg_replace ("/[^0-9]/", '', $id);
    $query = "SELECT * FROM {$instance}_peopleGroups WHERE id={$id}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_assoc();
    return $resultSet;
  }

  function getPersonStructure($instance, $person){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $person = preg_replace("/[^0-9]/", '', $person);
    $query = "SELECT * FROM {$instance}_people WHERE id={$person}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }

    $resultSet = $res->fetch_assoc();
    foreach($resultSet as $key => &$row) {
      if ($key != 'metadata') {
        $row = str_replace("&", "&amp;", $row);
        $row = str_replace("<", "&lt;", $row);
        $row = str_replace(">", "&gt;", $row);
        $row = str_replace("\"", "&quot;", $row);
        $row = str_replace("'", "&#x27;", $row);
        $row = str_replace("/", "&#x2F;", $row);
      }
    }
    return $resultSet;
  }

  function getMetametadata($instance, $metadataType){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $metadataType = $dbconn->real_escape_string($this->ioPrepare($metadataType, "nospecialchars"));
    $query = "SELECT * FROM {$instance}_peopleMetametadata WHERE attributeName='{$metadataType}'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }

    $resultSet = $res->fetch_assoc();
    return $resultSet;
  }

  function generateLink($type, $string){
    if($type == 'email'){
      $string = "<a href=\"mailto:{$string}\">{$string}</a>";
    }
    elseif($type == 'phone'){
      $string = "<a href=\"tel://{$string}\">{$string}</a>";
    }
    elseif($type == 'mobile'){
      $string = "<a href=\"tel://{$string}\">{$string}</a>";
    }
    return $string;
  }


  function getUserIDNumberFromPersonID($instance, $personID){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $personID = preg_replace ("/[^0-9]/", '', $personID);
    $query = "SELECT id,personID FROM {$instance}_users WHERE personID={$personID}";
    $res = $dbconn->query($query);
    if($res->num_rows){
      $dbd = $res->fetch_assoc();
      return $dbd['id'];
    }
    else{
      return -1;
    }
  }

  function getMetadataTypes($instance){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $personID = preg_replace ("/[^0-9]/", '', $personID);
    $query = "SELECT * FROM {$instance}_peopleMetametadata";
    $res = $dbconn->query($query);
    if($res->num_rows > 1){
      return $res->fetch_all(MYSQLI_ASSOC);
    }
    else{
      $rv[0] = $res->fetch_assoc();
      return $rv;
    }
  }

  function getPersonAttributeValue($instance, $personID, $attribute){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $attribute = $dbconn->real_escape_string($attribute);
    $personID = preg_replace ("/[^0-9]/", '', $personID);
    $query = "SELECT attributeValue FROM {$instance}_peopleMetadata WHERE personID={$personID} AND attributeName = '{$attribute}'";
    $res = $dbconn->query($query);
    if($res->num_rows){
      $dbd = $res->fetch_assoc();
      return $dbd['attributeValue'];
    }
    else{
      return -1;
    }
  }

  function changePersonAttributeValue($instance, $personID, $attribute, $value) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $attribute = $dbconn->real_escape_string($attribute);
    $value = $dbconn->real_escape_string($value);
    $personID = preg_replace("/[^0-9]/", '', $personID);
    $query = "UPDATE  {$instance}_peopleMetadata SET attributeValue='{$value}' WHERE personID={$personID} AND attributeName = '{$attribute}'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $dbconn->close();
  }

  function addCustomField($instance, $newFieldID, $newFieldName){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $newFieldName = $dbconn->real_escape_string($this->ioPrepare($newFieldName));
    $newFieldID = preg_replace ("/[^0-9A-Za-z]/", '', $this->ioPrepare($newFieldID));
    $sql = "INSERT INTO {$instance}_peopleMetametadata VALUES(null, '{$newFieldID}', 'varchar', 'user', '{$newFieldName}')";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $dbconn->close();

  }

  function onAddedUser($instance, $userID){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $userID = preg_replace ("/[^0-9]/", '', $userID);
    $sql = "INSERT INTO {$instance}_peopleMetadata VALUES (null, {$userID}, 'walkthroughsEnabled', 1), (null, {$userID}, 'filesWalkthroughEnabled', 1),(null, {$userID}, 'billsWalkthroughEnabled', 1),(null, {$userID}, 'newsWalkthroughEnabled', 1),(null, {$userID}, 'peopleWalkthroughEnabled', 1)";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $name = $this->getUserRealname($instance, $userID);
    $sql = "INSERT INTO " . $instance . "_files SET type='folder', mimetype=null, size=0, name='$name', parent=0";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $id = $dbconn->insert_id;
    $addShareQuery = "INSERT INTO {$instance}_fileShares SET fileID={$id}, fileShareType=4, userID={$userID}";
    $res = $dbconn->query($addShareQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $addShareQuery = "INSERT INTO {$instance}_fileShares SET fileID=1, fileShareType=4, userID={$userID}";
    $res = $dbconn->query($addShareQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $dbconn->close();
    $url = domainpath.$instance;
    $company = $this->getInstanceSetting($instance, 'businessName')['value'];
    $name = $this->getUserRealname($instance, $userID);
    $array = ["url" => $url, "company" => $company, "userName" => $name];
    $this->sendEmail($this->getEmailFromID($instance, $userID), 'Dobro došli u Poslovni oblak!', 'welcomeEmail.html', $array);
    return true;
  }

  function addOrEditPerson($instance, $personID=null, $firstName, $lastName, $groups, $customType, $customTypeValue, $newFieldName, $newFieldID, $username=null, $password=null){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $firstName = $dbconn->real_escape_string($firstName);
    $lastName = $dbconn->real_escape_string($lastName);
    $personID = preg_replace ("/[^0-9]/", '', $personID);
    $groups = $dbconn->real_escape_string($this->ioPrepare($groups));

    $groups = explode(", ", $groups);
    $addPersonQuery = "INSERT INTO {$instance}_people VALUES(null, '{$firstName}', '{$lastName}', '{$firstName} {$lastName}')";
    $res = $dbconn->query($addPersonQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $personID = $dbconn->insert_id;
    if($groups[0]) {
      $this->addPersonToGroups($instance, $personID, $groups);
    }
    for($i=0;$i<count($customType);$i++){
      $customType[$i] = $dbconn->real_escape_string($this->ioPrepare($customType[$i]));
      $customTypeValue[$i] = $dbconn->real_escape_string($this->ioPrepare($customTypeValue[$i]));
      $newFieldName[$i] = $dbconn->real_escape_string($this->ioPrepare($newFieldName[$i]));
      $newFieldID[$i] = $dbconn->real_escape_string($this->ioPrepare($newFieldID[$i]));
      if($customType[$i] == 'newField'){
        $customType[$i] = $newFieldID[$i];
        $this->addCustomField($instance, $newFieldID[$i], $newFieldName[$i]);
      }
      $addAttributeQuery = "INSERT INTO {$instance}_peopleMetadata VALUES(null, '{$personID}', '{$customType[$i]}', '{$customTypeValue[$i]}')";
      $res = $dbconn->query($addAttributeQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail');
      }
    }

    if($username && $password){
      $emailKey = array_search('email', $customType);
      $email = $customTypeValue[$emailKey];
      $id = $this->addUserAPI($instance, $username, $email, $password, $personID);
      $this->onAddedUser($instance, $id);
    }

  }

  function deletePerson($instance, $userID){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $userID = preg_replace ("/[^0-9]/", '', $userID);
    $sql = "DELETE FROM {$instance}_people WHERE id = {$userID}";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $sql = "DELETE FROM {$instance}_peopleMetadata WHERE personID = {$userID}";
    $res = $dbconn->query($sql);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail');
    }
    $sql = "DELETE FROM {$instance}_peopleUsers WHERE personID = {$userID}";
    $res = $dbconn->query($sql);
    $dbconn->close();
  }
  function checkIfGroupsExistsByName($instance, $groupName){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $groupName = $dbconn->real_escape_string($groupName);
    $query = "SELECT COUNT(*) AS GroupExistenceBoolean FROM {$instance}_peopleGroups WHERE name = '{$groupName}'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_assoc();
    if($resultSet['GroupExistenceBoolean']){
      return true;
    }
    else{
      return false;
    }
  }
  function getGroupIDFromName($instance, $groupName){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $groupName = $dbconn->real_escape_string($groupName);
    $query = "SELECT * FROM {$instance}_peopleGroups WHERE name = '{$groupName}'";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_assoc();
    return $resultSet['id'];
  }
  function addGroup($instance, $groupName){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $groupName = $dbconn->real_escape_string($groupName);
    $query = "INSERT INTO {$instance}_peopleGroups VALUES (null, '{$groupName}', null)";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $id = $dbconn->insert_id;
    $dbconn->close();
    return $id;

  }
  function addPersonToGroups($instance, $personID, $groupParam){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $personID = preg_replace ("/[^0-9]/", '', $personID);
    if(!is_array($groupParam)){$groups[0] = $groupParam;}
    else{$groups=$groupParam;}

    foreach($groups as $group){
      $groupExists = $this->checkIfGroupsExistsByName($instance, $group);
      if($groupExists){
        $id = $this->getGroupIDFromName($instance, $group);
      }
      else{
        $id = $this->addGroup($instance, $group);
      }
      $sql = "INSERT INTO {$instance}_peopleMetadata VALUES (null, $personID, 'groupMembership', $id)";
      $res = $dbconn->query($sql);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail', $dbconn);
      }
    }
    $dbconn->close();
  }
}
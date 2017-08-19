<?php

class Kepler extends OblakCore {
  function KeplerParse($instance, $search) {
    if(!$search){$this->throwError();}
    $res = [];
    if (stripos($search, "searchIn:") !== false) {
      if (stripos($search, "searchIn:people") !== false) {
        $res['people'] = $this->searchPeople($instance, str_replace("searchIn:people ", "", $search));
      }
      elseif (stripos($search, "searchIn:files") !== false) {
        $res['files'] = $this->searchFiles($instance, str_replace("searchIn:files ", "", $search));
      }
      elseif (stripos($search, "searchIn:bills") !== false) {
        if (stripos($search, "type:Račun") !== false) {
          $res['bills'] = $this->searchBills($instance, str_replace(" type:Račun ", "", str_replace("searchIn:bills ", "", $search)));
        }
        elseif (stripos($search, "type:Ponuda") !== false) {
          $res['bills'] = $this->searchBills($instance, str_replace(" type:Ponuda ", "", str_replace("searchIn:bills ", "", $search)));
        }
        else {
          $res['bills'] = $this->searchBills($instance, str_replace("searchIn:bills ", "", $search));
        }

      }
      elseif (stripos($search, "searchIn:billItems") !== false) {
        $res['billItems'] = $this->searchBillItems($instance, str_replace("searchIn:billItems ", "", $search));
      }
      elseif (stripos($search, "searchIn:people") !== false) {
        $res['people'] = $this->searchPeople($instance, str_replace("searchIn:people ", "", $search));
      }
      elseif (stripos($search, "searchIn:peopleGroups") !== false) {
        $res['peopleGroups'] = $this->searchPeopleGroups($instance, str_replace("searchIn:peopleGroups ", "", $search));
      }
      elseif (stripos($search, "searchIn:peopleMetadata") !== false) {
        $res['peopleMetadata'] = $this->searchPeopleValues($instance, str_replace("searchIn:peopleMetadata ", "", $search));
      }
      elseif (stripos($search, "searchIn:news") !== false) {
        $res['posts'] = $this->searchPosts($instance, str_replace("searchIn:news ", "", $search));
      }
    }
    else {
      $res['people'] = $this->searchPeople($instance, $search);
      $res['files'] = $this->searchFiles($instance, $search);
      if (stripos($search, "type:Račun") !== false) {
        $res['bills'] = $this->searchBills($instance, str_replace("type:Račun", "", str_replace("searchIn:bills ", "", $search)), 'Račun');
      }
      elseif (stripos($search, "type:Ponuda") !== false) {
        $res['bills'] = $this->searchBills($instance, str_replace("type:Ponuda", "", str_replace("searchIn:bills ", "", $search)), 'Ponuda');
      }
      else {
        $res['bills'] = $this->searchBills($instance, str_replace("type:Ponuda", "", str_replace("searchIn:bills ", "", $search)));
      }
      $res['files'] = $this->searchFiles($instance, str_replace("searchIn:files", "", $search));
      $res['billItems'] = $this->searchBillItems($instance, str_replace("searchIn:billItems", "", $search));
      $res['peopleGroups'] =  $this->searchPeopleGroups($instance, str_replace("searchIn:peopleGroups", "", $search));
      $res['peopleMetadata'] = $this->searchPeopleValues($instance, str_replace("searchIn:peopleMetadata", "", $search));
      $res['posts'] = $this->searchPosts($instance, str_replace("searchIn:news", "", $search));

    }

    return $res;
  }

  function searchPeople($instance, $term) {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM {$instance}_people WHERE guessedSpelling LIKE '%{$term}%' ";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;
  }

  function searchFiles($instance, $term) {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM {$instance}_files WHERE name LIKE '%{$term}%' ";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;
  }

  function searchBills($instance, $term = '', $type = 'any') {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $type = $dbconn->real_escape_string($type);
    $instance = $dbconn->real_escape_string($instance);
    if ($type == 'any') {
      $sql = "SELECT * FROM {$instance}_bills WHERE buyerName LIKE '%{$term}%' OR buyerAddress LIKE '%{$term}%' OR buyerOIB = '{$term}' OR callNumber LIKE '%{$term}%' OR billFootnotes LIKE '%{$term}%' ";
    }
    else {
      $sql = "SELECT * FROM {$instance}_bills WHERE type = '{$type}' AND (buyerName LIKE '%{$term}%' OR buyerAddress LIKE '%{$term}%' OR buyerOIB = '{$term}' OR callNumber LIKE '%{$term}%' OR billFootnotes LIKE '%{$term}%') ";
      if (!$term) {
        $sql = "SELECT * FROM {$instance}_bills WHERE type = '{$type}' ";

      }
    }
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;

  }

  function searchBillItems($instance, $term) {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM {$instance}_billsItems WHERE itemDescription LIKE '%{$term}%' ";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;
  }

  function searchPeopleGroups($instance, $term) {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM {$instance}_peopleGroups WHERE name LIKE '%{$term}%' ";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;
  }

  function searchPeopleValues($instance, $term) {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM {$instance}_peopleMetadata WHERE attributeName != 'groupMembership' AND attributeName NOT LIKE '%walkthrough%' AND attributeValue LIKE '%{$term}%' ";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;
  }

  function searchPosts($instance, $term) {
    $dbconn = $this->mysqliConnect();
    $term = $dbconn->real_escape_string($term);
    $instance = $dbconn->real_escape_string($instance);
    $sql = "SELECT * FROM {$instance}_posts WHERE body LIKE '%{$term}%' ";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    $dbconn->close();

    return $ret;
  }
}
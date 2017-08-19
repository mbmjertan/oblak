<?php
class OblakNovosti extends OblakCore{
  function getNews($instance, $parent=0, $order=0){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $parent = $dbconn->real_escape_string($parent);
    if($order){
      $sql = "SELECT * FROM {$instance}_posts WHERE parent={$parent} ORDER BY id ASC";
    }
    else {
      $sql = "SELECT * FROM {$instance}_posts WHERE parent={$parent} ORDER BY id DESC";
    }
    $res = $dbconn->query($sql);
    $ret = $res->fetch_all(MYSQLI_ASSOC);
    if($parent == 0) {
      foreach ($ret as &$row) {
        $row['children'] = $this->getNews($instance, $row['id'], 1);
      }
    }
    $dbconn->close();
    return $ret;
  }
  function getPost($instance, $postID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $postID = preg_replace("/[^0-9]/", '', $postID);
    $sql = "SELECT * FROM {$instance}_posts WHERE id={$postID}";
    $res = $dbconn->query($sql);
    $ret = $res->fetch_array();
    $ret['children'] = $this->getNews($instance, $ret['id'], 1);

    $dbconn->close();

    return $ret;
  }

  function addPost($instance, $user, $body, $parent){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $user = preg_replace ("/[^0-9]/", '', $user);
    $parent = preg_replace ("/[^0-9]/", '', $parent);
    $body = $this->ioPrepare($body);
    $body = str_replace("&#x2F;", "/", $body);

    $body = preg_replace('/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', '<a href="\1">\1</a>', $body);
    $body = $dbconn->real_escape_string($body);

    $time = time();
    $sql = "INSERT INTO {$instance}_posts VALUES(null, $user, $time, '$body', $parent, 0)";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
  }
  function setLikes($instance, $post, $likes){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $post = preg_replace ("/[^0-9]/", '', $post);
    $likes = preg_replace ("/[^0-9]/", '', $likes);
    $sql = "UPDATE {$instance}_posts SET likes=$likes WHERE id=$post";
    $res = $dbconn->query($sql);
    if($res === false){
      $this->throwError();
    }
  }
}
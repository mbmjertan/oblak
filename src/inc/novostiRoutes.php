<?php
if(!$routeSegments[1]){
  echo '<div class="row">';
  if(isset($_POST['commentID'])){
    if($_POST['csrfToken'] == csrfToken){
      $oblak->novosti->addPost(activeInstance, userID, $_POST['body'], $_POST['commentID']);
    }
    else{
      $oblak->throwError();
    }
  }
  $cards = $oblak->novosti->getNews(activeInstance);
  //var_dump($cards);
  foreach($cards as $cardData){
    $cardData['author'] = $oblak->getUserRealname(activeInstance, $cardData['author']);
    include 'template/interface/novosti-card.php';

  }
  echo '</div>';

}
elseif($routeSegments[1] == 'post'){
  echo '<div class="row">';
  $cardData = $oblak->novosti->getPost(activeInstance, $routeSegments[2]);
  $cardData['author'] = $oblak->getUserRealname(activeInstance, $cardData['author']);
  include 'template/interface/homepage.php';
  include 'template/interface/novosti-card.php';
  echo '</div>';
  include 'template/interface/footer.php';
}
elseif($routeSegments[1] == 'like'){
  if(csrfToken == $routeSegments[3]){
    $postLikes = $oblak->novosti->getPost(activeInstance, $routeSegments[2])['likes']+1;
    $oblak->novosti->setLikes(activeInstance, $routeSegments[2], $postLikes);
    header('Location: '.domainpath.activeInstance.'/');
  }
}


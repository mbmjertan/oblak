

  <div class="col s12 m6">
    <div class="card">
      <div class="card-content">
        <div class="author blue-grey-text"><span class="material-icons left" style="font-size: 18px;">person</span><b><?php echo $cardData['author']; ?></b></div><br>
        <p><?php echo $cardData['body']; ?></p>
      </div>
      <div class="card-action">
        <a class="blue-text" href="<?php echo domainpath.activeInstance;?>/like/<?php echo $cardData['id']; ?>/<?php echo csrfToken; ?>"> Sviđa mi se (<?php echo $cardData['likes'];?>)</a>
        <a class="blue-text" href="<?php echo domainpath.activeInstance;?>/post/<?php echo $cardData['id']; ?>"> Trajna veza <?php if($cardData['time']){ ?>(<span class="time"><script>
              moment.locale('hr');
              document.write(moment.unix(<?php echo $cardData['time']; ?>).fromNow());
            </script></span>)<?php } ?></a>
      </div>
      <div class="card-comments blue-grey lighten-5" style="padding-left: 3%; border-left: 1px solid blue;padding-bottom:15px;">
        <?php foreach($cardData['children'] as $child){
        $child['author'] = $oblak->getUserRealname(activeInstance, $child['author']);
        ?>
        <div class="comment" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid gainsboro;">
          <div class="author blue-grey-text"><span class="material-icons left"
                                    style="font-size: 18px;">person</span><b><?php echo $child['author']; ?></b>
          </div><br>
          <div class="content"><?php echo $child['body']; ?></div>
          <hr>
          <div class="time"><script>
              moment.locale('hr');
              document.write(moment.unix(<?php echo $child['time']; ?>).fromNow());
            </script></div>
        </div>

          <?php
          }
          ?>

        <div class="comment-add">
            <form action="<?php echo domainpath.activeInstance;?>" method="post">
              <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
              <input type="hidden" name="commentID" value="<?php echo $cardData['id']; ?>">
              <div class="input-field"><label for="body">Komentirajte...</label><textarea class="materialize-textarea" name="body"></textarea></div>
              <button class="btn blue-grey">Dodaj komentar</button>
            </form>
      </div>
    </div>
  </div>
    </div>


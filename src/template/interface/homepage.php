<?php
$appTitle = 'Novosti';
$pageTitle = 'Novosti';
$activeApp = 'dashboard';
$activeAppURL = '';
$appColor = 'blue-grey darken-4';
include 'header.php';
?>
<div id="createPost" class="modal bottom-sheet createPost">
  <div class="modal-content">
    <h4>Novi post</h4>
    <form action="<?php echo domainpath.activeInstance;?>" method="post">
      <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
      <input type="hidden" name="commentID" value="0">
      <div class="input-field"><label for="commentBody">Što želite podijeliti?</label><textarea class="materialize-textarea" name="body"></textarea></div>
      <button class="btn blue-grey">Objavi</button>
    </form>
    <p>Vaš post i komentari će biti vidljivi svim članovima tvrtke. Možete koristiti linkove.</p>
  </div>
</div>

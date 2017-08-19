<?php
$appTitle = 'Datoteke';
$pageTitle = 'Datoteke';
$activeApp = 'datoteke';
$activeAppURL = 'datoteke';
$appColor = 'cyan darken-4';
if ($view == 'DownloadView') {
    include 'files-download.php';
    die();
} else {
    include 'header.php';
    if($view == 'ShareView'){
      include 'files-share.php';
      include 'footer.php';
      die();
     }
    if ($view == 'FolderView') {
        $priFold = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $folderData['id'], userID);
        if($priFold>10){
          $oblak->throwError('forbidden');
        }
        include 'files-folderview.php';
    }
    if ($view == 'DeleteView') {
        include 'files-delete.php';
    }

    if ($view == 'UpdateView') {
        include 'files-update.php';
    }

    ?>


    <div id="fileUpload" class="modal bottom-sheet fileUpload">
        <div class="modal-content">
            <h4>Prenesi datoteke</h4>
            <?php
            if ($priFold < 6) {
                include 'files-upload.php';
            } else {
                echo 'Ne možete dodavati datoteke u ovu mapu.';
            }
            ?>
        </div>
    </div>

    <div id="newFolder" class="modal bottom-sheet newFolder">
        <div class="modal-content">
            <h4>Nova mapa</h4>
            <?php
            if ($priFold < 6) {
                include 'files-newFolder.php';
            } else {
                echo 'Ne možete otvarati podmape u ovoj mapi.';
            }
            ?>
        </div>
    </div>


    <?php
    include 'footer.php';
}
?>

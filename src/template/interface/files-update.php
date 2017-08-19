
<div class="container topMargin">
Uređujete 
<?php 
$name = htmlspecialchars($fileData['name']);
$fileID = preg_replace ("/[^0-9]/", '', $fileID);
$parent = preg_replace ("/[^0-9]/", '', $fileData['parentID']);
if($fileData['type'] == 'folder'){
    echo "mapu <code>{$name}</code>.";
}
else{
    echo "datoteku <code>{$name}</code>.";
}
?>
<form action="<?php echo "/".activeInstance."/datoteke"; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="updateFile" value="<?php echo $fileID; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
    <label for="fileName">Ime <?php if($fileData['type']=='folder') {echo 'mape'; } else {echo 'datoteke'; } ?></label>
    <input type="text" name="fileName" value="<?php echo $name; ?>">
    <div class="input-field">
    <select name="parent">
      <?php $folders = explode("\n", $folders);
      unset($folders[0]);
      foreach($folders as $folder){
        $idParam = stripos($folder, "/");
        $id = substr($folder, $idParam+4);
        $idArg = "/ID:".$id;
        $name = str_replace($idArg, "", $folder);
        echo '<option value="'.$id.'"';
        if($id == $fileData['parentID']){
          echo ' selected';
        }
        echo '>'.$name.'</option>';
        echo "\n";
      }
      ?>
    </select>
      <label for="parent">Lokacija <small>mapa u kojoj se nalazi</small></label>

    </div>
    <?php if($fileData['type'] == 'file') { ?>
    <label for="files[]">Datoteka <small>(dodajte samo ako želite dodati novu verziju)</small></label>
    <div class="file-field input-field">
        <div class="btn cyan accent-4">
            <span>Odaberi</span>

            <input name="files[]" type="file">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Prijenos jedne datoteke">
        </div>
        </div>
<?php } ?>
    <input type="submit" value="Spremi promjene" class="btn btn-large cyan accent-4">
</form>
</div>
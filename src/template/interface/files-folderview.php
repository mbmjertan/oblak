<div class="container">
  <div class="currentFolderBreadcrumbs">
    <i class="material-icons left">folder</i>
    <?php
    echo '<a href="/' . activeInstance . '/datoteke">Korijenski direktorij</a>';
    if ($folderData['parent'] != '' && $folderData['parent'] != 'Korijenski direktorij') {
      echo ' / ... / ';
      echo '<a href="/' . activeInstance . '/datoteke/folder/' . $folderData['parentID'] . '">' . htmlspecialchars($folderData['parent']) . '</a>';
      echo ' / ';
      echo '<a href="/' . activeInstance . '/datoteke/folder/' . $folderData['id'] . '">' . htmlspecialchars($folderData['name']) . '</a>';
    }
    elseif ($folderData['parent'] == 'Korijenski direktorij') {
      echo ' / ';
      echo '<a href="/' . activeInstance . '/datoteke/folder/' . $folderData['id'] . '">' . htmlspecialchars($folderData['name']) . '</a>';

    }
    ?>
  </div>


  <div class="folderContents">

    <ul class="collection">


      <?php
      $c = 0;
      foreach ($folderData['contents'] as $item) {
        $priv = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $item['id'], userID);
        if ($priv > 10) {
          continue;
        }
        $c++;
        $size = $item['size'];
        $pt = 0;
        while ($size > 100) {
          $pt++;
          $size = $size / 1024;
        }
        if ($pt == 0) {
          $pt = 'B';
        }
        elseif ($pt == 1) {
          $pt = 'KB';
        }
        elseif ($pt == 2) {
          $pt = 'MB';
        }
        elseif ($pt == 3) {
          $pt = 'GB';
        }
        $sz = number_format($size, 2, ',', ' ') . ' ' . $pt;
        if ($item['type'] == 'folder') {
          $sz = 'mapa';
          $icon = 'folder';
          $color = 'grey';
          $action = 'folder_open';
        }
        else {
          $icon = 'insert_drive_file';
          $color = 'blue-grey';
          $action = 'file_download';
        }

        $peopleIcon = "people_outline";

        echo ' <li class="collection-item avatar"><i class="material-icons circle ' . $color . '">' . $icon . '</i>
	<a href="/' . activeInstance . '/datoteke/' . $item['type'] . '/' . $item['id'] . '"><span class="title">
' . htmlspecialchars($item['name']) . '</span></a><p>' . $sz . '<br>';
        echo '<span class="secondary-content hide-on-small-and-down">';
        echo '<a href="/' . activeInstance . '/datoteke/' . $item['type'] . '/' . $item['id'] . '" title="Otvori"><i class="material-icons left">' . $action . '</i></a>';
        if ($priv < 2  && $item['type'] != 'folder') {
          echo '<a href="/' . activeInstance . '/datoteke/sharing/' . $item['id'] . '" title="Dijeljenje"><i class="material-icons left">'.$peopleIcon.'</i></a>';
        }
        if ($priv < 4) {
          echo '<a href="/' . activeInstance . '/datoteke/edit/' . $item['id'] . '" title="Uredi"><i class="material-icons left">edit</i></a>';
        }
        if ($priv < 4) {
          echo '<a href="/' . activeInstance . '/datoteke/delete/' . $item['id'] . '" title="Obriši"><i class="material-icons left">delete</i></a>';
        }
        echo '</span>';

        echo '<span class="mobilefoldermenu-content hide-on-med-and-up">';
        echo '<a href="/' . activeInstance . '/datoteke/' . $item['type'] . '/' . $item['id'] . '"><i class="material-icons left">' . $action . '</i></a>';
        if ($priv < 2 && $item['type'] != 'folder') {
          echo '<a href="/' . activeInstance . '/datoteke/sharing/' . $item['id'] . '"><i class="material-icons left">people_outline</i></a>';
        }
        if ($priv < 4) {
          echo '<a href="/' . activeInstance . '/datoteke/edit/' . $item['id'] . '"><i class="material-icons left">edit</i></a>';
        }
        if ($priv < 4) {
          echo '<a href="/' . activeInstance . '/datoteke/delete/' . $item['id'] . '"><i class="material-icons left">delete</i></a>';
        }
        echo '</span>';

      }
      if ($c == 0) {
        echo 'Mapa je prazna.';
      }
      ?>
    </ul>
  </div>
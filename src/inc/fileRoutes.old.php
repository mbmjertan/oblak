<?php /**
 * Created by PhpStorm.
 * User: mbm
 * Date: 02/08/16
 * Time: 02:20
 */
<?php
if (isset($_POST['deleteFile'])) {
    $priv = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $fileID, userID);
    if ($priv < 4) {
        $oblak->throwError('forbidden');
    }
    if ($_POST['csrfToken'] == csrfToken) {
        $oblak->deleteFile(activeInstance, $_POST['deleteFile']);
    } else {
        header('Location: ' . domainpath . activeInstance . '/login');
        die();
    }
}
 if (stripos($routeSegments[1], "datoteke") !== false) {
     if (isset($routeSegments[2])) {
         if ($routeSegments[2] == 'delete') {
             $fileID = $routeSegments[3];

             $fileData = $oblak->getFileData(activeInstance, $fileID);
             $view = 'DeleteView';
         } elseif ($routeSegments[2] == 'edit') {
             $fileID = $routeSegments[3];
             $priv = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $fileID, userID);
             if ($priv > 4) {
                 $oblak->throwError('forbidden');
             }
             $fileData = $oblak->getFileData(activeInstance, $fileID);
             $view = 'UpdateView';
         } elseif ($routeSegments[2] == 'file') {
             $fileID = $routeSegments[3];
             $priv = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $fileID, userID);
             if ($priv == 11) {
                 $oblak->throwError('forbidden');
             }
             $fileData = $oblak->getFileData(activeInstance, $fileID);
             $fileData['preview'] == false;
             $view = 'DownloadView';
         } elseif ($routeSegments[2] == 'folder') {
             $folderID = $routeSegments[3];
             $fileID = '!NOTSET';
             $priv = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $folderID, userID);
             if ($priv == 11) {
                 $oblak->throwError('forbidden');
             }

             if (isset($_POST)) {
                 if (isset($_POST['action'])) {
                     if ($_POST['action'] == 'uploadNewFiles') {
                         if ($_POST['csrfToken'] == csrfToken) {
                             //var_dump($_FILES);
                             $fileData = $oblak->uploadFile(activeInstance, $_FILES);
                             //var_dump($fileData);
                             if ($fileData !== null) {
                                 $oblak->addFile(activeInstance, $fileData, userID, sessionID, $folderID);
                             }
                         } else {
                             header('Location: ' . domainpath . activeInstance . '/login');
                             die();
                         }
                     } elseif ($_POST['action'] == 'newFolder') {
                         if ($_POST['csrfToken'] == csrfToken) {
                             $fileData[0]['name'] = $_POST['folderName'];
                             $fileData[0]['parent'] = $folderID;
                             $fileData[0]['type'] = 'folder';
                             $fileData[0]['size'] = 0;


                             if ($fileData !== null) {
                                 $oblak->addFile(activeInstance, $fileData, userID, sessionID, $folderID);
                             }
                         } else {
                             header('Location: ' . domainpath . activeInstance . '/login');
                             die();
                         }
                     } elseif (isset($_POST['updateFile'])) {
                         if ($_POST['csrfToken'] == csrfToken) {

                             $oblak->updateFile(activeInstance, $_POST['updateFile'], $_FILES, userID, sessionID,
                               $_POST['fileName'], $_POST['parent']);
                             $parent = preg_replace("/[^0-9]/", '', $_POST['parent']);
                             $path = domainpath . activeInstance . "/datoteke/folder/" . $parent;
                             header('Location: {$path}');
                         } else {
                             header('Location: ' . domainpath . activeInstance . '/login');
                             die();
                         }
                     }
                 }
             }
         } else {
             $folderID = $routeSegments[3];
             $priv = $oblak->checkUserPrivilegeLevelFiles(activeInstance, $folderID, userID);
             if ($priv == 11) {
                 $oblak->throwError('forbidden');
             }
         }
     } else {
         $folderID = 'root';
         $fileID = '!NOTSET';

     }
     if ($fileID == '!NOTSET') {
         if ($folderID == 'root') {
             $folderID = 0;
         }
         $folderData = $oblak->getFolderData(activeInstance, $folderID);
         $view = 'FolderView';
     }
     if (isset($view)) {
         $view = $view;
     } else {
         $fileData = $oblak->getFileData(activeInstance, $fileID);
         $view = 'FileView';
     }
     include 'template/interface/files.php';

 }
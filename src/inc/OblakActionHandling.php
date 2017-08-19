<?php

class OblakActionHandling extends OblakCore {
  function generateBackup($instance) {
    $json = [];
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $tables = ['bills', 'billsItems', 'files', 'fileShares', 'filesOldRevisions', 'logs', 'notifications', 'people', 'peopleCategories', 'peopleGroups', 'peopleGroupSettings', 'peopleGroupsRights', 'peopleMetadata', 'peopleMetametadata', 'peoplePersonSettings', 'sessions', 'siteSettings', 'users'];
    foreach ($tables as $table) {
      $query = "SELECT * FROM {$instance}_{$table}";
      $res = $dbconn->query($query);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail', $dbconn);
      }
      $resultSet = $res->fetch_all(MYSQLI_ASSOC);
      $resultSet = $resultSet;
      $json[] = json_encode($resultSet, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    $json = serialize($json);
    $json = str_replace(addcslashes(rootdirpath, '/'), "serverRDP", $json);
    file_put_contents(rootdirpath . '/../OblakUploads/' . $instance . '/databaseExport', $json);
    $instance = preg_replace("/[^A-Za-z0-9-_]/", '', $instance);
    $cmd = 'cd ' . rootdirpath . '/../OblakUploads/' . $instance . ';';
    $cmd .= 'zip backup.zip' . ' *';
    shell_exec($cmd);
    $bp = rootdirpath . '/../OblakUploads/' . $instance . '/backup.zip';

    return $bp;

  }
}

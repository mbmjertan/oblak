<?php
$appTitle = 'Pretraživanje';
$pageTitle = 'Rezultati pretraživanja';
$activeApp = 'search';
$activeAppURL = '';
$appColor = 'blue-grey darken-4';
include 'header.php';
?>
  <div class="container">


    <form action="<?php echo domainpath.activeInstance; ?>/search/query" method="post">
      <div class="input-field">
        <label for="query">Pretražite Poslovni oblak...</label>
        <input type="text" name="query" value="<?php echo $_POST['query']; ?>">
      </div>
      <button class="btn blue-grey darken-4">Pretraži</button>
    </form>
  <br><br>

<?php
if($results['people']){
  echo '<div class="resultset"><b>Kontakti u aplikaciji Kontakti</b><hr>';
  foreach($results['people'] as $person){
    echo '<a href="'.domainpath.activeInstance.'/kontakti/pregled/'.$person['id'].'">'.$person['guessedSpelling'].'</a><br>';
  }
  echo '</div>';
}
if($results['files']){
  echo '<div class="resultset"><b>Datoteke i mape u aplikaciji Datoteke</b><hr>';
  foreach($results['files'] as $file){
    echo '<a href="'.domainpath.activeInstance.'/datoteke/'.$file['type'].'/'.$file['id'].'">'.$file['name'].'</a><br>';
  }
  echo '</div>';
}
if($results['bills']) {
  echo '<div class="resultset"><b>Računi i ponude u aplikaciji Računi</b><hr>';
  foreach ($results['bills'] as $bill) {
    if ($bill['type'] == 'Račun') {
      echo '<a href="' . domainpath . activeInstance . '/racuni/edit/' . $bill['id'] . '">' . $bill['type'] . ' ' . $bill['billNumber'] . '/' . $bill['businessAreaNumber'] . '/' . $bill['deviceNumber'] . '</a><br>';
    }
    else {
      echo '<a href="' . domainpath . activeInstance . '/racuni/edit/' . $bill['id'] . '">' . $bill['type'] . ' ' . $bill['billNumber'] . '</a><br>';
    }
  }
}
  if($results['billItems']){
    echo '<div class="resultset"><b>Stavke računa i ponuda u aplikaciji Računi</b><hr>';
    foreach($results['billItems'] as $billItem){
      echo '<a href="' . domainpath . activeInstance . '/racuni/edit/' . $billItem['billID'] . '">' . $billItem['itemDescription'] . '</a> (kao stavka na računu/ponudi) <br>';
    }
  }
  if($results['peopleGroups']){
    echo '<div class="resultset"><b>Grupe kontakata u aplikaciji Kontakti</b><hr>';
    foreach($results['peopleGroups'] as $group){
      echo '<a href="' . domainpath . activeInstance . '/kontakti/grupa/' . $group['id'] . '">' . $group['name'] . '</a> <br>';
    }
  }
  if($results['peopleMetadata']){
    echo '<div class="resultset"><b>Sadržaj kontakata u Kontakti</b><hr>';
    foreach($results['peopleMetadata'] as $metadata){
      $metadata['HRN'] = $oblak->people->getMetametadata(activeInstance, $metadata['attributeName'])['attributeHumanReadableName'];
      $metadata['person'] = $oblak->people->getPersonStructure(activeInstance, $metadata['personID'])['guessedSpelling'];

      echo '<a href="' . domainpath . activeInstance . '/kontakti/pregled/' . $metadata['personID'] . '">' . $metadata['attributeValue'] . ' (kao sadržaj polja <i>'.$metadata['HRN'].'</i> za kontakt <i>'.$metadata['person'].'</i>)</a><br>';
    }
  }
  if($results['posts']){
    echo '<div class="resultset"><b>Komentari i postovi u aplikaciji Novosti</b><hr>';
    foreach($results['posts'] as $post){
      if($post['parent']){
        echo '<i>'.$_POST['query'].'</i> se spominje u <a href="'.domainpath.activeInstance.'/post/'.$post['parent'].'">komentarima ovog posta</a> <br>';
      }
      else{
        echo '<a href="' . domainpath . activeInstance . '/post/' . $post['id'] . '">Upit se spominje u ovom postu: <br>' . $post['body'] . '</a> <br>';
      }
    }
  }
  echo '</div>';

echo '</div>';
include 'footer.php';
?>
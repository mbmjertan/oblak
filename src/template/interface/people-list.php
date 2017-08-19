<?php
$activeInstance = activeInstance;
$domainpath = domainpath;
?>
<div class="container">
  <div class="row">
    <div class="col s12 m4 l3">
      <ul class="collection">
      <?php
      foreach($groups as $group){
        echo "<li class='collection-item'><a href='kontakti/grupa/{$group['id']}'>{$group['name']} <span class='badge'>{$group['memberCount']}</span></a></li>";
      }
      ?>
      </ul>
    </div>
    <div class="col s12 m8 l9">
  <ul class="collection">
    <?php

    foreach($peopleVar as $person) {
      $spelling = $person['guessedSpelling'];
      $id = $person['id'];
      $metadataSnip = '';
      $mdc = 0;
      $metadataLength = count($person['metadata']);
      foreach($person['metadata'] as $data) {
        $r = 0;
        if ($mdc > 3) {
          break;
        }
        if ($data['attributeName'] == 'email') {
          $metadataSnip .= 'Email: ' . $data['attributeValue'] . ' ';
          $r = 1;
        }
        elseif ($data['attributeName'] == 'mobile') {
          $metadataSnip .= 'Mobitel: ' . $data['attributeValue'] . ' ';
          $r = 1;
        }
        elseif ($data['attributeName'] == 'phone') {
          $metadataSnip .= 'Telefon: ' . $data['attributeValue'] . ' ';
          $r = 1;
        }
        elseif ($data['attributeName'] == 'address') {
          $metadataSnip .= 'Adresa: ' . $data['attributeValue'] . ' ';
          $r = 1;
        }
        if ($mdc != 3 && $mdc != $metadataLength && $r) {
          $metadataSnip .= '<br>';
        }
        $mdc++;
      }
      echo "<li class='collection-item avatar'><i class='material-icons circle grey'>person</i><a href='{$domainpath}{$activeInstance}/kontakti/pregled/{$id}'><span class='title'>{$spelling}</span></a><p>{$metadataSnip}</p></li>";
    }
    ?>
  </ul>
    </div>
  </div>
</div>
<?php
$activeInstance = activeInstance;
$domainpath = domainpath;
?>
<div class="container">
  <div class="row">
    <div class="col s12 m4 l3">
      <ul class="collection">
        <?php
        echo "<li class='collection-item'><a href='{$domainpath}{$activeInstance}/kontakti/grupa/{$groupID}'><b>{$groupMD['name']}</b> <span class='badge'>{$groupMD['memberCount']}</span></a></li>";
        foreach($groups as $group){
          if($group['id'] != $groupID) {
            echo "<li class='collection-item'><a href='{$domainpath}{$activeInstance}/kontakti/grupa/{$group['id']}'>{$group['name']} <span class='badge'>{$group['memberCount']}</span></a></li>";
          }
        }
        ?>
      </ul>
    </div>
    <div class="col s12 m8 l9">
      <ul class="collection">
        <?php
        if($groupMD['memberCount']) {
          if (is_array($members[0])) {
            foreach ($members as $aperson) {
              $person = $oblak->people->getPersonData($activeInstance, $aperson['personID']);
              $person[] = $oblak->people->getPersonStructure($activeInstance, $aperson['personID']);
              $spelling = end($person)['guessedSpelling'];
              $id = end($person)['id'];
              $metadataSnip = '';
              $mdc = 0;
              foreach ($person as $data) {
                if ($mdc > 3) {
                  break;
                }
                if ($data['attributeName'] == 'email') {
                  $metadataSnip .= 'Email: ' . $data['attributeValue'] . ' ';
                }
                elseif ($data['attributeName'] == 'mobile') {
                  $metadataSnip .= 'Mobitel: ' . $data['attributeValue'] . ' ';
                }
                elseif ($data['attributeName'] == 'phone') {
                  $metadataSnip .= 'Telefon: ' . $data['attributeValue'] . ' ';
                }
                elseif ($data['attributeName'] == 'address') {
                  $metadataSnip .= 'Adresa: ' . $data['attributeValue'] . ' ';
                }
                if ($mdc != 3 && $mdc != $metadataLength) {
                  $metadataSnip .= '<br>';
                }
                $mdc++;
              }
              echo "<li class='collection-item avatar'><i class='material-icons circle grey'>person</i><a href='{$domainpath}{$activeInstance}/kontakti/pregled/{$id}'><span class='title'>{$spelling}</span></a><p>{$metadataSnip}</p></li>";
            }
          }
          else {
            $person = $oblak->people->getPersonData($activeInstance, $members['personID']);
            $person[] = $oblak->people->getPersonStructure($activeInstance, $members['personID']);
            $spelling = end($person)['guessedSpelling'];
            $id = end($person)['id'];
            $metadataSnip = '';
            $mdc = 0;
            foreach ($person as $data) {
              if ($mdc > 3) {
                break;
              }
              if ($data['attributeName'] == 'email') {
                $metadataSnip .= 'Email: ' . $data['attributeValue'] . ' ';
              }
              elseif ($data['attributeName'] == 'mobile') {
                $metadataSnip .= 'Mobitel: ' . $data['attributeValue'] . ' ';
              }
              elseif ($data['attributeName'] == 'phone') {
                $metadataSnip .= 'Telefon: ' . $data['attributeValue'] . ' ';
              }
              elseif ($data['attributeName'] == 'address') {
                $metadataSnip .= 'Adresa: ' . $data['attributeValue'] . ' ';
              }
              if ($mdc != 3 && $mdc != $metadataLength) {
                $metadataSnip .= '<br>';
              }
              $mdc++;
            }
            echo "<li class='collection-item avatar'><i class='material-icons circle grey'>person</i><a href='{$domainpath}{$activeInstance}/kontakti/pregled/{$id}'><span class='title'>{$spelling}</span></a><p>{$metadataSnip}</p></li>";

          }
        }
        else{
          echo 'Grupa je prazna';
        }
        ?>
      </ul>
    </div>
  </div>
</div>
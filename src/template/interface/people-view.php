<div class="container">
  <h4 class="name"><?php echo end($personData)['guessedSpelling']; ?><a href="<?php echo domainpath.activeInstance;?>/kontakti/obrisi/<?php echo $personID; ?>"><span class="material-icons right">delete</span></a></h4>
  <hr>
  <?php foreach($personData as $info){
    if((array_keys($info)[1] != 'firstName') && ($info['attributeName'] != 'groupMembership')){
      $attributeHR = $oblak->people->getMetametadata(activeInstance, $info['attributeName'])['attributeHumanReadableName'];
      $info['attributeValue'] = $oblak->people->generateLink($info['attributeName'], $oblak->ioPrepare($info['attributeValue']));
      if($attributeHR) {
        echo "{$attributeHR}: {$info['attributeValue']}";
        echo '<br>';
      }
    }
  }
?>
  <?php

  if($oblak->people->getUserIDNumberFromPersonID(activeInstance, $personData[count($personData)-1]['id'])>0){
    echo "Kontakt ima aktivan korisnički račun unutar usluge Oblak";
  }
?>
<br>
  <?php
  $domainpath = domainpath;
  $activeInstance = activeInstance;
  $groupMemberships = $oblak->people->getGroupMembershipsForPerson(activeInstance, $personData[count($personData)-1]['id']);
  if(is_array($groupMemberships[0])){
    foreach($groupMemberships as $gm){
      $gmName = $oblak->people->getGroupMetadata(activeInstance, $gm['attributeValue'])['name'];
      $gmName = $oblak->ioPrepare($gmName);
      $gm['id'] = $oblak->ioPrepare($gm['id'], 'number');

      echo "Kontakt je član grupe <a href='{$domainpath}{$activeInstance}/kontakti/grupa/{$gm['attributeValue']}'>{$gmName}</a><br>";
    }
  }
  elseif($groupMemberships != null){
    $gmName = $oblak->people->getGroupMetadata(activeInstance, $groupMemberships['attributeValue'])['name'];
    $gmName = $oblak->ioPrepare($gmName);
    $gm['id'] = $oblak->ioPrepare($gm['id'], 'number');
    echo "Kontakt je član grupe <a href='{$domainpath}{$activeInstance}/kontakti/grupa/{$groupMemberships['attributeValue']}'>{$gmName}</a>";
  }

  ?>
</div>
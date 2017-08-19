<div class="container">
  <p>Brišete
  <?php
  $billType = $billData['type'];
  if($billType == "Ponuda"){
    $billType = "ponudu";
  }
  else{
    $billType = "račun";
  }
  if($billType == "račun"){
    $billIdentifier = "{$billData['billNumber']}/{$billData['businessAreaNumber']}/{$billData['deviceNumber']}";
  }
  else{
    $billIdentifier = "{$billData['billNumber']}";
  }
  echo "{$billType} {$billIdentifier}.";
  ?>
  <b>Ova radnja je nepovratna</b> i učinit će sadržaj zauvijek nedostupnim svim korisnicima.</p>
  <p>Ovisno o okolnostima ove radnje, brisanje izdanog računa može biti protuzakonito. Snosite potpunu pravnu odgovornost za posljedice ove radnje.</p>
  <form action="<?php echo "/".activeInstance."/racuni"; ?>" method="post">
    <input type="hidden" name="action" value="deleteBill">
    <input type="hidden" name="deleteBill" value="<?php echo $billData['id']; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">

    <input type="submit" value="Obriši" class="btn btn-large cyan accent-4">
  </form>
</div>
<?php
if (stripos($routeSegments[1], "racuni") !== false) {
  if (!empty($routeSegments[2])) {
    if($routeSegments[2] == 'dumpAllDataAndCheckTiming'){
      $bills = $racuni->getLatestBills(activeInstance);
      for($i=count($bills);$i>1;$i--){
        if((int)$bills[$i]['timestamp']<=(int)$bills[$i+1]['timestamp']){
          echo $bills[$i]['id'] . ' (i: '.$bills[$i]['timestamp'].' i-1: '.$bills[$i+1]['timestamp'].')<br><br>';
        }
      }
      die();
    }
    if (stripos($routeSegments[2],'novi') !== false) {
      $view = 'AddView';
      if(isset($_GET['copy'])){
        $bill = $racuni->getCompleteBill(activeInstance, $_GET['copy']);
      }
      include 'template/interface/racuni.php';
    }
    if ($routeSegments[2] == 'view') {
      //var_dump($racuni->getCompleteBill(activeInstance, $routeSegments[3]));
    }
    if ($routeSegments[2] == 'delete') {
      if($routeSegments[3] == 0){
        $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood_bad</i> <b>Ne ide to tako.</b> Ovaj primjer računa ne možete brisati, ali nestat će automatski kad dodate prvi pravi račun.</span></div>';
        $bills = $racuni->getLatestBills(activeInstance);
        $view = 'ListView';
      }
      else {
        $billData = $racuni->getCompleteBill(activeInstance, $routeSegments[3]);
        $view = 'DeleteView';
      }
      include 'template/interface/racuni.php';
    }
    if($routeSegments[2] == 'exportHTML'){
      if($routeSegments[3] == 0){
        $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood_bad</i> <b>Ne ide to tako.</b> Ne možete izvesti ovaj primjer računa budući da je on samo primjer, no slobodno dodajte novi račun.</span></div>';
        $bills = $racuni->getLatestBills(activeInstance);
        $view = 'ListView';
        include 'template/interface/racuni.php';

      }
      else {
        $billData = $racuni->getCompleteBill(activeInstance, $routeSegments[3]);
        $billData['operatorName'] = $oblak->getUserRealname(activeInstance, $billData['operatorID']);
        $billData['billProviderLogo'] = $oblak->getInstanceSetting(activeInstance, 'logoFileID')['value'];
        $view = 'exportHTML';
        include 'template/interface/racuni-exported.php';
      }
    }
    if($routeSegments[2] == 'edit'){
      if($routeSegments[3] == 0){
        $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood_bad</i> <b>Ne ide to tako.</b> Ovaj primjer računa ne možete uređivati, no slobodno dodajte novi račun. Ovaj će nestati automatski kad dodate prvi pravi račun.</span></div>';
        $bills = $racuni->getLatestBills(activeInstance);
        $view = 'ListView';
      }
      else {
        $bill = $racuni->getCompleteBill(activeInstance, $routeSegments[3]);
        $view = 'EditView';
      }
      include 'template/interface/racuni.php';
    }
    if($routeSegments[2] == 'setStatus') {
      if ($routeSegments[3] == 0) {
        $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood_bad</i> <b>Ne ide to tako.</b> Ne možete mijenjati status ovom primjeru, no slobodno dodajte novi račun.</span></div>';
        $bills = $racuni->getLatestBills(activeInstance);
        $view = 'ListView';
        include 'template/interface/racuni.php';
      }
      else {
        if ($routeSegments[5] !== csrfToken) {
          $oblak->throwError();
          die();
        }
        if ($routeSegments[4] == 'placeno') {
          $status = 'Plaćeno';
        }
        elseif ($routeSegments[4] == 'neplaceno') {
          $status = 'Neplaćeno';
        }
        elseif ($routeSegments[4] == 'stornirano') {
          $status = 'Stornirano';
        }
        if ($status !== 'Plaćeno' && $status !== 'Neplaćeno' && $status !== 'Stornirano') {
          $status = -1;
          $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood_bad</i> <b>Ne ide to tako.</b> Mijenjanje statusa računa u neki osim ponuđenih nije dozvoljeno, čak ni kad ručno uredite zahtjev.</span></div>';
          $bills = $racuni->getLatestBills(activeInstance);
          $view = 'ListView';
          include 'template/interface/racuni.php';
        }
        if ($status != -1) {
          $racuni->changeBillStatus(activeInstance, $routeSegments[3], $status);
          $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood</i> Status računa uređen.</span></div>';
          $bills = $racuni->getLatestBills(activeInstance);
          $view = 'ListView';
          include 'template/interface/racuni.php';
        }
      }
    }
  }
  else {
    if (isset($_POST)) {
      if (isset($_POST['action'])) {
        if ($_POST['action'] == 'addNewBill') {
          if ($_POST['csrfToken'] == csrfToken) {
            if ($_POST['type'] != "Račun" && $_POST['type'] != "Ponuda") {
              $oblak->throwError();
            }
            $billNumber = $_POST['billNumber'];
            if($_POST['type'] == 'Ponuda'){
              $billNumber = $_POST['billNumberPonuda'];
            }
            // function addOrEditBill($instance, $id = null, $type, $billNumber, $businessAreaNumber, $deviceNumber, $timestamp = null, $deliveryDate, $paymentDeadlineDate, $expirationDate, $buyerID, $buyerName, $buyerAddress, $buyerOIB, $status, $value, $paymentType, $notes, $operatorID, $callNumber, $IBAN, $billProviderName, $billProviderAddress, $billProviderWeb, $billProviderPhone, $billProviderEmail, $footnotes, $billStatus, $billStatusDate, $billLink, $logoFileRevisionID, $pdfExportFileID, $linkFileID, $buyerEmail, $buyerPhone, $billDiscountPercentage, $itemDescriptions, $itemUnits, $itemQuantities, $itemPrices, $itemDiscountPercentages) {
            $racuni->addOrEditBill(activeInstance, null, $_POST['type'], $billNumber, $_POST['businessAreaNumber'], $_POST['deviceNumber'], null, $_POST['deliveryDate_submit'], $_POST['paymentDeadlineDate_submit'], $_POST['expirationDate_submit'], null, $_POST['buyerName'], $_POST['buyerAddress'], $_POST['buyerOIB'], null, null, null, $_POST['notes'], userID, $_POST['callNumber'], $_POST['IBAN'], $oblak->getInstanceSetting(activeInstance, 'businessName')['value'], $oblak->getInstanceSetting(activeInstance, 'businessMainAddress')['value'], $_POST['billProviderWeb'], $_POST['billProviderPhone'], $_POST['billProviderMail'], $_POST['footnotes'], $_POST['status'], null, null, $oblak->getInstanceSetting(activeInstance, 'logoFileID')['value'], null, null, null, null, $_POST['billDiscountPercentage'], $_POST['itemDescription'], $_POST['itemUnit'], $_POST['itemQuantity'], $_POST['itemPrice'], $_POST['itemDiscountPercentage']);
          }
        }
        if ($_POST['action'] == 'deleteBill') {
          if ($_POST['csrfToken'] == csrfToken) {
            $racuni->deleteBill(activeInstance, $_POST['deleteBill']);
            $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood</i> Izbrisano.</span></div>';
          }
        }
        if($_POST['action'] == 'editBill') {
          if ($_POST['csrfToken'] == csrfToken) {
            $billStatus = $racuni->getCompleteBill(activeInstance, $_POST['editBill'])['billStatus'];
            if ($billStatus !== 'U izradi') {
              $alert = '<div class="card-panel"><span class="blue-text text-darken-2"><i class="material-icons left">mood_bad</i> <b>Spremanje izmjena nije moguće.</b> Izdane račune nije moguće mijenjati.</span></div>';
            }
            else {
              $racuni->addOrEditBill(activeInstance, $_POST['editBill'], $_POST['type'], $_POST['billNumber'], $_POST['businessAreaNumber'], $_POST['deviceNumber'], null, $_POST['deliveryDate_submit'], $_POST['paymentDeadlineDate_submit'], $_POST['expirationDate_submit'], null, $_POST['buyerName'], $_POST['buyerAddress'], $_POST['buyerOIB'], null, null, null, $_POST['notes'], userID, $_POST['callNumber'], $_POST['IBAN'], $oblak->getInstanceSetting(activeInstance, 'businessName')['value'], $oblak->getInstanceSetting(activeInstance, 'businessMainAddress')['value'], $_POST['billProviderWeb'], $_POST['billProviderPhone'], $_POST['billProviderMail'], $_POST['footnotes'], $_POST['status'], null, null, $oblak->getInstanceSetting(activeInstance, 'logoFileID')['value'], null, null, null, null, $_POST['billDiscountPercentage'], $_POST['itemDescription'], $_POST['itemUnit'], $_POST['itemQuantity'], $_POST['itemPrice'], $_POST['itemDiscountPercentage']);
            }
          }
        }
      }
    }
    $bills = $racuni->getLatestBills(activeInstance);
    $view = 'ListView';
    include 'template/interface/racuni.php';
  }
}
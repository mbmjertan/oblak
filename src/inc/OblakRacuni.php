<?php

/**
 * Class OblakRacuni
 * Pokreće aplikaciju Računi i ponude.
 *
 * @depends OblakCore
 */
class OblakRacuni extends OblakCore {
  function getLatestBills($instance) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $query = "SELECT * FROM {$instance}_bills ORDER BY id DESC";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $resultSet = $res->fetch_all(MYSQLI_ASSOC);
    foreach($resultSet as &$result){
      foreach($result as &$row){
        $row = str_replace("&", "&amp;", $row);
        $row = str_replace("<", "&lt;", $row);
        $row = str_replace(">", "&gt;", $row);
        $row = str_replace("\"", "&quot;", $row);
        $row = str_replace("'", "&#x27;", $row);
        $row = str_replace("/", "&#x2F;", $row);
      }
    }
    return $resultSet;
  }

  function getCompleteBill($instance, $billID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $billID = preg_replace("/[^0-9]/", '', $billID);
    $query = "SELECT * FROM {$instance}_bills WHERE id = {$billID}";
    $res = $dbconn->query($query);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $bill = $res->fetch_assoc();
    $billItemsQuery = "SELECT * FROM {$instance}_billsItems WHERE billID = {$billID} ORDER BY billOrderCoef";
    $res = $dbconn->query($billItemsQuery);
    if ($res === false) {
      $this->throwError('databaseError', 'queryFail', $dbconn);
    }
    $bill['items'] = $res->fetch_all(MYSQLI_ASSOC);
    foreach($bill['items'] as &$item){
      $item['itemPrice'] = sprintf("%.2f", $item['itemPrice']/100);
      $item['itemEquals'] = sprintf("%.2f", $item['itemEquals']/100);
      $item['itemDiscountAmount'] = sprintf("%.2f", $item['itemDiscountAmount']/100);
      foreach($item as &$row){
        $row = str_replace("&", "&amp;", $row);
        $row = str_replace("<", "&lt;", $row);
        $row = str_replace(">", "&gt;", $row);
        $row = str_replace("\"", "&quot;", $row);
        $row = str_replace("'", "&#x27;", $row);
        $row = str_replace("/", "&#x2F;", $row);
      }
    }

    foreach($bill as $key=>&$row){
      if($key !== 'items') {
        $row = str_replace("&", "&amp;", $row);
        $row = str_replace("<", "&lt;", $row);
        $row = str_replace(">", "&gt;", $row);
        $row = str_replace("\"", "&quot;", $row);
        $row = str_replace("'", "&#x27;", $row);
        $row = str_replace("/", "&#x2F;", $row);
      }
    }
    return $bill;
  }

  function addOrEditBill($instance, $id = null, $type, $billNumber, $businessAreaNumber, $deviceNumber, $timestamp = null, $deliveryDate, $paymentDeadlineDate, $expirationDate, $buyerID = 0, $buyerName, $buyerAddress, $buyerOIB, $status, $value, $paymentType, $notes, $operatorID, $callNumber, $IBAN, $billProviderName, $billProviderAddress, $billProviderWeb, $billProviderPhone, $billProviderEmail, $footnotes, $billStatus, $billStatusDate, $billLink, $logoFileRevisionID, $pdfExportFileID, $linkFileID, $buyerEmail, $buyerPhone, $billDiscountPercentage, $itemDescriptions, $itemUnits, $itemQuantities, $itemPrices, $itemDiscountPercentages) {
    $dbconn = $this->mysqliConnect();
    if ($timestamp == null) {
      $timestamp = time();
    }
    else {
      $timestamp = preg_replace("/[^0-9]/", '', $timestamp);
    }
    if(!$deliveryDate){
      $deliveryDate = '0000-00-00';
    }
    if(!$paymentDeadlineDate){
      $paymentDeadlineDate = '0000-00-00';
    }
    if(!$expirationDate){
      $expirationDate = '0000-00-00';
    }
    if(!$buyerID){
      $buyerID = 0;
    }
    $billSubtotal = 0;
    $items = [[]];
    foreach ($itemQuantities as $item => &$itemQuantity) {
      $itemTotal = $itemQuantity * $itemPrices[$item];
      $itemDiscountAmount = $itemTotal * ($itemDiscountPercentages[$item] / 100);
      $itemTotal = $itemTotal - $itemDiscountAmount;
      $billSubtotal = $billSubtotal + $itemTotal;
      $items[$item]['description'] = $dbconn->real_escape_string($itemDescriptions[$item]);
      $items[$item]['unit'] = $dbconn->real_escape_string($itemUnits[$item]);
      $itemQuantity = preg_replace("/[^0-9.,]/", '', $itemQuantity);
      $itemQuantity = round($itemQuantity, 4);
      $items[$item]['quantity'] = $dbconn->real_escape_string($itemQuantity);
      $itemPrices[$item] = preg_replace("/[^0-9.,]/", '', $itemPrices[$item]);
      $items[$item]['price'] = $dbconn->real_escape_string($itemPrices[$item]);
      $items[$item]['price'] = $items[$item]['price']*100;
      $itemDiscountPercentages[$item] = preg_replace("/[^0-9.,]/", '', $itemDiscountPercentages[$item]);
      $items[$item]['discountPercentage'] = $dbconn->real_escape_string($itemDiscountPercentages[$item]);
      $items[$item]['discountAmount'] = $dbconn->real_escape_string($itemDiscountAmount)*100;
      $itemTotal = number_format((float)$itemTotal, 2, '.', '');
      $items[$item]['equals'] = $dbconn->real_escape_string($itemTotal)*100;
    }
    $billDiscountPercentage = preg_replace("/[^0-9.,]/", '', $billDiscountPercentage);
    $billDiscountAmount = (float)$billDiscountPercentage / 100 * $billSubtotal;
    $billTotal = $billSubtotal - $billDiscountAmount;
    if ($billStatus == "Plaćeno" || $billStatus == "Neplaćeno" || $billStatus == "U izradi" || $billStatus == "Stornirano") {
      $billStatus = $dbconn->real_escape_string($billStatus);
    }
    else {
      $this->throwError();
    }
    if ($type == "Račun" || $type == "Ponuda") {
      $type = $dbconn->real_escape_string($type);
    }
    else {
      $this->throwError();
    }
    $billNumber = preg_replace("/[^0-9]/", '', $billNumber);
    $businessAreaNumber = preg_replace("/[^0-9]/", '', $businessAreaNumber);
    $deviceNumber = preg_replace("/[^0-9]/", '', $deviceNumber);
    $buyerName = $dbconn->real_escape_string($buyerName);
    $buyerAddress = $dbconn->real_escape_string($buyerAddress);
    $buyerOIB = preg_replace("/[^0-9]/", "", $buyerOIB);
    if ($buyerOIB > 11) {
      // potrebno se nositi s nevaljanim OIB-om
    }
    $paymentDeadlineDate = str_replace("/", "-", $paymentDeadlineDate);
    $paymentDeadlineDate = $dbconn->real_escape_string($paymentDeadlineDate);
    $deliveryDate = str_replace("/", "-", $deliveryDate);
    $deliveryDate = $dbconn->real_escape_string($deliveryDate);
    $expirationDate = str_replace("/", "-", $expirationDate);
    $expirationDate = $dbconn->real_escape_string($expirationDate);
    $notes = $dbconn->real_escape_string($notes);
    $billDiscountPercentage = preg_replace("/[^0-9.,]/", '', $billDiscountPercentage);
    $billDiscountAmount = preg_replace("/[^0-9.,]/", '', $billDiscountAmount);
    $callNumber = $dbconn->real_escape_string($callNumber);
    $footnotes = $dbconn->real_escape_string($footnotes);
    $paymentType = 'Transakcijski račun';
    $operatorID = preg_replace("/[^0-9]/", '', $operatorID);
    $value = $billTotal * 100;
    $IBAN = $dbconn->real_escape_string($IBAN);
    $status = $dbconn->real_escape_string($status);
    $buyerID = preg_replace("/[^0-9]/", '', $buyerID);
    $buyerName = $dbconn->real_escape_string($buyerName);
    $buyerAddress = $dbconn->real_escape_string($buyerAddress);
    $buyerOIB = preg_replace("/[^0-9]/", '', $buyerOIB);
    $billProviderName = $dbconn->real_escape_string($billProviderName);
    $billProviderAddress = $dbconn->real_escape_string($billProviderAddress);
    $billProviderOIB = preg_replace("/[^0-9]/", '', $billProviderOIB);
    $billProviderEmail = $dbconn->real_escape_string($billProviderEmail);
    $billProviderWeb = $dbconn->real_escape_string($billProviderWeb);
    $billProviderPhone = $dbconn->real_escape_string($billProviderPhone);
    $billStatusDate = date("Y-m-d");
    $billDiscountPercentage = floor($billDiscountPercentage * 100);
    $billDiscountAmount = floor($billDiscountAmount * 100);
    if ($id == null) {
      $addQuery = "INSERT INTO {$instance}_bills SET type='{$type}', billNumber='{$billNumber}', businessAreaNumber='{$businessAreaNumber}'
      , deviceNumber='{$deviceNumber}', timestamp='{$timestamp}', deliveryDate='{$deliveryDate}', paymentDeadlineDate='{$paymentDeadlineDate}',
      expirationDate='{$expirationDate}', buyerID='{$buyerID}', buyerName='{$buyerName}', buyerAddress='{$buyerAddress}',
      buyerOIB='{$buyerOIB}', status='Izdan', value='{$value}', paymentType='{$paymentType}', notes='{$notes}', operatorID='{$operatorID}',
       callNumber='{$callNumber}', IBAN='{$IBAN}', billProviderName='{$billProviderName}', billProviderOIB='{$billProviderOIB}', billProviderAddress='{$billProviderAddress}',
       billProviderWeb='{$billProviderWeb}', billProviderPhone='{$billProviderPhone}', billProviderMail='{$billProviderEmail}', billFootnotes='{$footnotes}', billStatus='{$billStatus}', billStatusDate='{$billStatusDate}',
       billDiscountPercentage='{$billDiscountPercentage}', billDiscountAmount='{$billDiscountAmount}'";

      $res = $dbconn->query($addQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail', $dbconn);
      }
      $billID = $dbconn->insert_id;
      foreach ($items as $item) {
        $addItemQuery = "INSERT INTO {$instance}_billsItems SET billID='{$billID}', itemDescription='{$item['description']}',
itemUnit='{$item['unit']}', itemQuantity='{$item['quantity']}', itemPrice='{$item['price']}', itemDiscountPercentage='{$item['discountPercentage']}', itemDiscountAmount='{$item['discountAmount']}', itemEquals='{$item['equals']}'";
        $dbconn->query($addItemQuery);
        if ($res === false) {
          $this->throwError('databaseError', 'queryFail', $dbconn);
        }
      }

      return true;
    }
    else {
      $billID = preg_replace("/[^0-9.,]/", '', $id);
      $updateQuery = "UPDATE {$instance}_bills SET type='{$type}', billNumber='{$billNumber}', businessAreaNumber='{$businessAreaNumber}'
      , deviceNumber='{$deviceNumber}', timestamp='{$timestamp}', deliveryDate='{$deliveryDate}', paymentDeadlineDate='{$paymentDeadlineDate}',
      expirationDate='{$expirationDate}', buyerID='{$buyerID}', buyerName='{$buyerName}', buyerAddress='{$buyerAddress}',
      buyerOIB='{$buyerOIB}', status='Izdan', value='{$value}', paymentType='{$paymentType}', notes='{$notes}', operatorID='{$operatorID}',
       callNumber='{$callNumber}', IBAN='{$IBAN}', billProviderName='{$billProviderName}', billProviderOIB='{$billProviderOIB}', billProviderAddress='{$billProviderAddress}',
       billProviderWeb='{$billProviderWeb}', billProviderPhone='{$billProviderPhone}', billProviderMail='{$billProviderEmail}', billFootnotes='{$footnotes}', billStatus='{$billStatus}', billStatusDate='{$billStatusDate}',
       billDiscountPercentage='{$billDiscountPercentage}', billDiscountAmount='{$billDiscountAmount}' WHERE id={$billID}";
      $res = $dbconn->query($updateQuery);
      if ($res === false) {
        $this->throwError('databaseError', 'queryFail', $dbconn);
      }
      $this->deleteBillItems($instance, $billID);
      foreach ($items as $item) {
        $addItemQuery = "INSERT INTO {$instance}_billsItems SET billID='{$billID}', itemDescription='{$item['description']}',
itemUnit='{$item['unit']}', itemQuantity='{$item['quantity']}', itemPrice='{$item['price']}', itemDiscountPercentage='{$item['discountPercentage']}', itemDiscountAmount='{$item['discountAmount']}', itemEquals='{$item['equals']}'";
        $dbconn->query($addItemQuery);
        if ($res === false) {
          $this->throwError('databaseError', 'queryFail', $dbconn);
        }
      }

      return true;
    }
  }

  function getFootnotes($instance) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $default = '';
    $getQuery = "SELECT billFootnotes FROM {$instance}_bills ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($getQuery);
    if ($res === false) {
      return $default;
    }
    else {
      $lastValue = $res->fetch_assoc()['billFootnotes'];
      if ($lastValue != $default) {
        return $lastValue;
      }
      else {
        return $default;
      }
    }
  }

  function guessCallNumber($instance, $type = 'racun') {
    // podržani parametri: GGGG, MM, DD, B (broj računa), P (broj poslovnog prostora), U (broj naplatnog uređaja)
    $callNumberTemplate = $this->getInstanceSetting($instance, 'businessCallNumberTemplate')['value'];
    if (stripos($callNumberTemplate, "GGGG") !== false) {
      $callNumberTemplate = str_replace("GGGG", date("Y"), $callNumberTemplate);
    }
    if (stripos($callNumberTemplate, "MM") !== false) {
      $callNumberTemplate = str_replace("MM", date("m"), $callNumberTemplate);
    }
    if (stripos($callNumberTemplate, "DD") !== false) {
      $callNumberTemplate = str_replace("DD", date("d"), $callNumberTemplate);
    }
    if (stripos($callNumberTemplate, "B") !== false) {
      $callNumberTemplate = str_replace("B", $this->guessBillNumber($instance, $type), $callNumberTemplate);
    }
    if (stripos($callNumberTemplate, "P") !== false) {
      $callNumberTemplate = str_replace("P", $this->guessBusinessAreaNumber($instance), $callNumberTemplate);
    }
    if (stripos($callNumberTemplate, "U") !== false) {
      $callNumberTemplate = str_replace("U", $this->guessDeviceNumber($instance), $callNumberTemplate);
    }

    return $callNumberTemplate;
  }

  function guessBillNumber($instance, $type = 'racun') {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $type = $dbconn->real_escape_string($type);
    $year = date("Y");
    if ($type == "racun") {
      $type = "Račun";
    }
    else {
      $type = "Ponuda";
    }
    $yearSetting = "startBillsFromNumber/{$type}/{$year}";
    $startWith = $this->getInstanceSetting($instance, $yearSetting)['value'];
    if ($type == "Ponuda") {
      $startWith = 1;
    }
    $getLastBillNumberQuery = "SELECT billNumber FROM {$instance}_bills WHERE type = '{$type}' ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($getLastBillNumberQuery);
    $billNumberAssoc = $res->fetch_assoc();
    if ($res === false) {
      return $startWith;
    }
    else {
      if ($billNumberAssoc['billNumber'] >= $startWith) {
        $billNumber = ($billNumberAssoc['billNumber']) + 1;

        return $billNumber;
      }
      else {
        return $startWith;
      }
    }
  }

  function guessBusinessAreaNumber($instance) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $type = $dbconn->real_escape_string($type);
    $year = date("Y");
    $yearSetting = "billDefaultBusinessAreaNumber/{$year}";
    $default = $this->getInstanceSetting($instance, $yearSetting)['value'];
    if ($default == 0) {
      $default = 1;
    }
    $getQuery = "SELECT businessAreaNumber FROM {$instance}_bills ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($getQuery);
    if ($res === false) {
      return $default;
    }
    else {
      $lastValue = $res->fetch_assoc()['businessAreaNumber'];
      if ($lastValue != $default) {
        return $lastValue;
      }
      else {
        return $default;
      }
    }
  }

  function guessDeviceNumber($instance) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $year = date("Y");
    $yearSetting = "billDefaultDeviceNumber/{$year}";
    $default = $this->getInstanceSetting($instance, $yearSetting)['value'];
    if ($default == 0) {
      $default = 1;
    }
    $getQuery = "SELECT deviceNumber FROM {$instance}_bills ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($getQuery);
    if ($res === false) {
      return $default;
    }
    else {
      $lastValue = $res->fetch_assoc()['deviceNumber'];
      if ($lastValue != $default) {
        return $lastValue;
      }
      else {
        return $default;
      }
    }
  }

  function deleteBill($instance, $billID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $billID = preg_replace("/[^0-9]/", '', $billID);
    $deleteBillQuery = "DELETE FROM {$instance}_bills WHERE id={$billID}";
    $res = $dbconn->query($deleteBillQuery);
    if ($res === false) {
      $this->throwError('db', 'queryFail', $dbconn);
    }
    else {
      $this->deleteBillItems($instance, $billID);

      return true;
    }
  }

  function deleteBillItems($instance, $billID) {
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $billID = preg_replace("/[^0-9]/", '', $billID);
    $deleteBillItemsQuery = "DELETE FROM {$instance}_billsItems WHERE billID={$billID}";
    $res = $dbconn->query($deleteBillItemsQuery);
    if ($res === false) {
      $this->throwError('db', 'queryFail', $dbconn);
    }
    else {
      return true;
    }
  }

  function changeBillStatus($instance, $billID, $status){
    $dbconn = $this->mysqliConnect();
    $instance = $dbconn->real_escape_string($instance);
    $billID = preg_replace("/[^0-9]/", '', $billID);
    if($status !== 'Plaćeno' && $status !== 'Neplaćeno' && $status !== 'Stornirano'){
      $this->throwError('invalidInput', 'userInput');
    }
    $status = $dbconn->real_escape_string($status);
    $changeBillStatusQuery = "UPDATE {$instance}_bills SET billStatus='{$status}' WHERE id={$billID}";
    $res = $dbconn->query($changeBillStatusQuery);
    if ($res === false) {
      $this->throwError('db', 'queryFail', $dbconn);
    }
    else {
      return true;
    }
  }
}
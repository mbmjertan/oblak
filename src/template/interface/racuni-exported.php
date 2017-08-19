<?php
if ($billData['type'] == 'Ponuda') {
  $billData['title'] = "{$billData['type']} {$billData['billNumber']}";
}
else {
  $billData['title'] = "{$billData['type']} {$billData['billNumber']}/{$billData['businessAreaNumber']}/{$billData['deviceNumber']}";
}
$activeInstance = activeInstance;
$domainpath = domainpath;
date_default_timezone_set('Europe/Zagreb');
setlocale("L_ALL", "hr_HR.UTF-8");
$issuedDate = date("j. n. Y. \u H:i:s", $billData['timestamp']);
if ($billData['deliveryDate'] !== '0000-00-00') {
  $deliveryDate = date("j. n. Y.", strtotime($billData['deliveryDate']));
}
if ($billData['paymentDeadlineDate'] !== '0000-00-00') {
  $paymentDeadlineDate = date("j. n. Y.", strtotime($billData['paymentDeadlineDate']));
}
if ($billData['expirationDate'] !== '0000-00-00') {
  $expirationDate = date("j. n. Y.", strtotime($billData['expirationDate']));
}

$out = "

<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf-8\">
    <style>
    html,body{
      font-family: 'Arial', sans-serif;
      font-size: 16px;
      line-height: 24px;
      margin: 0px;
    }
      .billTable {
        counter-reset: rowNumber;
        border-spacing: 35px 5px;";
if($oblak->getInstanceSetting(activeInstance, 'billTableLayout')['value'] == 'bigdescrip') {
  $out .= "   border-spacing:5px 5px !important; table-layout: fixed;";
}
$out .= "
      }

      .billTable tr:not(:first-child) {
        counter-increment: rowNumber;
      }

      .billTable tr td:first-child::before {
        content: counter(rowNumber);
      }

      .billBuyer{
       display: inline-block;
       width: 40%;
       padding-right: 5%;
       vertical-align: top;
      }
      .billDates{
        display: inline-block;
        width: 40%;
        padding-right: 5%;
        vertical-align: top;
      }
      .billPhone, .billEmail, .billWeb{
        display: inline-block;
        width: 32%;
      }
      .billProviderLogo, .billProviderInfo{
        display: inline-block;
        width: 45%;
        vertical-align: middle;
      }
      .billProviderLogo img{
        max-height: 100px !important;
      }
      .billFootnotes{
        color: #7F7C7A !important;
        text-shadow: 0 0 0 #7F7C7A !important;
        font-size: 12px;
      }
      hr{
       border: 0;
       height: 0;
       border-top: 1px solid rgba(0, 0, 0, 0.1);
       border-bottom: 1px solid rgba(255, 255, 255, 0.3);
      }
      .billExportContainer{
        margin: 28px;
      }
      .actionBar{
        background-color: #747F77;
        height: 48px;
        width: 98%;
        margin: 0px;
        padding: 12px;
      }
      .actionBarButton{
        background-color: #D1E5D6;
        color: #3A403B;
        border-radius: 3px;
        padding: 7px;
        font-size:16px;
        vertical-align: middle;
        margin-left: 20%;
      }
      .billInfo, .billContactInfo{
        margin-top: 10px;
      }
      .billFootnotes{
        margin-top: 20px;
      }
      @page {
        size: A4;
      }
      @media print {
        html, body {
          width: 210mm;
          height: 297mm;
        }
        .actionBar, .actionBarButton, a.actionBarButton, a.actionBarButton:link, a.actionBarButton:visited{
          display: none !important;
        }
        .billFootnotes{
          color: #7F7C7A !important;
          -webkit-print-color-adjust: exact !important;
          -moz-print-color-adjust: exact !important;
          -ms-print-color-adjust: exact !important;
          print-color-adjust: exact !important;
        }
      }
    </style>
  </head>
  <body>";
if(!isset($_GET['action'])){
  $out .= "<div class='actionBar' id='actionBarCont'>
      <a href='#' onclick='document.getElementById(\"actionBarCont\").style.display=\"none\";window.print()' class='actionBarButton'>Ispiši račun</a>  <a href='?action=save' class='actionBarButton'>Preuzmi račun</a>
    </div>";
}
else{
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  $filename = $billData['title'];
  $filename = str_replace(" ", "_", $filename);
  $filename = str_replace("č", "c", $filename);
  $filename = str_replace("/", "-", $filename);
  $filename = $filename.'.html';
  header('Content-Disposition: attachment; filename='.$filename);
  header('Content-Transfer-Encoding: chunked');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
}

    $out .= "<div class=\"billExportContainer oblakCoreBillExportStyling userCustomBillExportStyling\">
      <div class=\"billProvider\">
        <div class=\"billProviderLogo\">
          <img src=\"{$domainpath}{$activeInstance}/datoteke/file/{$billData['billProviderLogo']}\">
        </div>
       <div class=\"billProviderInfo\">
        <b>{$billData['billProviderName']}</b>
        <p>{$billData['billProviderAddress']}</p>";
 if($oblak->settingExists(activeInstance, 'billShowOIBInBillHeader')){
  if($oblak->getInstanceSetting(activeInstance, 'billShowOIBInBillHeader')['value'] == 1){
    $OIB = $oblak->getInstanceSetting(activeInstance, 'businessOIB')['value'];
    $out .= "<small>OIB: {$OIB}</small>";
  }
}
$out .= "
       </div>
      </div>
      <h1 class=\"billTitle\">{$billData['title']}</h1>
      <div class='billMetadataContainer'>
      <div class=\"billBuyer\">
        <b>Kupac</b>
        <p>{$billData['buyerName']}</p>
        <p>{$billData['buyerAddress']}</p>
        <small>(OIB: {$billData['buyerOIB']})</small>
      </div>
      <div class=\"billDates\">
      <b>Informacije</b>
        <p class=\"billIssuedDate\">Datum izdavanja: {$issuedDate}</p>";
if (isset($deliveryDate)) {
  $out .= "<p class=\"billDeliveryDate\">Datum isporuke: {$deliveryDate}</p>";
}
if (isset($paymentDeadlineDate)) {
  $out .= "<p class=\"billPaymentDeadlineDate\">Rok plaćanja: {$paymentDeadlineDate}</p>";
}
if (isset($expirationDate)) {
  $out .= "<p class=\"billExpirationDate\">Datum isteka: {$expirationDate}</p>";
}
$out .= "</div>
      </div><div class=\"items\"><table class=\"billTable\">";
if($oblak->getInstanceSetting(activeInstance, 'billTableLayout')['value'] == 'bigdescrip') {
  $out .= "<tr><th>R.br.</th><th width='95%' style='width:95% !important;'>Opis proizvoda/usluge</th><th>Jed.</th><th>Kol.</th><th>Cijena</th><th>Popust (%)</th><th>Iznos stavke</th></tr>";
}
else {
  $out .= "<tr><th>R.br.</th><th>Opis proizvoda/usluge</th><th>Jed.</th><th>Kol.</th><th>Cijena</th><th>Popust (%)</th><th>Popust (kn)</th><th>Iznos stavke</th></tr>";
}
foreach ($billData['items'] as $item) {
  $item['itemPrice'] = number_format($item['itemPrice'], 2, ",", ".");
  $item['itemDiscountAmount'] = number_format($item['itemDiscountAmount'], 2, ",", ".");
  $item['itemEquals'] = number_format($item['itemEquals'], 2, ",", ".");
  $item['itemQuantity'] = round($item['itemQuantity'], 3);
  if($oblak->getInstanceSetting(activeInstance, 'billTableLayout')['value'] == 'bigdescrip') {
    $out .= "<tr><td>.</td><td>{$item['itemDescription']}</td><td>{$item['itemUnit']}</td><td>{$item['itemQuantity']}</td><td>{$item['itemPrice']}</td><td>{$item['itemDiscountPercentage']}</td><td>{$item['itemEquals']}</td></tr>";
  }
  else{
    $out .= "<tr><td>.</td><td>{$item['itemDescription']}</td><td>{$item['itemUnit']}</td><td>{$item['itemQuantity']}</td><td>{$item['itemPrice']}</td><td>{$item['itemDiscountPercentage']}</td><td>{$item['itemDiscountAmount']}</td><td>{$item['itemEquals']}</td></tr>";
  }
}
$out .= "
      </table></div>
      <hr><div class='billAmounts'>";
if ($billData['billDiscountPercentage']) {
  $BDP = $billData['billDiscountPercentage'] / 100;
  $BDA = $billData['billDiscountAmount'] / 100;
  $BDA = number_format($BDA, 2, ",", ".");
  $out .= "<p>Popust po računu: {$BDP}% odnosno {$BDA} kuna</p>";
}
$BV = $billData['value'] / 100;
$BV = number_format($BV, 2, ",", ".");

$out .= "<b>Ukupno za platiti: {$BV} kuna</b>
      </div>
      <div class='billInfo'>
        <p><b>Način plaćanja: </b> {$billData['paymentType']}</p>
        <p><b>Operater/dokument izdao:</b> {$billData['operatorName']}</p>
        <p><b>Napomene:</b> {$billData['notes']}</p>
        <p><b>Podaci za uplatu</b></p>
        <p><b>IBAN:</b> {$billData['IBAN']} &middot; <b>Poziv na broj:</b> {$billData['callNumber']}</p>
      </div>
      <div class='billContactInfo'>
        <div class='billPhone'><b>Telefon:</b><br> {$billData['billProviderPhone']}
</div>
        <div class='billEmail'><b>Email:</b><br> {$billData['billProviderMail']}
  </div>
        <div class='billWeb'><b>Internet:</b><br> {$billData['billProviderWeb']}
    </div>
    </div>
    <div class='billFootnotes'>
    {$billData['billFootnotes']}
    </div>

    </div>
  </body>
</html>
<?php ";
echo $out;
?>
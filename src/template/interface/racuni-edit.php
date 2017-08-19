<?php if($view != 'AddView' && $bill['billStatus'] != 'U izradi'){
  echo '<div class="editExportSuggestion">Ovaj račun je spremljen. Možda ga želite <a href="'.domainpath.activeInstance.'/racuni/exportHTML/'.$bill['id'].'">preuzeti ili ispisati</a>.</div>';
}
?>
<div class="oblakCoreBillStyling userCustomBillStyling">

  <form action="<?php echo domainpath . activeInstance . '/racuni'; ?>"
        method="post">
    <input type="hidden" name="action" value="<?php if ($view == 'AddView') {
      echo 'addNewBill';
    }
    else {
      echo 'editBill';
    } ?>">
    <input type="hidden" name="editView" value="<?php if (isset($bill)) {
      echo $bill['id'];
    } ?>">
    <input type="hidden" name="editBill" value="<?php if (isset($bill)) {
      echo $bill['id'];
    } ?>">
    <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
    <div class="row">
      <div class="col m3">
        <img
          src="<?php echo domainpath . activeInstance . '/datoteke/file/' . $oblak->getInstanceSetting(activeInstance, 'logoFileID')['value']; ?>"
          class="billProviderLogo">
      </div>
      <div class="col m7">
        <b><?php echo $oblak->getInstanceSetting(activeInstance, 'businessName')['value']; ?></b>
        <p><?php echo $oblak->getInstanceSetting(activeInstance, 'businessMainAddress')['value']; ?></p>
      </div>
      <div class="col m2">
        <select name="status" class="select1">
          <option
            value="Plaćeno" <?php if ((isset($bill['billStatus'])) && ($bill['billStatus'] == 'Plaćeno')) {
            echo 'selected';
          } ?>>Plaćeno
          </option>
          <option
            value="Neplaćeno" <?php if (isset($bill['billStatus']) && $bill['billStatus'] == 'Neplaćeno') {
            echo 'selected';
          }
          elseif (!isset($bill)) {
            echo 'selected';
          } ?>>Neplaćeno
          </option>
          <option
            value="U izradi" <?php if (isset($bill['billStatus']) && $bill['billStatus'] == 'U izradi') {
            echo 'selected';
          } ?>>U izradi
          </option>
          <option
            value="Stornirano" <?php if (isset($bill['billStatus']) && $bill['billStatus'] == 'Stornirano') {
            echo 'selected';
          } ?>>Stornirano (odabrati nakon storniranja)
          </option>
        </select>

      </div>
    </div>


    <div class="row">
      <div class="col s3">
        <b>Vrsta</b>
        <select id="billTypeSelector" name="type">
          <option
            value="Račun" <?php if (isset($bill['type']) && $bill['type'] == 'Račun' && $view !== 'AddView') {
            echo 'selected';
          } ?>>Račun
          </option>
          <option
            value="Ponuda" <?php if (isset($bill['type']) && $bill['type'] == 'Ponuda' && $view !== 'AddView') {
            echo 'selected';
          } ?>>Ponuda
          </option>
        </select>
      </div>
      <div class="col s3 racun">
        <b>Broj računa</b>
        <input type="number"
               value="<?php if($bill && $view == 'EditView'){echo $bill['billNumber']; } else{echo $racuni->guessBillNumber(activeInstance, 'racun');} ?>"
               name="billNumber" min="1">
      </div>
      <div class="col s3 ponuda">
        <b>Broj ponude</b>
        <input type="number"
               value="<?php  if($bill && $view == 'EditView'){echo $bill['billNumber']; } else{echo $racuni->guessBillNumber(activeInstance, 'ponuda');} ?>"
               name="billNumberPonuda" min="1">
      </div>
      <div class="col s3" id="businessAreaNumberCont">
        <b>Broj poslovnog prostora</b>
        <input type="number"
               id="businessAreaNumber"
               value="<?php  if($bill && $view == 'EditView'){echo $bill['businessAreaNumber']; } else{ echo $racuni->guessBusinessAreaNumber(activeInstance);} ?>"
               name="businessAreaNumber" min="1">
      </div>
      <div class="col s3" id="deviceNumberCont">
        <b>Broj naplatnog uređaja</b>
        <input type="number"
               id="deviceNumber"
               value="<?php if($bill && $view == 'EditView'){echo $bill['deviceNumber']; } else{ echo $racuni->guessDeviceNumber(activeInstance);} ?>"
               name="deviceNumber" min="1">
      </div>
    </div>

    <div class="row">
      <div class="col m6">
        <p><b>Kupac</b></p><br>
        <div class="input-field">
        <label for="buyerName">Ime kupca</label>
        <input type="text" name="buyerName" value="<?php if (isset($bill)) {
          echo $bill['buyerName'];
        } ?>">
          </div>  <div class="input-field">

        <label for="buyerAddress">Adresa kupca</label>
        <input type="text" name="buyerAddress" value="<?php if (isset($bill)) {
          echo $bill['buyerAddress'];
        } ?>">
        </div>  <div class="input-field">

        <label for="buyerOIB">OIB kupca</label>
        <input type="number" name="buyerOIB" maxlength="11" minlength="11" min="10000000000" max="99999999999"
               value="<?php if (isset($bill)) {
                 echo $bill['buyerOIB'];
               } ?>">
      </div></div>
      <div class="col m6">
        <b>Datum i vrijeme izdavanja</b>
        <div id="exactTime"></div>
        <br>
        <b>Rok plaćanja</b>
        <input type="date" name="paymentDeadlineDate" class="datepicker"
               data-value="<?php if (isset($bill) && $bill['paymentDeadlineDate'] != '0000-00-00') {
                 echo str_replace("-", "/", $bill['paymentDeadlineDate']);
               } ?>">
        <br>
        <b>Datum isporuke</b>
        <input type="date" name="deliveryDate" class="datepicker"
               data-value="<?php if (isset($bill) && $bill['deliveryDate'] != '0000-00-00') {
                 echo str_replace("-", "/", $bill['deliveryDate']);
               } ?>">
        <br>
        <b>Datum isteka</b>
        <input type="date" name="expirationDate" class="datepicker"
               data-value="<?php if (isset($bill) && $bill['expirationDate'] != '0000-00-00') {
                 echo str_replace("-", "/", $bill['expirationDate']);
               } ?>">
      </div>
    </div>

    <table class="billTable">
      <th>Rb.</th>
      <th>Opis</th>
      <th>Jed.</th>
      <th>Kol.</th>
      <th>Cijena</th>
      <th>Popust (%)</th>
      <th>Popust (iznos)</th>
      <th>Iznos</th>
      <?php if (!isset($bill)) { ?>
        <tr>
          <td></td>
          <td><textarea name="itemDescription[]"
                        class="materialize-textarea billTextarea"></textarea>
          </td>
          <td><input type="text" name="itemUnit[]" value="kom."></td>
          <td id="itemQuantityCell"><input type="number" name="itemQuantity[]"
                                           id="itemQuantity"
                                           onkeyup="itemCalculation(this)"
                                           onkeypress="itemCalculation(this)"
                                           step="0.0000001"
                                           value="1"
                                           required></td>
          <td id="itemPriceCell"><input type="number" name="itemPrice[]"
                                        id="itemPrice"
                                        step="0.0000001"
                                        onkeypress="itemCalculation(this)"
                                        onkeyup="itemCalculation(this)"
                                        required
                                        value="">
          </td>
          <td id="itemDiscountCell"><input type="number"
                                           name="itemDiscountPercentage[]"
                                           id="itemDiscount"
                                           onkeyup="itemCalculation(this)"
                                           onekeypress="itemCalculation(this)"
                                           step="0.0000001"
                                           value="0"
                                           required>
          </td>
          <td id="itemDiscountAmountCell"><input type="text"
                                                 name="itemDiscountAmount[]"
                                                 id="itemDiscountAmount"
                                                 value=""
                                                 disabled>
          </td>
          <td id="itemEqualsCell"><input type="text" name="itemEquals[]"
                                         id="itemEquals" class="itemEquals"
                                         value="" disabled>
          </td>
        </tr>
      <?php } ?>
      <?php if ($bill) {
        foreach ($bill['items'] as $item) {
          ?>
          <tr>
            <td></td>
            <td><textarea name="itemDescription[]"
                          class="materialize-textarea billTextarea"><?php echo $item['itemDescription']; ?></textarea>
            </td>
            <td><input type="text" name="itemUnit[]"
                       value="<?php echo $item['itemUnit']; ?>"></td>
            <td id="itemQuantityCell"><input type="number" name="itemQuantity[]"
                                             id="itemQuantity"
                                             onkeyup="itemCalculation(this)"
                                             onkeypress="itemCalculation(this)"
                                             step="0.0000001"
                                             value="<?php echo round($item['itemQuantity'], 5); ?>"
                                             required></td>
            <td id="itemPriceCell"><input type="number" name="itemPrice[]"
                                          id="itemPrice"
                                          step="0.0000001"
                                          onkeypress="itemCalculation(this)"
                                          onkeyup="itemCalculation(this)"
                                          required
                                          value="<?php echo $item['itemPrice']; ?>">
            </td>
            <td id="itemDiscountCell"><input type="number"
                                             name="itemDiscountPercentage[]"
                                             id="itemDiscount"
                                             onkeyup="itemCalculation(this)"
                                             onekeypress="itemCalculation(this)"
                                             step="0.0000001"
                                             value="<?php echo $item['itemDiscountPercentage']; ?>"
                                             required>
            </td>
            <td id="itemDiscountAmountCell"><input type="text"
                                                   name="itemDiscountAmount[]"
                                                   id="itemDiscountAmount"
                                                   value="<?php echo $item['itemDiscountAmount']; ?>"
                                                   disabled>
            </td>
            <td id="itemEqualsCell"><input type="text" name="itemEquals[]"
                                           id="itemEquals" class="itemEquals"
                                           value="<?php echo $item['itemEquals']; ?>"
                                           disabled>
            </td>
          </tr>
          <?php
        }
      }
      ?>

    </table>
    <a id="billAddItemButton" onclick="billAddItem()"><i
        class="material-icons left">add_circle</i> Dodaj stavku</a>
    <br><br>
    <div class="row">
      <div class="col m6">
        <div class="billMetadata">
          <label for="paymentType">Način plaćanja</label>
          <input type="text" name="paymentType" value="Transakcijski račun"
                 disabled>
          <label for="operator">Operator/dokument izdao</label>
          <input type="text" name="operator" value="<?php echo userFullname; ?>"
                 disabled>
          <label for="notes">Napomene</label>
          <textarea name="notes" class="materialize-textarea"><?php if(isset($bill)){echo $bill['notes'];} if(isset($bill) && $view == 'AddView' && $bill['type']=='Ponuda'){echo "\n Veza dokument: ".$bill['type']." ".$bill['billNumber'];}?></textarea>
        </div>
      </div>
      <div class="col m6">
        <div id="billGlobals">
          <b>Ukupan iznos računa</b>
          <input type="text" value="<?php if(isset($bill)){echo $bill['value']/100; }else{ echo '0.00'; } ?>" name="billEquals" id="billEquals"
                 disabled>
          <b>Popust po računu (%)</b>
          <input type="number" value="<?php if(isset($bill)){echo $bill['billDiscountPercentage']/100;} else{echo '0';}?>" name="billDiscountPercentage"
                 id="billDiscount"
                 step="0.0000001"
                 onkeyup="itemCalculation(this)"
                 onkeypress="itemCalculation(this)">
          <b>Iznos popusta po računu</b>
          <input type="text" value="<?php if(isset($bill)){echo $bill['billDiscountAmount']/100;} else{echo '0.00';}?>" name="billDiscountAmount"
                 id="billDiscountAmount" disabled>

        </div>
      </div>
    </div>
    <div class="billPaymentData">
      <b>Podaci za uplatu</b><br>
      <div class="row">
        <div class="col m3">
          <label for="IBAN">IBAN</label>
          <input type="text"
                 value="<?php if(isset($bill)){echo $bill['IBAN'];} else{echo $oblak->getInstanceSetting(activeInstance, 'businessMainIBAN')['value'];}?>"
                 name="IBAN">
        </div>
        <div class="col m3">
          <label for="callNumber">Poziv na broj</label>
          <input type="text"
                 value="<?php if(isset($bill)){echo $bill['callNumber'];} else{echo $racuni->guessCallNumber(activeInstance);}?>"
                 name="callNumber">
        </div>
      </div>
    </div>
    <br><br>
    <div class="row">
      <div class="col m4 billProviderInfo center-block">
        <label for="billProviderWeb">Web</label>
        <input type="text" name="billProviderWeb"
               value="<?php echo $oblak->getInstanceSetting(activeInstance, 'businessWeb')['value']; ?>">
      </div>
      <div class="col m4 billProviderInfo center-block">
        <label for="billProviderPhone">Telefon</label>
        <input type="text" name="billProviderPhone"
               value="<?php echo $oblak->getInstanceSetting(activeInstance, 'businessPhone')['value']; ?>">
      </div>
      <div class="col m4 billProviderInfo center-block">
        <label for="billProviderMail">Email</label>
        <input type="text" name="billProviderMail"
               value="<?php echo $oblak->getInstanceSetting(activeInstance, 'businessMail')['value']; ?>">
      </div>
    </div>
    <br><br>
    <label for="footnotes">Podnožje</label>
    <textarea name="footnotes" placeholder="npr. obvezni podatci tvrtke"
              class="materialize-textarea"><?php if(isset($bill)){echo $bill['billFootnotes'];} else{ echo $racuni->getFootnotes(activeInstance); } ?></textarea>
    <br><br>
    <?php if(isset($bill['status']) && $bill['billStatus'] !== "U izradi" && $view !== 'AddView'){
      echo '<button class="btn waves-effect waves-light disabled" type="submit" disabled>Spremanje izmjena nije moguće</button>';
      echo '<br><b>Izdane račune nije moguće mijenjati.</b>';
    }
    else{
      echo '<button class="btn waves-effect waves-light" type="submit">Spremi</button>';
    }
    ?>
  </form>
  <script>
    moment.locale('hr');
    var exactTime = null,
      date = null;

    var getTime = function () {
      date = moment();
      exactTime.html(date.format('DD. MMMM YYYY. u HH:mm:ss'));
    };

    $(document).ready(function () {
      exactTime = $('#exactTime');
      getTime();
      setInterval(getTime, 1000);
    });

    $('#billTypeSelector').on('change', function () {
      var billType = $('#billTypeSelector').val();
      if (billType === "Ponuda") {
        $(".racun").css('display', 'none');
        $("#businessAreaNumberCont").css('display', 'none');
        $("#deviceNumberCont").css('display', 'none');
        $(".ponuda").css('display', 'block');
      }
      if (billType === "Račun") {
        $(".ponuda").css('display', 'none');
        $(".racun").css('display', 'block');
        $("#businessAreaNumberCont").css('display', 'block');
        $("#deviceNumberCont").css('display', 'block');
      }
    });


    function itemCalculation(elem) {
      var priceCellValue = $(elem).parent().parent().children('#itemPriceCell').children('#itemPrice').val();
      var quantityValue = $(elem).parent().parent().children('#itemQuantityCell').children('#itemQuantity').val();
      var discountValue = $(elem).parent().parent().children('#itemDiscountCell').children('#itemDiscount').val();
      var billEquals = $('#billGlobals').children('#billEquals').val();
      var billEquals = parseFloat(billEquals);
      var billDiscount = $('#billGlobals').children('#billDiscount').val();
      var billDiscountAmount;
      var equalsValue;
      var discountAmount;
      if (priceCellValue && quantityValue) {
        equalsValue = quantityValue * priceCellValue;
        discountAmount = equalsValue * (discountValue / 100);
        equalsValue = equalsValue - discountAmount;
        $(elem).parent().parent().children('#itemDiscountAmountCell').children('#itemDiscountAmount').val(discountAmount.toFixed(2));
        $(elem).parent().parent().children('#itemEqualsCell').children('#itemEquals').val(equalsValue.toFixed(2));


      }

      var billEquals = 0;
      $('.itemEquals').each(function (index, elem) {
        var val = parseFloat($(elem).val());
        if (!isNaN(val)) {
          billEquals += val;
        }
      });


      billDiscountAmount = billEquals * (billDiscount / 100);
      billEquals = billEquals - billDiscountAmount;
      $('#billGlobals').children('#billEquals').val(billEquals.toFixed(2));
      $('#billGlobals').children('#billDiscountAmount').val(billDiscountAmount.toFixed(2));


    }

    function billAddItem() {
      $('.billTable').find("tr").last().clone().appendTo('.billTable');
    }


  </script>
</div>
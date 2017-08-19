<form action="<?php echo domainpath . activeInstance . '/kontakti'; ?>"
      method="post">
<div class="container">
<div class="personEditor">

    <input type="hidden" name="action" value="<?php if ($view == 'AddView') {
      echo 'addPerson';
    }
    else {
      echo 'editPerson';
    } ?>">
    <input type="hidden" name="editView" value="<?php if (isset($person)) {
      echo $personID;
    } ?>">
    <input type="hidden" name="editPerson" value="<?php if (isset($person)) {
      echo $personID;
    } ?>">
    <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
    <div class="input-field">
      <label for="firstName">Ime</label>
      <input type="text" name="firstName">
    </div>
    <div class="input-field">
      <label for="lastName">Prezime</label>
      <input type="text" name="lastName">
    </div>

    <div class="input-field">
      <label for="groups">Grupe</label>
      <input type="text" id="grfield" name="groups" style="display:block;" placeholder="Započnite tipkati..." onkeyup="customTypeChangeHandler(this)">
    </div>
    </div>
  </div>
<div class="container">
  <div class="cf">
        <div class="row fr">
          <div class="col s6">
        <div class="input-field">
          <select name="customType[]" style="display:block;" class="customType" onchange="customTypeChangeHandler(this)">
            <option value="type" disabled selected>Polje...</option>

            <?php foreach($oblak->people->getMetadataTypes(activeInstance) as $type){
              echo "<option value='{$type['attributeName']}'>{$type['attributeHumanReadableName']}</option>";
            }
            ?>
            <option value="newField">Novo polje...</option>
          </select>
        </div>
          </div>
            <div class="col s6">
              <div class="input-field">
                <label for="customTypeValue[]">Vrijednost</label><input type="text" name="customTypeValue[]" value="">
              </div>
              </div>
        <div class="row newFieldData">
          <div class="col s6">
        <div class="input-field">
        <label for="newFieldName[]">Ime novog polja</label><input type="text" name="newFieldName[]" value="">
        </div></div>
          <div class="col s6"> <div class="input-field">
        <label for="newFieldID[]">Kratka oznaka novog polja</label><input type="text" name="newFieldID[]" value="">
              </div></div></div></div></div></div>
<div class="container">

    <a id="addFieldButton" onclick="addNewContactField()"><i
        class="material-icons left">add_circle</i> Dodaj polje</a>
    <br><br>
    <div class="input-field">
      <input type="checkbox" id="employee" name="createAccount" onchange="accountChangeHandler(this)">
      <label for="employee">Ova osoba je zaposlenik tvrtke. Stvori joj korisnički račun.</label>
    </div>
  <br><br>
    <div class="ud row">
      <div class="col s6">
        <div class="input-field">
          <input type="text" name="username">
          <label for="username">Korisničko ime</label>
          <small><b>Ne zaboravite:</b> unesite e-mail polje pri dodavanju korisnika.</small>
        </div>
      </div>
      <div class="col s6">
        <div class="input-field">
          <input type="password" name="password">
          <label for="password">Lozinka</label>
          <small>Prijedlog: <pre style="display:inline;"><?php echo substr(base64_encode(openssl_random_pseudo_bytes(10)),0, -2); ?></pre></small>
        </div>
      </div>
    </div>
  <button class="btn" type="submit"><?php if($view=='AddView'){echo 'Dodaj kontakt';}else{echo 'Spremi promjene';} ?></button>
    <script>

      var ajax = new XMLHttpRequest();
      ajax.open("GET", "<?php echo domainpath.activeInstance; ?>/kontakti/appAPI/<?php echo csrfToken; ?>/groupSuggestions", true);
      ajax.onload = function() {
        var list = JSON.parse(ajax.responseText).map(function(i) { return i.name; });
        new Awesomplete(document.querySelector("#grfield"),{ list: list, filter: function(text, input) {
          return Awesomplete.FILTER_CONTAINS(text, input.match(/[^,]*$/)[0]);
        }, replace: function(text) {
          var before = this.input.value.match(/^.+,\s*|/)[0];
          this.input.value = before + text + ", ";
        } });

      };
      ajax.send();

      function addNewContactField() {
        $('.cf').find(".fr").last().clone().appendTo('.cf');
      }

      function customTypeChangeHandler(elem){
        if(elem.value == "newField"){
          $(elem).parent().parent().parent().children(".newFieldData").css("display", "block");
        }
        else{
          $(elem).parent().parent().parent().children(".newFieldData").css("display", "none");
        }
      }

      function accountChangeHandler(elem){
        if($('#employee').is(':checked')) {
          $('.ud').css("display", "block");
          var value = $('#grfield').val();
          if(value == undefined){
            value = "";
          }
          if (value.indexOf('Zaposlenici') == -1) {
            if(value.length>0){
              if(value.charAt(value.length-1)==' '){
                $('#grfield').val(value+"Zaposlenici");
              }
              else {
                $('#grfield').val(value + " ,Zaposlenici");
              }
            }
            else{
              $('#grfield').val(value+"Zaposlenici");
            }
          }
        }
        else{
          $('.ud').css("display", "none");
        }
      }
    </script>
    <style>
      .newFieldData, .ud{display:none;}
    </style>

</div>


</form>

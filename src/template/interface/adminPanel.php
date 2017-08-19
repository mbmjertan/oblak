<div class="row">
  <div class="col s3 upperMargin">
    <a href="<?php echo domainpath.activeInstance.'/admin'; ?>" class="navLink active">Pregled postavki</a>
    <a href="mailto:email@example.com" class="navLink">Podrška</a>


  </div>
  <div class="col s9">
    <div class="container">
      <div class="row">
        <div class="col s3">
          <b>Ime instance</b>
        </div>
        <div class="col s9">
          <?php echo activeInstance; ?>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Ime tvrtke</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessName')['value']; ?>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Adresa tvrtke</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessMainAddress')['value']; ?>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Poštanski broj</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessMainPostcode')['value']; ?>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Grad</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessMainCity')['value']; ?>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Država</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessCountry')['value']; ?>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Jezik aplikacije</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'appLanguage')['value']; ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Stopa PDV-a</b>
        </div>
        <div class="col s9">
          0%
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Logo</b>
        </div>
        <div class="col s9">
          <img src="<?php echo domainpath.activeInstance.'/datoteke/file/'.$oblak->getInstanceSetting(activeInstance, 'logoFileID')['value']; ?>">
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>IBAN</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessMainIBAN')['value']; ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Predložak poziva na broj</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessCallNumberTemplate')['value']; ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Izgled računa</b>
        </div>
        <div class="col s9">
          <?php if($oblak->settingExists(activeInstance, 'billTableLayout')){
            if($oblak->getInstanceSetting(activeInstance, 'billTableLayout')['value'] == 'bigdescrip'){
              echo 'Povećan prostor za opis stavke';
            }
            else{
              echo 'Tipičan';
            }
          }
          else{
            echo 'Tipičan';
          }
          ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Web stranica tvrtke</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessWeb')['value']; ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Telefon tvrtke</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessPhone')['value']; ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>E-mail adresa tvrtke</b>
        </div>
        <div class="col s9">
          <?php echo $oblak->getInstanceSetting(activeInstance, 'businessMail')['value']; ?>
        </div>
      </div>

      <div class="row">
        <div class="col s3">
          <b>Plaćanje Poslovnog oblaka</b>
        </div>
        <div class="col s9">
          Trenutno: Besplatno
        </div>
      </div>


      <div class="row">
        <div class="col s3">
          <b>Sigurnosna kopija</b>
        </div>
        <div class="col s9">
          <a href="<?php echo domainpath.activeInstance.'/admin/backup'; ?>" class="btn">Napravi sigurnosnu kopiju</a>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <b>Brisanje instance</b>
        </div>
        <div class="col s9">
          <a href="<?php echo domainpath.activeInstance.'/admin/delete'; ?>" class="btn red">Pokreni proces brisanja instance</a>
        </div>
      </div>

    </div>
  </div>
</div>


<style>
  body {
    background-color: #212121;
    color: #fafafa;
  }
  img{
    max-height: 128px;
  }
  .container{
    margin-top: 5%;
  }
  .upperMargin{
    margin-top:5%;
    margin-left: 0;

  }
  .navLink:link, .navLink:visited, .navLink:hover{
    color:#fafafa !important;
    text-decoration:none;
    display:block;
    margin-left:0px;
    padding: 4%;
    transition: background-color 0.2s;

  }
  .active{
    background-color: #546e7a;
  }
  .navLink:hover{
    background-color:#37474f;
  }
</style>
<div class="row">
  <div class="col s3 upperMargin">
    <a href="<?php echo domainpath.activeInstance.'/admin'; ?>" class="navLink active">Pregled postavki</a>
    <a href="mailto:email@example.com" class="navLink">Podrška</a>


  </div>
  <div class="col s9">
    <div class="container">
      <form action="<?php echo domainpath.activeInstance.'/admin/submitDelete'; ?>" method="post">
        <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
        <h2>Žao nam je što odlazite.</h2>
        <p><b>Niste vi, mi smo.</b> Ako želite, u polje ispod nam recite što možemo činiti bolje.</p>
        <div class="input-field">
          <label for="deleteReasons">Napuštamo Poslovni oblak jer...</label>
          <textarea name="deleteReasons" class="materialize-textarea"></textarea>
        </div>
        <p>Bez obzira na to zašto odlazite, evo nekoliko stvari koje biste trebali znati.</p>
        <p><b>Koraci brisanja instance</b></p>
        <p>1. Prije nego što obrišemo instancu, kontaktirat ćemo prvog administratora instance e-mailom ili telefonom. Ako ne dobijemo odgovor ili osoba nije ovlaštena ga dati, kontaktirat ćemo korisnike po redu aktivnosti dok ne dobijemo potvrdu stvarne namjere tvrtke.</p>
        <p>2. Kad (ako) dobijemo afirmativan odgovor, onemogućit ćemo pristup instanci, ali ćemo sačuvati njene podatke i držati ju pokrenutom idućih 30 dana u slučaju da se predomislite.</p>
        <p>3. Poslat ćemo obavijest o brisanju svim registriranim korisnicima instance.</p>
        <p>4. Ako u tih 30 dana ne opozovete zahtjev za brisanjem instance, instanca će biti isključena i obrisana zajedno sa svim njenim podacima.</p>
        <p><small>Ako shvatimo da je instanca prazna odnosno da se radilo o instanci namijenjoj testiranju, preskočit ćemo ovaj proces i odmah je isključiti i obrisati.</small></p>
        <p><b>Što učiniti prije brisanja</b></p>
        <p>1. Ako još niste, svakako preuzmite sigurnosnu kopiju instance. Nadalje, primjerke svih računa ste zakonski dužni čuvati, stoga ne zaboravite ih izvesti / ispisati.</p>
        <p>2. Pošaljite obavijest svim korisnicima instance o budućem brisanju kako bi tranzicija bila lakša. Imajte na umu da sigurnosna kopija sadržava tek sadržaj koji je bio spremljen u trenutku njena stvaranja.</p>
        <p><b>Kako poslati zahtjev za brisanjem</b></p>
        <p>Jednostavno! Ako ste pročitali blok teksta iznad i razumijete što govori te ste sigurni da ste ovlašteni od strane Vaše tvrtke za brisanje instance, kliknite gumb ispod.</p>
        <button class="btn btn-large red">Obriši ovu instancu</button>
        <br>
        <small>Klikom na gumb jamčite da ste ovlašteni od strane vaše tvrtke za brisanje instance i, ovisno o odredbama Uvjeta korištenja, za raskid odnosa. Kad kliknete na gumb, automatski će se generirati zahtjev za brisanjem instance koji će sadržavati Vaše ime, ime Vaše instance, Vašu IP adresu, korisnički agent i UNIX oznaku vremena u sekundama. </small>
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
      </form>
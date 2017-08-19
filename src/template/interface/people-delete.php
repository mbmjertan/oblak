<div class="container">
  <p>Brišete kontakt <code><?php echo $personData[count($personData)-1]['guessedSpelling']; ?></code>.
    <b>Ova radnja je nepovratna</b> i učinit će sadržaj zauvijek nedostupnim svim korisnicima.</p>
  <p>Ako ovaj kontakt ima korisnički račun unutar Poslovnog oblaka, on će također biti obrisan. Sav sadržaj kojeg je korisnik stvorio će se sačuvati.</p>
<form action="<?php echo "/".activeInstance."/kontakti"; ?>" method="post">
    <input type="hidden" name="action" value="deletePerson">
    <input type="hidden" name="deletePerson" value="<?php echo $personID; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
    <input type="submit" value="Obriši" class="btn btn-large cyan accent-4">
  </form>
</div>
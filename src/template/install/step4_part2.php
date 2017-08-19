<h1>Kako će se zvati web stranica?</h1>
<p>Unesite ime koje će se koristiti za web stranicu.</p>
<form action="step4.php" method="post">
    <input type="hidden" name="s4" value="true">
    <input type="text" name="name" class="form-control" placeholder="Prikazivat će se svugdje.">

    <h1>Opišite web stranicu.</h1>

    <p>Unesite kratki sažetak web stranice.</p>
  <textarea name="description" class="form-control"
            placeholder="Prikazivat će se na tražilicama, web stranici, RSS feedovima i drugim mjestima."></textarea>
    <br><br>
    <input type="submit" class="btn btn-primary btn-large" value="Nastavi &rarr;">
</form>
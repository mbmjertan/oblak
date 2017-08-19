<h1>Okej. Tko ste vi?</h1>
<p>Popunite polja ispod s informacijama o sebi</p>
<form action="step3.php" method="post">
    <input type="hidden" name="s3" value="true">
    <label for="name">Ime i prezime</label>
    <input type="text" name="name" placeholder="na primjer, <?php echo $eg->example_generate_name(); ?>"
           class="form-control" required>
    <label for="email">Email adresa (nije javna)</label>
    <input type="email" name="email" placeholder="na primjer, <?php echo $eg->example_generate_email(); ?>"
           class="form-control" required>
    <label for="password">Lozinka (sigurno pohranjena)</label>
    <input type="password" name="password" placeholder="na primjer, 123456" class="form-control" required>
    <br><br>
    <input type="submit" value="Dodaj korisnika &rarr;" class="btn btn-primary btn-large" class="form-control">
</form>
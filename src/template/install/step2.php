<h1>Gdje je baza podataka?</h1>
<p>Ovdje će vam možda zatrebati pomoć. <a href="../docs/setup_mysql.html" rel="_blank">Pomozi mi.</a></p>
<form action="step2.php" method="post">
    <input type="hidden" name="setdb" value="true">
    <label for="server">MySQL server</label>
    <input type="text" name="server" placeholder="na primjer, localhost" class="form-control" required>
    <label for="user">Korisničko ime za MySQL</label>
    <input type="text" name="user" placeholder="na primjer, root" class="form-control" required>
    <label for="password">Lozinka za MySQL</label>
    <input type="text" name="password" placeholder="na primjer, 123456" class="form-control">
    <label for="db">Baza podataka</label>
    <input type="text" name="db" placeholder="na primjer, nscms" class="form-control" required>
    <br><br>
    <input type="submit" value="Postavi bazu podataka &rarr;" class="btn btn-primary btn-large" class="form-control">
</form>
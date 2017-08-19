<div class="row">
    <form class="col s12" action="index.php" method="post">
        <input type="hidden" name="action" value="addUser">
        <input type="hidden" name="csrfToken" value="<?php echo $csrfToken; ?>">

        <div class="row">
            <div class="input-field col s6">
                <input id="email" type="email" name="email" class="validate" required>
                <label for="email">Email</label>
            </div>
            <div class="input-field col s6">
                <input id="password" type="password" name="password" class="validate" required>
                <label for="password">Lozinka</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate" required>
                <label for="name">Ime i prezime</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input id="level" name="level" type="number" min="1" max="10" class="validate" required>
                <label for="level">Administratorska razina (1-10, veće je jače)</label>
            </div>
        </div>


        <button class="btn waves-effect waves-light" type="submit">Dodaj
            <i class="mdi-content-send right"></i>
        </button>

        <p>Kada kliknete na Dodaj, bit će stvoren <b>novi korisnik </b>. </p>
    </form>
</div>

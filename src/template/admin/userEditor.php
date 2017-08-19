<div class="row">
    <form class="col s12" action="index.php" method="post">
        <input type="hidden" name="action" value="editUser">
        <input type="hidden" name="id" value="<?php echo htmlentities($_GET['id']); ?>">
        <input type="hidden" name="selfaction" value="<?php if (isset($data)) {
            echo $data['self'];
        } ?>">
        <input type="hidden" name="csrfToken" value="<?php echo $csrfToken; ?>">

        <div class="row">
            <div class="input-field col s6">
                <input id="email" type="email" name="email" class="validate" required value="<?php if (isset($data)) {
                    echo $data['email'];
                } ?>">
                <label for="email">Email</label>
            </div>
            <div class="input-field col s6">
                <input id="password" type="password" name="password" class="validate">
                <label for="password">Promijenite lozinku</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate" required value="<?php if (isset($data)) {
                    echo $data['name'];
                } ?>">
                <label for="name">Ime i prezime</label>
            </div>
        </div>
        <?php if ($data['self'] === false) { ?>
            <div class="row">
                <div class="input-field col s12">
                    <input id="level" name="level" type="number" min="1" max="10" class="validate" required
                           value="<?php if (isset($data)) {
                               echo $data['level'];
                           } ?>">
                    <label for="level">Administratorska razina (1-10, veće je jače)</label>
                </div>
            </div>
        <?php } ?>

        <p>
            <input type="checkbox" class="banned" name="banned" value="1"
                   id="banned" <?php
            if ((isset($data)) && ($data['banned']) == 1) {
                echo 'checked="true"';
            } ?> />
            <label for="banned">Zabrani korisniku prijavu na stranicu</label>
        </p>


        <button class="btn waves-effect waves-light" type="submit">Spremi promjene
            <i class="mdi-content-send right"></i>
        </button>

    </form>
    <?php if($data['self'] == true){
        echo '<a href="sessions.php">View active sessions</a>';
    }
    ?>
</div>

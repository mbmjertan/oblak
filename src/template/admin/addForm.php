<div class="row">
    <form class="col s12" action="index.php" method="post">
        <?php if (isset($_GET['parent'])) {
            echo '<input type="hidden" name="parent" value="' . htmlentities($_GET['parent']) . '">';
            echo 'Ova stranica će postati dijete stranice ' . htmlentities($_GET['parent']) . '.';
        } elseif (isset($data)) {
            echo '<input type="hidden" name="parent" value="' . htmlentities($data['parent']) . '">';
            echo '<input type="hidden" name="originalSlug" value="' . htmlentities($_GET['update']) . '">';
        }
        ?>
        <input type="hidden" name="<?php echo $field; ?>" value="<?php echo $value; ?>">
        <input type="hidden" name="action" value="addPage">
        <input type="hidden" name="csrfToken" value="<?php echo $csrfToken; ?>">
        <input type="hidden" name="type" value="<?php if (isset($_GET['type'])) {
            echo $_GET['type'];
        } else {
            echo 'page';
        } ?>">

        <div class="row">
            <div class="input-field col s6">
                <input id="title" type="text" name="title"
                       onkeypress="document.getElementById('slug').value = getSlug(document.getElementById('title').value);document.getElementById('slug-label').style.top='-12.6px';document.getElementById('slug-label').style.fontSize='12.6px';"
                       onkeyup="document.getElementById('slug').value = getSlug(document.getElementById('title').value);document.getElementById('slug-label').style.top='-12.6px';document.getElementById('slug-label').style.fontSize='12.6px';"
                       class="validate" value="<?php if (isset($data)) {
                    echo $data['title'];
                } ?>" required>
                <label for="title">Naslov</label>
            </div>
            <div class="input-field col s6">
                <input id="slug" type="text" name="slug" class="validate" value="<?php if (isset($data)) {
                    echo $data['slug'];
                } ?>" required>
                <label for="slug" id="slug-label">Kratka oznaka (slug)</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="summary" name="summary" type="text" class="validate" value="<?php if (isset($data)) {
                    echo $data['summary'];
                } ?>">
                <label for="summary">Sažetak</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="sources" name="sources" type="text" class="validate" value="<?php if (isset($data)) {
                    echo $data['sources'];
                } ?>">
                <label for="sources">Izvori (neobavezno)</label>
            </div>
        </div>
        <?php if ($_GET['type'] != 'blog') {

            echo '<div class="row">
      <div class="input-field col s12">
        <p>Tijelo (sadržaj stranice)</p>
        <textarea id="content" name="body" class="materialize-textarea" required>' . $data['body'] . '
         </textarea>';
        }
        ?>
</div>
</div>
<div class="row">
    <div class="input-field col s12">
        <p>Postavke stranice</p>

        <p>
            <input name="status" value="0" type="radio"
                   id="public" <?php if (($data['status'] !== 1) && ($data['status'] !== 3)) {
                echo 'checked';
            } ?> />
            <label for="public">Javna</label>
        </p>

        <p>
            <input name="status" type="radio" value="1" id="draft" <?php if ($data['status'] == 1) {
                echo 'checked';
            } ?> />
            <label for="draft">Skica</label>
        </p>

        <p>
            <input name="status" value="3" type="radio" id="archived"<?php if ($data['status'] == 3) {
                echo 'checked';
            } ?>/>
            <label for="archived">Arhivirana</label>
        </p>


        <p>
            <input type="checkbox" class="showinnav" name="showinnav" value="1"
                   id="showinnav" <?php if (isset($_GET['parent']) || isset($_POST['parent'])) {
                echo '';
            } elseif (!isset($data) || ($data['showinnav'] != 0)) {
                echo 'checked="checked"';
            } ?> />
            <label for="showinnav">Prikaži u navigaciji ako je stranica javna</label>
        </p>


        <p>Kada kliknete na <?php if (isset($data)) {
                echo 'Uredi, stranica će biti ažurirana, a starija verzija nje će biti pohranjena u bazi podataka iz sigurnosnih razloga.';
            } else {
                echo 'Dodaj, stranica će biti dodana u skladu s navedenim postavkama. Ako već postoji stranica s istom kratkom oznakom, kratka oznaka biti će adaptirana.';
            } ?></p>
        <button class="btn waves-effect waves-light" type="submit"><?php if (isset($data)) {
                echo 'Uredi';
            } else {
                echo 'Dodaj';
            } ?>
            <i class="mdi-content-send right"></i>
    </div>
    </button>
    </form>
</div>

<script src="../template/admin/speakingurl.min.js"></script>

<script>
    var slug;
    slug = getSlug(document.getElementById("title").value);
    console.log(slug);
</script>

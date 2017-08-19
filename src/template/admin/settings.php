<div class="container">
    <div class="pageEditor">
        <div class="row">
            <form class="col s12" action="index.php" method="post">
                <input type="hidden" name="action" value="settingsManager">
                <input type="hidden" name="csrfToken" value="<?php echo $csrfToken; ?>">


                <div class="row">
                    <p>Metapodatci</p>

                    <div class="input-field col s12">

                        <input id="siteName" name="siteName" type="text" class="validate"
                               value="<?php if (isset($data)) {
                                   echo $data['siteName'];
                               } ?>">
                        <label for="summary">Ime stranice</label>
                    </div>
                </div>

        </div>


        <div class="row">
            <div class="input-field col s12">
                <label for="siteDescription">Opis web stranice (prikazuje se u tražilicama i na sl. mjestima)</label>
                <textarea name="siteDescription" class="materialize-textarea" required><?php if (isset($data)) {
                        echo $data['siteDescription'];
                    } ?></textarea>

            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <p>Vrsta stranice</p>

                <p>
                    <input name="siteType" value="personal" type="radio"
                           id="personal" <?php if ($data['siteType'] == 'personal') {
                        echo 'checked';
                    } ?> />
                    <label for="personal">Osobna web stranica ili web stranica grupe ljudi</label>
                </p>

                <p>
                    <input name="siteType" type="radio" value="company"
                           id="company" <?php if ($data['siteType'] == 'company') {
                        echo 'checked';
                    } ?> />
                    <label for="company">Web stranica tvrtke ili organizacije</label>
                </p>

                <p>
                    <input name="siteType" value="project" type="radio"
                           id="project"<?php if ($data['siteType'] == 'project') {
                        echo 'checked';
                    } ?>/>
                    <label for="project">Web stranica proizvoda ili projekta</label>
                </p>

                <p>
                    <input name="siteType" type="radio" value="blog" id="blog" <?php if ($data['siteType'] == 'blog') {
                        echo 'checked';
                    } ?> />
                    <label for="blog">Blog</label>
                </p>

                <p>Konfiguracija</p>
                <p>
                    <input type="checkbox" class="pluginManagerStatus" name="pluginManagerStatus" value="1"
                           id="pluginManagerStatus" <?php if ((isset($data)) && ($data['pluginManagerStatus'] == 1)) {
                        echo 'checked="checked"';
                    } else {
                        echo '';
                    } ?> />
                    <label for="pluginManagerStatus">Omogući dodatke</label>
                </p>
                <?php if ((isset($data)) && ($data['pluginManagerStatus'] == 1)) { ?>
                    <p>
                        <input type="checkbox" class="analyzeStatus" name="analyzeStatus" value="1"
                               id="analyzeStatus" <?php if ((isset($data)) && ($data['analyzeStatus'] == 1)) {
                            echo 'checked="checked"';
                        } else {
                            echo '';
                        } ?> />
                        <label for="analyzeStatus">Omogući analitiku
                            <small>(pruža dodatak <b>Analyze</b> autora <b>Nightsparrow</b>)</small>
                        </label>

                    </p>
                <?php } ?>
                <p>
                    <input type="checkbox" class="registrationStatus" name="registrationStatus" value="1"
                           id="registrationStatus" <?php if ((isset($data)) && ($data['registrationStatus'] == 1)) {
                        echo 'checked="checked"';
                    } else {
                        echo '';
                    } ?> />
                    <label for="registrationStatus">Omogući javnu registraciju</label>
                </p>
                <!--  <p>
      <input type="checkbox" class="pageCommentStatus" name="pageCommentStatus" value="1"
             id="pageCommentStatus" <?php if ((isset($data)) && ($data['pageCommentStatus'] == 1)) {
                    echo 'checked="checked"';
                } else {
                    echo '';
                } ?> />
      <label for="pageCommentStatus">Omogući komentare na stranicama</label>
    </p>-->

                <p>
                    <input type="checkbox" class="disablePublicAPI" name="disablePublicAPI" value="1"
                           id="disablePublicAPI" <?php if ((isset($data)) && ($data['publicAPIStatus'] == 1)) {
                        echo 'checked="true"';
                    } else {
                        echo '';
                    } ?> />
                    <label for="disablePublicAPI">Zabrani pristup javnom API-ju</label>
                </p>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="postsPerPage" name="postsPerPage" value="<?php if (isset($data)) {
                            echo $data['postsPerPage'];
                        } ?>" type="number" min="1" max="100" class="validate" required>
                        <label for="postsPerPage">Broj postova po stranici</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <p>Tema određuje gdje se zaglavlje i podnožje pojavljuju.</p>
                        <b>Zaglavlje web stranice</b>
                        <textarea name="headerContent" class="materialize-textarea"><?php if (isset($data)) {
                                echo $data['headerContent'];
                            } ?></textarea>

                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <b>Podnožje web stranice</b>
                        <textarea name="footerContent" class="materialize-textarea"><?php if (isset($data)) {
                                echo $data['footerContent'];
                            } ?></textarea>

                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="logoLink" name="logoLink" type="text" class="validate"
                                   value="<?php if (isset($data)) {
                                       echo $data['logoLink'];
                                   } ?>">
                            <label for="logoLink">URL logotipa (ako nije postavljeno, koristi se tekst)</label>
                        </div>
                    </div>


                    <button class="btn waves-effect waves-light" type="submit">Spremi
                        <i class="mdi-content-send right"></i>
                    </button>
                </div>
            </div>
            <a href="settings-table.php">Pogledaj tablicu svih postavki i njihovih revizija</a>

            </form>
        </div>


    </div>
</div>
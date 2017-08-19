<?php

class Installer
{
    function chmod_error($content, $file, $return)
    {
        include '../template/install/fail_header.php';
        echo '<h1>Imamo problem.</h1>';
        echo '<p>Morat ćete ovo kopirati ručno u <code>' . $file . '</code> datoteku.</p>';
        echo '<textarea class="form-control file-paste">' . $content . '</textarea>';
        echo 'Kada ste gotovi, kliknite gumb ispod. <br>';
        echo '<a href="' . $return . '" class="btn btn-primary">Nastavi &rarr;</a>';
        include '../template/install/fail_footer.php';

    }
}

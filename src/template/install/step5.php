<h1>Izaberite predložak.</h1>
<p>Predlošci su osnova za vašu web stranicu -- izaberite neki koji odgovara vašim potrebama.</p>

<div class="row">
    <?php
    include_once '../config.php';
    include_once '../inc/nightsparrow-main.php';
    include_once '../inc/templates.php';
    $templates = new Templates;
    $templates->generateTemplatePicker();
    ?>
</div>
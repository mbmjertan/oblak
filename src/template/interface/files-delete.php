
<div class="container">
Brišete 
<?php 
$name = htmlspecialchars($fileData['name']);
if($fileData['type'] == 'folder'){
    echo "mapu <i>{$name}</i> i sav njen sadržaj.";
}
else{
    echo "datoteku <i>{$name}</i>.";
}
?>
 <b>Ova radnja je nepovratna</b> i učinit će sadržaj zauvijek nedostupnim svim korisnicima. 
<form action="<?php echo "/".activeInstance."/datoteke"; ?>" method="post">
    <input type="hidden" name="deleteFile" value="<?php echo $fileID; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">

    <input type="submit" value="Obriši" class="btn btn-large cyan accent-4">
</form>
</div>
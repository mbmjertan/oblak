<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- učitamo materialize.css -->
    <link type="text/css" rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css"
          media="screen,projection"/>
    <!-- učitamo Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- aww -->
    <link href="NightsparrowMiniLogo.png" rel="shortcut icon">

    <!-- Materialize.css-ov viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title><?php echo $pageTitle; ?> -- Nightsparrow</title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <!-- Redactor is here -->
    <link rel="stylesheet" href="../template/admin/redactor-js/redactor/redactor.css"/>
    <link rel="stylesheet" href="../template/admin/admin.css"/>
    <meta name="theme-color" content="#00ABF4">


    <script src="../template/admin/redactor-js/redactor/redactor.min.js"></script>
    <script src="../template/common/js/momloc.js"></script>


    <script type="text/javascript">
        $(document).ready(
          function () {
              $('#content').redactor({
                  imageUpload: 'upload.php?upload=photo',
                  fileUpload: 'upload.php?upload=file',
                  fixed: true
              });
          }
        );

    </script>
</head>
<body><!--
<style>
.navlink{
  color: #fefefe !important;
}
.navlink:active, .navlink:focus, .navlink:hover{
  background-color: #184373 !important;
}
</style>-->
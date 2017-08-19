<nav class="light-blue">
    <div class="nav-wrapper">
        <a href="index.php" class="brand-logo"><img src="<?php echo domainpath; ?>template/icons/nightsparrow.png"
                                                    alt="Nightsparrow" style="width:125px;margin-left:5px;"></a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="index.php">Struktura</a></li>
            <li><a href="users.php">Korisnici</a></li>
            <li><a href="design.php">Dizajn</a></li>
            <li><a href="settings-manager.php">Postavke</a></li>
            <?php if (($ns->getSettingValue('pluginManager',
                  'pluginManager:Enabled') == true) && ($ns->getSettingValue('pluginManager', 'analytics:Enabled'))
            ) {
                echo '<li><a href="analytics.php">Analitika</a></li>';
            }
            ?>
            <li><a href="user.php?id=<?php echo $ns->getSessionUser($_COOKIE['ns_sid']); ?>"><i
                      class="mdi-social-person" style="font-size:18px;"></i> <?php echo $loggedInUser; ?></a>
            </li>
            <li><a href="../login.php?action=logout"><i class="fa fa-sign-out"></i></a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="index.php">Struktura</a></li>
            <li><a href="users.php">Korisnici</a></li>
            <li><a href="design.php">Dizajn</a></li>
            <li><a href="settings-manager.php">Postavke</a></li>
            <?php if (($ns->getSettingValue('pluginManager',
                  'pluginManager:Enabled') == true) && ($ns->getSettingValue('pluginManager', 'analytics:Enabled'))
            ) {
                echo '<li><a href="analytics.php">Analitika</a></li>';
            }
            ?>
            <hr>
            <li><a href="user.php?id=<?php echo $ns->getSessionUser($_COOKIE['ns_sid']); ?>"><i
                      class="mdi-social-person"></i><?php echo $loggedInUser; ?></a></li>
            <li><a href="../login.php?action=logout">Odjava</a></li>

        </ul>
    </div>
</nav>
<!--
<div class="container" style="width: 100%; padding: 0px; margin: 0px;">
  <nav class="navbar navbar-default" style="background-color: #6A92C1; border-radius: 0px; border: none; color: #fefefe !important;" role="navigation">
    <div class="container-fluid" style="color: #fefefe !important;">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php" style="color: #fefefe !important;">Nightsparrow</a>
      </div>


      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="index.php" class="navlink">Struktura</a></li>
          <li><a href="users.php" class="navlink">Korisnici</a></li>
          <li><a href="design.php" class="navlink">Izgled</a></li>
          <li><a href="settings.php" class="navlink">Postavke</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="user.php?id=<?php echo $ns->getSessionUser($_COOKIE['ns_sid']); ?>" class="navlink"><i class="glyphicon glyphicon-user"></i> <?php echo $loggedInUser; ?></a></li>
          <li><a href="../login.php?action=logout" class="navlink" title="Odjava"><i class="glyphicon glyphicon-log-out"></i></a></li>




        </ul>
      </div>
    </div>
  </nav>
-->
<script type="text/javascript"
        src="/template/interface/materialize/js/materialize.min.js"></script>
<script type="text/javascript"
        src="/template/interface/assets/mousetrap.js"></script>
<script>
  $(document).ready(function () {
    $("#keyboardShortcutHelp").hide();
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    <?php
    if($activeApp != 'people'){ ?>
    $('.modal-trigger').leanModal();
    $('select').material_select();
    <?php } ?>
  });
  /**
  $('.appPickerIcon').click(function () {
    $('.appPickerMini').css('display', 'inline-block');
    $('.appPickerMini').css('visibility', 'visible');
    $('.appPickerMini').css('opacity', '1');
  });
  $('.closeAppPickerMiniIcon').click(function () {
    $('.appPickerMini').css('visibility', 'hidden');
    $('.appPickerMini').css('opacity', '0');
  });
   **/
  function toggleElement() {
    var open_btn = $('.appPickerIcon');
    var close_btn = $('.appPickerIconClose');
    var element = $('div.appPickerMini').hide(0);
    var speed = 300;

    open_btn.on('click', function() {
      element.fadeToggle(speed);
    });
    close_btn.on('click', function() {
      element.fadeOut(speed);
    });
  }

  $(document).ready(function() {
    toggleElement();
  });

  $('.userMenuIcon').click(function () {
    $('.userMenu').css('visibility', 'visible');
    $('.userMenu').css('opacity', '1');
    $('div.appPickerMini').hide(0);
  });
  $('.closeUserMenuIcon').click(function () {
    $('.userMenu').css('visibility', 'hidden');
    $('.userMenu').css('opacity', '0');


  });

  var limit = new Date();
  <?php if(!($oblak->settingExists(activeInstance, 'allowDateManipulationForBill'))){
  ?>

  limit.setDate(limit.getDate() - 7);
  <?php
  }
  else{
    ?>
  limit.setDate(limit.getDate() - 365);

  <?php

  }?>

  $('.datepicker').pickadate({
    min: limit,
    close: 'zatvori'

  });

  Mousetrap.bind('alt+r', function(){window.location.href="<?php echo domainpath.activeInstance.'/racuni'; ?>";});
  Mousetrap.bind('alt+d', function(){window.location.href="<?php echo domainpath.activeInstance.'/datoteke'; ?>";});
  Mousetrap.bind('alt+k', function(){window.location.href="<?php echo domainpath.activeInstance.'/kontakti'; ?>";});
  Mousetrap.bind('alt+n', function(){window.location.href="<?php echo domainpath.activeInstance.'/'; ?>";});
  if(window.location.href.includes("datoteke")){
    Mousetrap.bind('n', function(){$("#fileUpload").openModal()});
    Mousetrap.bind('f', function(){$("#newFolder").openModal()});
  }
  else{
    <?php if($activeApp == 'dashboard'){ ?>
    Mousetrap.bind('n', function(){$("#createPost").openModal()});
  <?php } else{ ?>
    Mousetrap.bind('n', function(){window.location.href="<?php echo domainpath.activeInstance.'/'.$activeAppURL.'/novi'; ?>";});
    <?php } ?>
  }
  Mousetrap.bind('?', function(){$("#keyboardShortcutHelp").openModal();});



</script>

<div class="modal" id="keyboardShortcutHelp">
  <div class="modal-content">

    <h5>Aplikacije</h5>
    <hr>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">alt</kbd> + <kbd class="keyboardShortcutKey">r</kbd> računi
    </div>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">alt</kbd> + <kbd class="keyboardShortcutKey">d</kbd> datoteke
    </div>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">alt</kbd> + <kbd class="keyboardShortcutKey">k</kbd> kontakti
    </div>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">alt</kbd> + <kbd class="keyboardShortcutKey">n</kbd> novosti
    </div>

    <h5>Radnje</h5>
    <hr>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">n</kbd> novi objekt unutar aktivne aplikacije (novi račun/ponuda/kontakt/datoteka itd.)
    </div>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">f</kbd> nova mapa (unutar aplikacije Datoteke)
    </div>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">esc</kbd> zatvaranje dijaloga (pa tako i ovog :))
    </div>
    <div class="keyEntry">
      <kbd class="keyboardShortcutKey">?</kbd> otvara ovaj dijalog pomoći
    </div>
  </div>

</div>
<script>
  window.intercomSettings = {
    app_id: "aiq5dr5a",
    name: "<?php echo userFullname; ?>",
    email: "<?php echo $oblak->getEmailFromID(activeInstance, userID); ?>",
    company: {
      id: "<?php echo activeInstance; ?>",
      name: "<?php echo $oblak->getInstanceSetting(activeInstance, 'businessName')['value']; ?>"
    }
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/aiq5dr5a';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>
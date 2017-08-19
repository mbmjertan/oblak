<div class="container">
  <h3>Bok, <?php echo userRealname; ?>.</h3>

  <div class="row">
    <div class="col s3">
      <b>Stvarno ime</b>
    </div>
    <div class="col s9">
      <?php echo userFullname; ?> (<a href="<?php echo domainpath.activeInstance; ?>/kontakti/uredi/<?php echo userID; ?>">promijeni</a>)
    </div>
  </div>

  <div class="row">
    <div class="col s3">
      <b>Korisničko ime</b>
    </div>
    <div class="col s9">
      <?php echo $oblak->getUsernameFromID(activeInstance, userID); ?> (<a href="<?php echo domainpath.activeInstance; ?>/kontakti/uredi/<?php echo userID; ?>">promijeni</a>)
    </div>
  </div>

  <div class="row">
    <div class="col s3">
      <b>E-mail adresa</b>
    </div>
    <div class="col s9">
      <?php echo $oblak->getEmailFromID(activeInstance, userID); ?> (<a href="<?php echo domainpath.activeInstance; ?>/kontakti/uredi/<?php echo userID; ?>">promijeni</a>)
    </div>
  </div>

  <div class="row">
    <div class="col s3">
      <b>Lozinka</b>
    </div>
    <div class="col s9">
      Ne znamo ni mi. (<a href="<?php echo domainpath.activeInstance; ?>/kontakti/uredi/<?php echo userID; ?>">promijeni</a>)
    </div>
  </div>

  <div class="row">
    <div class="col s3">
      <b>Postavke obavijesti</b>
    </div>
    <div class="col s9">
      <form action="<?php echo domainpath.activeInstance;?>/me" method="post">
        <input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
        <div class="input-field">
          <input type="checkbox" name="notificationsForMentions">
          <label for="notificationsForMentions">Želim primiti obavijest kad me netko spomene u objavi u aplikaciji Novosti.</label>
        </div>
        <div class="input-field">
          <input type="checkbox" name="notificationsForAllPosts">
          <label for="notificationsForAllPosts">Želim primiti obavijest kad god netko objavi u aplikaciji Novosti.</label>
        </div>
        <div class="input-field">
          <input type="checkbox" name="notificationsForShares">
          <label for="notificationsForShares">Želim primiti obavijest kad god netko podijeli datoteku ili mapu sa mnom.</label>
        </div>
        <div class="input-field">
          <input type="checkbox" name="notificationsEmailed">
          <label for="notificationsEmailed">Želim primiti kopiju svih obavijesti na e-mail.</label>
        </div>

    </div>
  </div>
</div>
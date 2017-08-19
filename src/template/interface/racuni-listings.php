<div class="container">
  <div class="folderContents">

    <ul class="collection">
      <?php
      $csrfToken = csrfToken;
      $domainpath = domainpath;
      $activeInstance = activeInstance;
      if(!count($bills)){
        $bills[0]['billStatus'] = 'Plaćeno';
        $bills[0]['value'] = 32417;
        $bills[0]['id'] = 0;
        $bills[0]['type'] = 'Račun';
        $bills[0]['billNumber'] = 1;
        $bills[0]['deviceNumber'] = 1;
        $bills[0]['businessAreaNumber'] = 2;
        $bills[0]['buyerName'] = 'Primjer računa. <b>Ovo će nestati kad dodate prvi pravi račun :)</b>';
      }
      foreach ($bills as $bill) {
        switch ($bill['billStatus']) {
        case 'Plaćeno':
          $color = 'green';
          break;
        case 'Ponuda':
          $color = 'grey';
          break;
        case 'Stornirano':
          $color = 'grey darken-4';
          break;
        case 'Poslano':
          $color = 'blue';
          break;
        case 'U izradi':
          $color = 'brown';
          break;
        case 'Neplaćeno':
          $color = 'grey';
          break;
        default:
          $color = 'grey';
          break;
        }
        $bill['value'] = $bill['value'] / 100;
        $bill['value'] = sprintf("%.2f", $bill['value']);
        echo "<li class=\"collection-item avatar\"  data-step='1' data-intro=\"<h2>Popis računa</h2><p>Svi stvoreni računi i ponude nalaze se na ovom popisu, uz pregled osnovnih podataka istih.</p>\"><i class=\"material-icons circle " . $color . "\">receipt</i>";
        if($bill['type'] == 'Račun') {
          echo "<a href=\"{$domainpath}{$activeInstance}/racuni/edit/{$bill['id']}\"><span class=\"title\">{$bill['type']} {$bill['billNumber']}/{$bill['businessAreaNumber']}/{$bill['deviceNumber']}</span></a>";
        }
        else{
          echo "<a href=\"{$domainpath}{$activeInstance}/racuni/edit/{$bill['id']}\"><span class=\"title\">{$bill['type']} {$bill['billNumber']}</span></a>";

        }
        echo "<p>Kupac: {$bill['buyerName']} <br> Iznos (kn): {$bill['value']} <br> <a href='{$domainpath}{$activeInstance}/racuni/novi?copy={$bill['id']}' title='Dupliciraj ovaj dokument za stvaranje sličnog dokumenta' class='billCopy' data-step='2' data-intro=\"<h2>Kopiranje računa</h2><p>Klikom na poveznicu <i>Kopiraj račun</i> možete duplicirati neki od stvorenih računa ili ponuda kako biste što brže izdali sličan račun.</p>\">Kopiraj račun</a> \n <span class=\"secondary-content\"><a href=\"#\" class='dropdown-button' title='Uredi status' data-activates=\"statusbtn-{$bill['id']}\"><i class='material-icons left statusBtnWt' data-step='3' data-intro=\"<h2>Promjena statusa računa</h2><p>Ovdje možete brzo promijeniti status računa između Plaćeno, Neplaćeno, U izradi i Stornirano.</p>\">attach_money</i></a><a href=\"{$domainpath}{$activeInstance}/racuni/exportHTML/{$bill['id']}\"><i class=\"material-icons left\ exportButton\" data-step='4' title='Izvoz dokumenta' data-intro=\"<h2>Izvoz računa</h2><p>Ako trebate ispisati ili spremiti račun lokalno, kliknite ovdje.</p>\">save</i></a><a href=\"{$domainpath}{$activeInstance}/racuni/edit/{$bill['id']}\" title='Uredi'><i class=\"material-icons left editBtn\" data-step='5' data-intro=\"<h2>Uređivanje računa i ponuda</h2><p>Račune i ponude koji su u izradi možete uređivati klikom na ovaj gumb.</p>\">edit</i></a><a href=\"{$domainpath}{$activeInstance}/racuni/delete/{$bill['id']}\"><i class=\"material-icons left deleteBtn\" data-step='6' title='Obriši' data-intro=\"<h2>Brisanje dokumenata</h2><p>Klikom na ikonu kante za smeće možete jednostavno obrisati nefiskalizirane dokumente.</p>\">delete</i></a></span>";
        echo "\n <ul id='statusbtn-{$bill['id']}' class='dropdown-content'><li><a href='{$domainpath}{$activeInstance}/racuni/setStatus/{$bill['id']}/placeno/{$csrfToken}'>Plaćeno</a></li><li><a href='{$domainpath}{$activeInstance}/racuni/setStatus/{$bill['id']}/neplaceno/{$csrfToken}'>Neplaćeno</a></li><li><a href='{$domainpath}{$activeInstance}/racuni/setStatus/{$bill['id']}/stornirano/{$csrfToken}'>Stornirano</a></li></ul>";
        echo "</li>";
      }
      ?>

    </ul>
    <style>.dropdown-content{left:30px!important;}</style>
  </div>
</div>
<?php if( ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'walkthroughsEnabled') == 1) &&  ($oblak->people->getPersonAttributeValue(activeInstance, userID, 'billsWalkthroughEnabled') == 1)) {
  ?>

  <script>

    introJs().setOption("scrollToElement", "true").setOption("nextLabel", "Dalje &rarr;").setOption("prevLabel", "Nazad &rarr;").setOption("doneLabel", "Gotovo!").setOption("skipLabel", "Preskoči uvod").start();
    $(".introjs-overlay").prependTo("html");
    $(".introjs-helperLayer").prependTo("html");
    $(".introjs-tooltipReferenceLayer").prependTo("html");
    $(".introjs-skipbutton").click(function(){
      $(".introjs-overlay").css("display", "none");
      $(".introjs-helperLayer").css("display", "none");
      $(".introjs-tooltipReferenceLayer").css("display", "none");
    });


  </script>
  <?php
      $oblak->people->changePersonAttributeValue(activeInstance,userID,'billsWalkthroughEnabled',0);
    }
  ?>
Aplikacija Kontakti[/title]


Aplikacija Kontakti služi istovremeno kao adresar i lagano upravljanje zaposlenicima i korisnicima, pri čemu su svi korisnici instance nužno članovi grupe Zaposlenici.
  
## Popis kontakata i grupa

Po otvaranju aplikacije prikazuje se popis kontakata i s njemu lijeve strane popis grupa i broj njihovih članova.

Uz svaki kontakt prikazuje se e-mail i telefon ako su dostupni.

## Dodavanje kontakata

![Nepopunjen obrazac za dodavanje kontakta kakav se otvara klikom na Dodaj u navigaciji](https://oblak.mbmjertan.co/public/educateam/file/b51a6f9ed399086c614d42b335c78dbfb2049d0ea159d8fbda5c2fd2d3e323a8)

Formular za dodavanje kontakata sastoji se od polja *Ime, Prezime, Grupe* i tablice *Polje-Vrijednost* za vrijednosti kontakta. Moguće je stvoriti korisnički račun označavanjem *checkboxa* naziva *Ova osoba je zaposlenik tvrtke. Stvori joj korisnički račun.*

Nakon što korisnik upiše minimalno 2 znaka u polje *Grupe*, Poslovni oblak će prikazati prijedloge postojećih grupa iz popisa grupa.

Korisnik može biti član više grupa, a grupe na popisu trebaju biti odvojene zarezom i razmakom.

U tablici polja kontakta potrebno je izabrati polje i unijeti njegovu vrijednost. U dropdown izborniku *Polje…* prikazat će se sva dostupna polja (ona pružena od strane sustava i ona korisnička).

U Poslovnom oblaku su od strane sustava definirana ova polja:


![Polja kontakta definirana od strane sustava prikazana u dropdown izborniku](https://oblak.mbmjertan.co/public/educateam/file/68e3d8eea59d5c6c55ac060b36e87ad94a2c7cc67884ab855523c0de553ba46d)

Korisnik može klikom na *Novo polje…* definirati vlastito polje, pri čemu će ga sustav tražiti za ime polja i kratku oznaku. Ime polja je ljudima čitljivo ime (primjerice, *Državljanstvo*), dok je kratka oznaka alfanumerički identifikator tog polja pisan malim slovima (dakle, *drzavljanstvo*).

Klikom na gumb *Dodaj polje* korisnik može pridružiti još polja kontaktu pri čemu se redovi u tablici dupliciraju kao što je bio slučaj i u aplikaciji Računi.

<a id="dodavanje"></a>

U slučaju da korisnik želi otvoriti korisnički račun kontaktu, može označiti checkbox *Ova osoba je zaposlenik tvrtke. Stvori joj korisnički račun.* pri čemu će korisniku prikazati dodatna dva polja za korisničko ime i lozinku.
 
![Polja za stvaranje korisnika prilikom dodavanja kontakta](https://oblak.mbmjertan.co/public/educateam/file/01640720cf707492e0bf656c2ea34f3baa90b9432488da1edf05cb9111ee9b59)

Ako već nije, kontaktu će se po odabiru tog checkboxa pridružiti grupa Zaposlenici te će se ispod polja lozinka prikazati prijedlog lozinke kao što se prikazuje i kod registracije. Po ustaljenom principu, administrator treba podatke za prijavu prenijeti korisniku. 

Klikom na *Dodaj kontakt* stvorit će se kontakt i po potrebi grupe, polja i korisnički račun.

Ako je zadano otvaranje korisničkog računa kontaktu, zadani kontakt će primiti ovakav e-mail:

![E-mail obavijest o novom korisničkom računu](https://oblak.mbmjertan.co/public/educateam/file/b5802124e1b58b775eb57ce06e74b6a895930e0ca9d7101b2b4c7d4f0d1819db)

Kontakt se tada može prijaviti putem poveznice koristeći korisničko ime i lozinku koje mu je isporučio administrator instance, a koje je zadao prilikom postavljanja korisničkog računa.

<div class="card-panel blue-grey darken-2 white-text">Imajte na umu: ako otvarate korisnički račun nekomu, morate zadate e-mail adresu. Nadalje, korisnik će se moći prijaviti samo s korisničkim imenom i lozinkom koje Vi postavite, stoga te podatke trebate isporučiti korisniku.</div>


## Pregledavanje kontakata
Klikom na ime kontakta otvara se stranica za pregled kontakta. Na stranici se prikazuju sva članstva grupa, sva polja kontakta i podatak o korisničkom računu.

Klikom na e-mail otvorit će se zadani e-mail klijent s namjerom sastavljanja e-maila na kliknutu adresu, a klikom na broj telefona taj broj će se pozvati zadanom aplikacijom za pozive (na Androidu *Dialler*, na iOS-u *Phone*, a na računalima uglavnom *Skype* ili *FaceTime*).

Klikom na ikonu kante za smeće, otvorit će se stranica za brisanje kontakta uz upozorenje da će se obrisati i korisnički račun ako postoji.



## Grupe
Na popisu kontakata s lijeve strane nalazi se popis grupa i broj njihovih članova, a klikom na ime grupe na popisu grupa ili u pregledu kontakta, otvorit će se popis kontakata koji su članovi grupe, a grupa koju korisnik pregledava postat će boldana i premjestiti se na vrh popisa.


Grupe nije moguće brisati jer nema poantu, s obzirom na činjenicu da se na popisima prikazuju samo grupe koje imaju članova, stoga grupe automatski nestaju kad prestanu biti važne.

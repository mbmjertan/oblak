Aplikacija Računi[/title]

## Navođenje kroz aplikaciju

Zbog činjenice da je aplikaciju Računi izuzetno bitno znati koristiti, Poslovni oblak će pri prvom korištenju prikazati korisniku upute za svaku radnju koju je moguće izvesti s pregleda računa.

Ako već postoje računi stvoreni unutar aplikacije, Poslovni oblak će za primjere koristiti neki od stvarnih računa, no ako ne postoje, generirat će primjer koji će nestati po dodavanju prvog stvarnog računa.


![Primjer navođenja](https://oblak.mbmjertan.co/public/educateam/file/858061d434ac00e0ca2772ee3b973a1e5691d3767e057656d6eedfab39493f04)

U slučaju da ne postoje računi, Poslovni oblak će prikazati ovaj primjer:

![Primjer računa korišten prilikom navođenja ako ne postoje računi u sustavu](https://oblak.mbmjertan.co/public/educateam/file/66c26450aafe924c37b50e2b2cca349275a27088feb7aa2967d7b79ac969088d)

Moguće je kliknuti na opcije na računu, ali pojavit će se obavijest kako se radi o primjeru kojeg nije moguće uređivati. 

Prelaskom mišem (hoverom) preko ikona u Poslovnom oblaku prikazat će se objašnjenje svake ikone (tooltip) kako bi i kasnije korištenje bilo jednostavno.

## Popis računa i ponuda
Po otvaranju aplikacije Računi, Poslovni oblak prikazat će popis spremljenih računa i ponuda.


![Popis računa i ponuda](https://oblak.mbmjertan.co/public/educateam/file/76d2cd05e7a84182cc6d77b92d38b122baa18179b31438f4b1e6b5ead509bc8f)

Na popisu moguće je vidjeti status računa/ponude, broj, kupca, iznos te promijeniti status računa, urediti račun/ponudu (ako nije izdana), obrisati račun/ponudu ili izvesti (ispisati odnosno spremiti).

## Statusi računa i ponuda

Računi i ponude na popisu označeni su ikonama kako bi vizualno se lakše raspoznavali, a boje statusa su navedene ispod.

* **Sivom** ikonom označeni su neplaćeni računi/ponude.
* **Zelenom** ikonom označeni su plaćeni računi/ponude.
* **Crnom** ikonom označeni su stornirani računi/ponude.
* **Smeđom** ikonom označeni su računi/ponude koji su još u izradi.

### Brze promjene statusa računa/ponuda
Klikom na ikonu na popisu računa otvara se izbornik za brzo mijenjanje statusa računa iz kojega je moguće promijeniti status računa u Plaćeno, Neplaćeno i Stornirano. 

Budući da se izdani računi ne mogu uređivati, ovo je jedini način za promjenu statusa izdanog računa.  

![Izbornik za promjenu statusa računa/ponude](https://oblak.mbmjertan.co/public/educateam/file/41819ed3efc4a85662098d40e851ea558c12f8ced151aff1cb6d4f64b49eeb8b)

U slučaju da korisnik pokuša ručno manipulirati zahtjevom kako bi promijenio status u neki koji nije ponuđen u izborniku (primjerice, u status *U izradi* kako bi izmjene bile dozvoljene), prikazat će se poruka pogreške i status računa neće biti promijenjen.

## Dodavanje računa
Klikom na gumb *Dodaj* otvara se alat za dodavanje i uređivanje računa. Nepopunjen obrazac novog računa nalazi se prikazan na slici ispod.

![Dodavanje računa](https://oblak.mbmjertan.co/public/educateam/file/52d7299a15e53f799b0fef9666d6bfd3a1ef8ef665266e36bfc079c46985c16b)

Polja *Broj računa* (odnosno *Broj ponude* ako se radi o ponudi), *Broj poslovnog prostora, Broj naplatnog uređaja* i *Podnožje* nasljeđuju se od prethodnog računa/ponude, dok se polja *IBAN, Web, Telefon, Email* čitaju iz konfiguracije instance. Polje poziv na broj generira se iz podataka računa [po definiranom predlošku poziva na broj](/pomoc/predlozak-pnb).

Obrazac za dodavanje računa sličnog je izgleda kao i pravi račun, stoga se u vrhu prikazuje logotip, naziv i adresa tvrtke.

Zadani status računa je *Neplaćeno*, no moguće ga je promijeniti odmah u *U izradi, Plaćeno, Neplaćeno* te *Stornirano*.

Promjenom vrste dokumenta iz računa u ponudu sakrit će se polja *Broj poslovnog prostora* i *Broj ponude*, budući da to nisu obvezni elementi ponude, a polje *Broj računa* bit će zamijenjeno poljem *Broj ponude* (naravno, ispunjeno odgovarajućim brojem).

Datum i vrijeme izdavanja se ne mogu mijenjati te su uvijek jednaki vremenu spremanja.

Za polja Rok plaćanja, Datum isporuke i Datum isteka otvorit će se dijalog za odabir datuma:

U dijalogu za izbor datuma moguće je izabrati datum do 7 dana u prošlosti. Nema ograničenja na datume u budućnosti.

<div class="card-panel blue-text text-darken-2">U slučaju opravdane potrebe, moguće je postaviti konfiguracijsku vrijednost <i>allowDateManipulationForBill</i> te omogućiti odabir datuma do 365 dana u prošlosti. Kontaktirajte podršku za više informacija.</div>

Tablica stavaka računa/ponude sastoji se od polja *Redni broj* (automatski generirano), *Opis, Jedinica, Količina, Cijena, Popust (%), Popust (iznos)* (automatski generirano) i *Iznos* (automatski generirano).

Polje *Popust (iznos)* računa se kao ukupni iznos popusta na osnovice stavke, odnosno:

<img src="https://oblak.mbmjertan.co/public/educateam/file/4a5f8d26d74a3a48d5c1803b738008b861b8f5858b596ce9dcc4f5e1165b305d" style="height:52px;">

Iznos je ukupan iznos plaćanja, dakle: 

<img src="https://oblak.mbmjertan.co/public/educateam/file/1b7dc282ca903e6be823d1f2bd9d86f800a8a9c8d36818f4f17c9b7c687c774b
" style="height:32px;">


Klikom na *Dodaj stavku* dodat će se novi red na dno tablice stavaka s istim vrijednostima svih polja (osim polja Redni broj), duplicirajući prethodni red.

Polja *Ukupan iznos računa* i *Iznos popusta* po računu automatski su generirana iz iznosa stavaka računa/ponude i polja *Popust po računu (%)*.


*Ukupan iznos računa* je iznos kojeg kupac treba platiti (dakle, zbroj svih iznosa stavaka – iznos popusta po računu), pri čemu je *Popust po računu (%)* popust na *subtotal* odnosno zbroj iznosa stavaka računa.


Klikom na gumb *Spremi*, račun/ponuda će se spremiti. 

<div class="card-panel blue-text text-darken-2">Imajte na umu da račune i ponude spremljene s bilo kojim statusom osim <i>U izradi</i> neće biti moguće uređivati.</div>

## Uređivanje računa
Klikom na naslov računa na popisu ili na ikonu otvorit će se alat za uređivanje računa. Ako je račun/ponuda spremljen(a) sa statusom *U izradi*, izgledat će identično alatu za dodavanje novog računa/ponude već popunjenom podacima računa/ponude, a ako račun/ponudu nije moguće uređivati, bit će otvoren samo za pregled, no izmjene se neće moći spremiti.

Na vrhu računa/ponude kojeg nije moguće urediti prikazuje se obavijest o nemogućnosti uređivanja:


![Obavijest o nemogućnosti uređivanja na vrhu računa ili ponude](https://oblak.mbmjertan.co/public/educateam/file/0495cbf2b93d77ff6702d5f7968f1aa2d3b1037e12fd71cb4a6a2ecbed7ee88f)

Na dnu računa će se također pokazati obavijest o nemogućnosti uređivanja:

![Obavijest o nemogućnosti uređivanja na dnu računa ili ponude](https://oblak.mbmjertan.co/public/educateam/file/0de07f1b4b0e414813784c20b670355f91369ead941bcbff26a977e49b8cc948)


U slučaju da se zahtjevom prema poslužitelju proba ručno manipulirati, prikazat će se ova poruka pogreške:

![Poruka pogrešku u slučaju ručne manipulacije zahtjevom prema serveru radi uređivanja računa](https://oblak.mbmjertan.co/public/educateam/file/34459396b32b7cc9b60622eb2da414b525ddc45449ca5ed444078a714d494007)

Ako korisnik pak pokuša vratiti status u *U izradi* nakon izdavanja računa manipulacijom zahtjeva, prikazat će se ova poruka greške:

![Obavijest u slučaju ručne manipulacije zahtjevom kako bi se status računa vratio u U izradi kako bi izmjene bile dopuštene](https://oblak.mbmjertan.co/public/educateam/file/289111e452f85b7cce155156a32525b29c1b0d720de4a8fe0a667430987f72bc)


## Brisanje računa i ponuda
Klikom na ikonu kante za smeće na popisu računa i ponuda moguće je obrisati račun/ponudu, pri čemu se otvara stranica za potvrdu uz obavijest o pravnim aspektima radnje.


Po brisanju se pokazuje obavijest o uspješnom brisanju iznad popisa računa.


## Kopiranje računa

Klikom na poveznicu *Kopiraj račun* ispod sažetka računa otvorit će se stranica za dodavanje novog računa/ponude (dakle, s novim brojem) i istim podacima kako bi se olakšalo dodavanje sličnih računa. U polje *Napomene* bit će dodano *Veza dokument: Račun X/Y/Z* odnosno *Veza dokument: Ponuda X*, no korisnik taj tekst po želji može ukloniti.

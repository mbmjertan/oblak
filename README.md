![Oblak](https://oblak.mbmjertan.co/template/icons/oblakLogoLight.png =250x250)

[Izvorni kod](https://github.com/iwebhub/oblak/tree/master/src) | [Dokumentacija za programere](https://github.com/iwebhub/oblak/tree/master/docs)

Oblak je paket cloud SaaS aplikacija za male poduzetnike.

## Što Oblak olakšava?

### Komunikacija unutar tvrtke

Kad trebaš podijeliti nešto sa svima, email je naporan. _Jako_ naporan. Zato su tu Novosti, jednostavan alat Poslovnog oblaka za dijeljenje unutar organizacije.

![Evo kako Novosti izgledaju.](https://oblak.mbmjertan.co/public/educateam/file/619be02519f340e144b88dfec7468c8eebd57345781356486ab5d412fe4fa033)

### Upravljanje kontaktima i kadrovima

Grozan je osjećaj kad moraš napisati korisniku email ili ga nazvati, a nemaš nikakve kontakt informacije. Jedino ih ima Josip, a on je na godišnjem. Aplikacija Kontakti će ti olakšati upravljanje kontaktima i osnovno kadroviranje tako da nikad neće biti brige oko toga _gdje_ su korisnikovi kontakt podaci.

![Kontakti izgledaju dobro, moraš priznati.](https://oblak.mbmjertan.co/public/educateam/file/b51a6f9ed399086c614d42b335c78dbfb2049d0ea159d8fbda5c2fd2d3e323a8)

### Dijeljenje datoteka

Dropbox je sto puta bolji, ali tvoj šef ga ne želi koristiti. Zato su tu Datoteke, aplikacija koja će ti olakšati dijeljenje i upravljanje datotekama.

![Datoteke nisu baš kul aplikacija, ali je korisna za backend.](https://oblak.mbmjertan.co/public/educateam/file/a8d2e680636a6f39e0c37295d23c738c691256a3db1656c4b2d4c61ab413f230)

### Izradu računa i ponuda

Alati za računovodstvo iz nekog čudnog razloga uglavnom izgledaju kao da su zapeli u devedesetima -- moraš ~~nazvati~~ pristisnuti P radi popusta na svakom artiklu, teško ih je konfigurirati i grozno je naporno pretraživati ih. Oblakova aplikacija Računi tu uskače: konačno, imaš moderan alat za račune i ponude.

![Računi](https://oblak.mbmjertan.co/public/educateam/file/76d2cd05e7a84182cc6d77b92d38b122baa18179b31438f4b1e6b5ead509bc8f)

![Upozorenje](https://oblak.mbmjertan.co/public/educateam/file/44f9889611d4101981bf043a788c5c90badf5eb2d7347801cd8e6dab94e7e62f)

Bitno je znati da Oblak nije production-ready za korištenje u računovodstvu -- taj dio je još u razvoju. 

Iako je možda savršen za tvoje potrebe, neke stvari se možda polome, a neke možda uopće ne budu radile -- stoga, iako možeš, bolje je da ne koristiš Oblak za račune. Ako se nešto loše dogodi, zapali ili softver ne bude ispravan/po standardima, nismo krivi.

## Zašto je Oblak bolji od sličnih rješenja?

* **Radi svugdje.** Gdje god te put odveo, ako imaš mobitel ili laptop s internetom: imaš Oblak.
* **Ne moraš se učiti.** Sve radi kako očekuješ -- funkcije nisu skrivene ili zbunjujuće, a moderan dizajn ti olakšava snalaženje.
* **Brz je.** Oblak _leti_.
* **Otvoren je i besplatan.** Oblak možeš koristiti besplatno -- bez sitnih slova i skrivenih troškova za tvoju tvrtku.
* **Podržava emoji.** Ovo je uvjerljivo najbolja mogućnost Oblaka.

## Što trebam za korištenje Oblaka?

Ne previše :)

Ne pružamo aktivan hosting za Oblak u ovom trenutku, tako da ćeš ga morati sam(a) hostati. Bez brige, nije teško.

Trebaš server (shared hosting možda radi, PaaS upitno, VPS pouzdano) na kojem će se vrtiti:

* neka Linux distribucija (CentOS i Ubuntu pouzdano izvrsno rade)
* nginx (iako i Apache radi dobro, ali nginx daje bolje performanse)
* PHP 7
* MariaDB
* OpenSSL i PHP ekstenzija za OpenSSL
* git

Kad to osiguraš, pročitaj upute za instalaciju. Bez brige, brzo je i ne boli previše. :)

Za pristup Oblaku trebaš samo razumno nov web preglednik i relativno nov operativni sustav. 

(Svaki Windows noviji od XP-a bi trebao raditi, kao i svaki Android noviji od Androida 3. Svaki razumno nov macOS i Linux gotovo sigurno radi.)

## Kako je Oblak nastao?

Oblak je nastao kao projekt za [Državno natjecanje iz informatike](http://infokup.hr) pod imenom _Poslovni oblak_. Budući da je u ovom trenutku prezahtjevno održavati ga, otvaram ga javnosti. Da ga svi koriste. Besplatno, zauvijek.

## Gdje da postavim pitanja?

Ovdje kao Issue ili meni direktno: na marioborna@mbmjertan.co

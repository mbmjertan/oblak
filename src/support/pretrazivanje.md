Pretraga u Poslovnom oblaku[/title]

Objekte unutar Poslovnog oblaka moguće je pretraživati za upit klikom na ikonu povećala u navigacijskoj traci. 

Klikom na povećalo otvara se stranica za pretraživanje s poljem za upit, a klikom na Pretraži, sustav će pretražiti sve objekte za spomen upita.

## Opseg pretraživanja

Bez parametara za napredno pretraživanje, Poslovni oblak će za upit pretražiti i redom prikazati:

1.	imena kontakata
2.	mape i datoteke
3.	račune i ponude
4.	stavke računa i ponuda
5.	grupe kontakata
6.	sadržaj objava i komentara u aplikaciji Novosti

## Napredno pretraživanje

Operatorima za napredno pretraživanje moguće je proširiti ili suziti opseg pretraživanja.

### Wildcard operatori

Moguće je koristiti % i \_ wildcard operatore pri čemu % označava bilo koji broj znakova (pa i 0), a \_ označava nužno jedan znak.

### Parametar pretraživanja po kategoriji

Dodavanjem `searchIn:vrijednost` parametra na početak upita moguće je suziti pretragu na određenu kategoriju. Parametri se međusobno i od ostatka upita odvajaju razmakom.

Moguće vrijednosti parametra su `people, files, bills, billItems, groups, peopleMetadata` za imena kontakata, mape i datoteke, račune i ponude, stavke računa i ponuda, grupe kontakata i sadržaj objava i komentara u aplikaciji Novosti **redom**. 

Dakle, da biste pretražili samo stavke računa, potrebno je na početak upita dodati `searchIn:billItems`

### Parametar vrste za pretraživanje unutar aplikacije Računi
Dodavanjem `type:vrijednost` parametra poslije `searchIn:bills` parametra moguće je pretražiti samo račune ili samo ponude. Moguće vrijednosti parametra su Račun i Ponuda.

Dakle, da biste pretražili samo račune za upit, potrebno je na njegov početak dodati `searchIn:billItems type:Račun`.

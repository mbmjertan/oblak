# Sitesettings

Sitesettings tablica svake instance služi spremanju konfiguracije instance. Ovdje se nalazi popis svih mogućih postavki i njihovih vrijednosti. Za uređivanje trebaš zaroniti u SQL, nažalost.

## businessCountry

Država poslovanja. Moguće/podržane vrijednosti:  `HR`

## appLanguage

Jezik aplikacije. Moguće/podržane vrijednosti: `HR`

## startBillsFromNumber/vrsta/godina

Početni broj računovodstvenog dokumenta za određenu godinu. Nije pretjerano korisna opcija s obzirom na strukturu aplikacije Računi.

Moguće/podržane oznake vrste: `racun`, `ponuda`.

Primjer: `startBillsFromNumber/racun/2017`.

Moguće/podržane vrijednosti: bilo koji pozitivni `int`

## businessCallNumberTemplate

Predložak poziva na broj.

Moguće/podržane vrijednosti: bilo koji string, ali treba imati neki od elemenata koji su jedinstveni.

Mogući parametri: `GGGG` za oznaku godine, `MM` za oznaku mjeseca, `DD` za oznaku dana, `B` za broj računovodstvenog dokumenta, `P` za oznaku poslovnog prostora, `U` za oznaku naplatnog uređaja. 

Primjer vrijednosti: `GGGGMMDD-BPU`

## billDefaultDeviceNumber

Zadani broj naplatnog uređaja. Nije pretjerano korisna opcija s obzirom na strukturu aplikacije Računi.

Moguće/podržane vrijednosti: bilo koji pozitivni `int`

## billFootnotes

Podnožje računa. Nije pretjerano korisna opcija s obzirom na strukturu aplikacije Računi.

Moguće/podržane vrijednosti: bilo koji `string`

## businessName

Ime tvrtke.

Moguće/podržane vrijednosti: bilo koji `string`

## businessType

Vrsta tvrtke.

Moguće/podržane vrijednosti: bilo koji `string`, ali u principu `d.o.o.`, `d.d.`, `k.d.`, `j.d.o.o.` itd.

## businessMainAddress

Puna adresa tvrtke, uključujući i grad.

Moguće/podržane vrijednosti: bilo koji `string`

## businessMainPostcode

Poštanski broj tvrtke.

Moguće/podržane vrijednosti: bilo koji `string`

## businessMainCity

Grad u kojem je sjedište tvrtke.

Moguće/podržane vrijednosti: bilo koji `string`

## businessWeb

Web tvrtke.

Moguće/podržane vrijednosti: bilo koji `string` (URL)

## businessPhone

Telefonski broj tvrtke.

Moguće/podržane vrijednosti: bilo koji `string` (telefon)

## businessMail

Email tvrtke, za korisnike.

Moguće/podržane vrijednosti: bilo koji `string`


## businessMainIBAN

IBAN tvrtke.

Moguće/podržane vrijednosti: bilo koji `string`

## logoFileID

ID datoteke u aplikaciji Datoteke koja predstavlja logotip.

Moguće/podržane vrijednosti: bilo koji `int` koji ima korenspondirajuću slikovnu datoteku povezanu sa sobom u aplikaciji Datoteke

## businessVATRateType

Stopa PDV-a za tvrtku.

Moguće/podržane vrijednosti: `NoVAT`

## allowDateManipulationForBill

Ako je false (0), dozvoljava rokove do 7 dana u prošlosti. Ako je true (1), dozvoljava rokove do 365 dana u prošlosti.

Moguće/podržane vrijednosti: `1`, `0`

## billShowOIBInBillHeader

Ako je true(1), prikazuje OIB u zaglavlju računa.

Moguće/podržane vrijednosti: `1`, `0`


## businessOIB

OIB tvrtke. Mora biti postavljeno ako je `billShowOIBInBillHeader` postavka postavljena na true.

Moguće/podržane vrijednosti: `int(11)`

(Vodeće nule su podržane.)

## billTableLayout

Upravlja dizajnom tablice za račune. Ako je postavljeno s vrijednošću `bigDescrip`, polje `Opis` na računima će se proširiti da bude najšire.

Moguće/podržane vrijednosti: `bigDescrip`, `null`



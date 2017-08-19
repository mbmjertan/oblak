Konfiguracijska postavka 'Predložak poziva na broj'[/title]

Bitna postavka je *Predložak poziva na broj* koji određuje kako se poziv na broj na računima i ponudama generira, a koja nije nikad eksplicitno zatražena za unos od strane korisnika, već se zadano koristi format `GGGGMMDD-BPU` odnosno četveroznamenkasti zapis godine, dvoznamenkasti zapis mjeseca, dvoznamenkasti zapis dana, crtica, broj računa/ponude, broj poslovnog prostora, broj uređaja.

Općenito, kod poziva na broj su trenutno dostupni `GGGG`, `MM`, `DD`, `B`, `P` i `U` parametri, a mogu biti odvojeni bilo kojim standardom dozvoljenim znakom<sup><a href="#footnote-1">1</a></sup> te poredani bilo kako.

Parametar|Opis|Primjer vrijednosti
---------|----|--------------------
GGGG|Četveroznamenkasti zapis godine računa/ponude prilikom generiranja|2017
MM|Dvoznamenkasti zapis mjeseca računa/ponude prilikom generiranja|01
DD|Dvoznamenkasti zapis dana računa/ponude prilikom generiranja|26
B|Broj računa/ponude prilikom generiranja|127
P|Broj poslovnog prostora prilikom generiranja|2
U|Broj naplatnog uređaja prilikom generiranja|1

## Bilješke

<a id="footnote-1"></a>
**1:** Fina, Jedinstveni pregled osnovih modela "poziva na broj", s opisom modela, sadržajem i objašnjenjem za njihovu primjenu te načinom, izračuna kontrolnog broja, 6. 6. 2016., dostupno na Erste Mirror, [link](http://local.erstebank.hr/netBankingSupport/dokumenti/pregledModelaPlacanja.pdf)

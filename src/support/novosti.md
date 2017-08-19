Aplikacija Novosti[/title]

Po prijavi, korisniku se otvara aplikacija Novosti namijenjena dijeljenju informacija između zaposlenika tvrtke. Novosti rade na načelu *news feeda* na kojemu se objave (postovi) mogu označiti sa sviđa mi se i komentirati. 

![Novosti](https://oblak.mbmjertan.co/public/educateam/file/d491eb61b70bf71cc25371f800ba7b948a54eeb20acc1e9c405721a73f7871c2)

Ispod svakog posta se na njegovoj kartici nalaze komentari označeni sivom bojom i plavim rubom, a uz svaki post i komentar piše relativno vrijeme njegove objave.

Prva objava je uvijek ova, objavljena od strane administratora koji je pokrenuo instancu:

![Kartica Novosti s dobrodošlicom](https://oblak.mbmjertan.co/public/educateam/file/ca561a9645025ce183123accef8caa43f62c7157b167f5dafc03a3fb838c2bba)

## Dodavanje objava

Klikom na gumb *Dodaj objavu* korisnik može objaviti novi post putem prikazanog obrasca:


![Dodavanje objave](https://oblak.mbmjertan.co/public/educateam/file/619be02519f340e144b88dfec7468c8eebd57345781356486ab5d412fe4fa033)

Sve poveznice unutar objave bit će automatski adaptirane u HTML hiperveze. Nakon uspješnog dodavanja, vaša objava prikazat će se na vrhu *feeda*.

## Označavanje objava sa *Sviđa mi se*

Korisnik može jednim klikom na gumb *Sviđa mi se (n)* označiti objavu sa Sviđa mi se. Obavijest o uspjehu se ne prikazuje, već se broj *n* u zagradi uz gumb poveća za 1.

## Komentiranje objava

Unošenjem komentara u polje na dnu kartice i klikom na gumb Dodaj komentar korisnik može ostaviti komentar na objavu. 

## Trajne veze na objave

Budući je ponekad problem pronaći stariju objavu na feedu i podijeliti je, moguće je pristupiti objavi pojedinačno preko trajne veze (permalinka). Klikom na poveznicu Trajna veza (vrijeme) otvorit će se individualna objava odakle korisnik može iz adresne trake kopirati trajnu vezu.

## Ograničenja

Maksimalna duljina objava i komentara je 2<sup>16</sup>-1, odnosno 65535. Ograničenja na broj komentara, oznaka sviđa mi se, vremenska ograničenja ili bilo kakva druga ograničenja ne postoje.

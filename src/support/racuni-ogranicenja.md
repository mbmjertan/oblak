Ograničenja aplikacije Računi[/title]

## Zašto Poslovni oblak ne podržava fiskalizaciju u prometu gotovinom?

Fiskalizacija u prometu gotovinom stiže uskoro u Poslovni oblak :) Nismo stigli ugraditi podršku za gotovinske fiskalne račune u aplikaciju Računi, ali nastojat ćemo ugraditi ju što prije.
<div class="card-panel blue-text text-darken-2">Gotovinski fiskalni računi su računi koji sadrže JIR i ZKI parametre, a za koje se kolokvijalno kaže da ih izdaje fiskalna blagajna.</div>

## Zašto Poslovni oblak ne podržava e-račune?

Ponajviše, iz razloga što se ne slažemo sa stavovima autora zakona oko e-računa. E-računi su izuzetno jednostavni za implementirati, no troškovi uvođenja njih za poduzetnike su izuzetno veliki, a kazne za čak male pogreške u korištenju e-računa su ogromne, dok je pravni aspekt njih izuzetno zamršen. Vjerujemo kako e-računi zbog toga jednostavno nisu primjereni za male poduzetnike i da bi ugrađivanje njih u Poslovni oblak bilo opasno za male poduzetnike koji nisu upoznati sa zakonom, što je suprotno od onog što želimo postići s Poslovnim oblakom. 

## Zašto Poslovni oblak ne podržava obveznike poreza na dodanu vrijednost (PDV-a)?

Radimo na tome i podrška za porezne obveznike stiže uskoro :)

## Zašto Poslovni oblak ne podržava račune na jeziku osim hrvatskog i valute osim HRK?

Stiže vrlo brzo :)

## Zašto Poslovni oblak ne podržava nešto drugo što mi je potrebno?

Najvjerojatnije još nismo stigli, no javite nam se na <b><a href="mailto:email@example.com">email@example.com</a></b> ili putem poveznice s kraja ovog članka i pokušat ćemo ugraditi funkcionalnost koja vam je potrebna.

## Koja su tehnička ograničenja aplikacije Računi?
Ograničenja u smislu broja stavaka na računu ili ponudi te broja izdanih računa ili ponuda ne postoje. 

Polje *Količina* ima preciznost ograničenu na 15 decimalnih i 15 cjelobrojnih mjesta (dakle, najveća moguća količina neke stavke je približno 10<sup>16</sup>), a iznosi su ograničeni na 10<sup>9</sup> kunskih mjesta, dok je duljina naziva stavke na računu ili ponudi ograničena je na 2<sup>16</sup>-1 znakova, što velika većina poduzetnika neće prijeći u svakodnevnom korištenju. 

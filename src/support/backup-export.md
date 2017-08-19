Preuzimanje sigurnosne kopije i izvoz podataka[/title]

Klikom na gumb *Napravi sigurnosnu kopiju* u administraciji instance, Poslovni oblak će generirati i započeti preuzimanje ZIP arhive svih datoteka unutar sustava i izvoza baze podataka.

Datoteke su preimenovane i kod sigurnosnog kopiranja se gubi struktura direktorija radi lakšeg uvoza. U datoteci *databaseExport* nalazi se baza podataka instance u posebnom formatu izvoza. Izvoz se sastoji od serijaliziranog arraya JSON objekata generiranih za svaku tablicu baze podataka.

Osjetljivi podaci oko konfiguracije servera zamijenjeni su generaliziranim vrijednostima, pa je tako, primjerice, putanja do skladišta datoteka zamijenjena sa *serverRDP*.


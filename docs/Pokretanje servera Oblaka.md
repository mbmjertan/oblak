# Pokretanje Oblak servera

Ovo će biti zahtjevno ako nemaš iskustva sa sistem administracijom ili programiranjem (ili programiranjem i sistem adminstracijom na Linuxu). Ako je to slučaj, slobodno otvori novi Issue ovdje na GitHubu i pitaj što god ti je nejasno.

Prije nego što pokreneš svoj prvi Oblak server, moraš ispuniti tehničke uvjete. 

## Tehnički uvjeti

Trebaš server (shared hosting možda radi, PaaS upitno, VPS pouzdano) na kojem će se vrtiti:

* neka Linux distribucija (CentOS i Ubuntu pouzdano izvrsno rade)
* nginx (iako i Apache radi dobro, ali nginx daje bolje performanse)
* PHP 7
* MariaDB
* OpenSSL i PHP ekstenzija za OpenSSL
* git

Kad to osiguraš, možemo krenuti dalje.

## Dohvaćanje izvornog koda i osiguravanje strukture datoteka

Moraš dohvatiti izvorni kod iz ovog repozitorija. Najlakši i najbolji način je da to učiniš preko gita.

Lociraj se u direktorij u kojemu želiš da se Oblak nalazi. Kad kloniraš repozitorij preko gita, git će stvoriti novu mapu oblak u kojoj će se nalaziti ovaj repozitorij. U mapi oblak/src će se nalaziti izvorni kod Oblaka.

Unutar mape oblak, trebat ćeš otvoriti novu mapu OblakUploads kako bi prenošenje datoteka funkcioniralo. Chmod-om i chown-om postavi privilegije tako da web server i PHP mogu pristupiti toj mapi, ali ostali korisnici ne.

```shell
cd /var/www/sites/oblak-server.firma.hr       # Folder u kojeg ulaziš ti biraš po želji. Ovo je samo naš primjer.
git clone https://github.com/iwebhub/oblak.git 
cd oblak
mkdir OblakUploads
```

### Stvaranje baze podataka

Napravi novu bazu podataka, naziva po želji. Kolacija **mora** biti ''utf8mb4_unicode_ci''.

Unutar te baze podataka, pokreni ovaj kod:


```sql
CREATE TABLE `globalConfig` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `globalConfig` (`id`, `name`, `value`) VALUES
(1, 'VATRates/Default', '25'),
(2, 'VATRates/NoVAT', '0');


CREATE TABLE `instances` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `callsign` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customBaseDomain` tinyint(1) DEFAULT '0',
  `baseDomain` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primaryContactEmail` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primaryContactPhoneNumber` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `databasePrefix` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondaryContactEmail` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondaryContactPhoneNumber` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `queue` (
  `id` int(11) UNSIGNED NOT NULL,
  `instance` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nodeType` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nodeID` int(11) DEFAULT NULL,
  `awaitingAction` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `globalConfig`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `instances`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `globalConfig`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

ALTER TABLE `instances`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;

ALTER TABLE `queue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
```

Kad je to gotovo, dodaj novog korisnika toj bazi podataka (nemoj mu dodijeliti serverske privilegije iz sigurnosnih razloga, ali daj mu sve privilegije nad bazom).

### Konfiguriraj web server

Sad trebaš postaviti web server. U ovom vodiču koristimo nginx, ali i Apache će raditi. Čak ima i htaccess primjer u ovom sourceu :)

Preskačemo dio konfiguriranja web servera za PHP: tih vodiča ima hrpa na internetu i svi su bolji i ažurniji nego da pišemo ovdje. Ovdje ćemo samo objasniti što trebaš promijeniti da ti radi web server s Oblakom. :)

**Svakako** si osiguraj HTTPS na serveru. Doslovno je dvije minute posla s Let's Encryptom i Certbotom, a učinit će tvoj Oblak server **sigurnim**. Ako nemaš HTTPS, svatko na istoj mreži kao ti može pregledavati sav promet.

Ovako izgleda naša nginx konfiguracija za Oblak. Modificiraj ju tako da paše tvojim potrebama. Koristimo nginx s fastcgi-jem za PHP.

```nginx
upstream php-oblak-server.firma.hr {
        #server 127.0.0.1:9000;
        server unix:/var/run/oblak-server.firma.hr;
}

server {
	listen 80;
	server_name  oblak-server.firma.hr;
        return 301 https://$server_name$request_uri;
	}

server {
	listen 443 ssl;
	server_name oblak-server.firma.hr;
	root   /var/www/sites/oblak-server.firma.hr/oblak/src;
	index index.php index.html;
	gzip off;

	ssl_certificate /etc/letsencrypt/live/oblak-server.firma.hr/fullchain.pem;
	ssl_certificate_key /etc/letsencrypt/live/oblak-server.firma.hr/privkey.pem;
	include /etc/nginx/conf.d/ssl.conf;

        # Add headers to serve security related headers
        add_header Strict-Transport-Security "max-age=15768000; includeSubDomains; preload;";
        add_header X-Content-Type-Options nosniff;
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-XSS-Protection "1; mode=block";
        add_header X-Robots-Tag none;

	location ~ \.php(?:$|/) {
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_param PATH_INFO $fastcgi_path_info;
                fastcgi_param HTTPS on;
                fastcgi_param modHeadersAvailable true; #Avoid sending the security headers twice
                fastcgi_pass php-oblak-server.firma.hr;
		try_files $uri $uri/ =404;
		fastcgi_index index.php;
       		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
	location / {
		try_files $uri $uri/ /index.php?$args;
	}

        location ~ /.well-known {
                allow all;
        }
}
```

## Konfiguriraj Oblak

Kad je sve drugo gotovo, preostaje ti još _samo_ konfigurirati Oblak.

U oblak/src mapi, gdje vidiš predložak config.php.new napravi novu config.php datoteku i popuni ju svojim podacima.

config.php konfiguracijska datoteka izgleda ovako, s hrpom definiranih konstanti:

```php
<?php
define('rootdirpath', '/var/www/sites/oblak-server.firma.hr/oblak/src'); // Putanja do oblak/src direktorija gdje se nalazi ova datoteka. Bez zadnjeg slasha.
define('domainpath', 'https://oblak-server.firma.hr/'); // URL do početne stranice Oblaka, bez segmenta za specifičnu stranicu. Protokol i zadnji slash su nužni.
define('mysql_user', 'oblakuser'); // MariaDB korisnik
define('mysql_database', 'oblakdb'); // MariaDB baza
define('mysql_password', 'password123'); // MariaDB lozinka
define('mysql_server', 'localhost'); // MariaDB server (ovo se sve koristi u mysqli_connect PHP funkciji)
define('nsCoreLanguage', 'hr'); // ostavi kako je
define('nsEnvironment', 'development'); // stavi production ako je instanca u produkciji da se ne bi pojavljivale osjetljive informacije javno
define('systemAdminEmail', 'devnull@it.firma.hr'); // email na koji stižu obavijesti o greškama
define('oblakDeployKey', 'dugacak-i-tezak-za-pogoditi-deploy-key-nasumican-po-mogucnosti'); // šifra za deployanje
error_reporting(E_ALL); // PHP konfiguracijska opcija oko toga koje greške se trebaju pratiti
date_default_timezone_set('Europe/Zagreb'); // PHP konfiguracijska opcija oko toga koju vremensku zonu Oblak treba koristiti

if(nsEnvironment == 'development'){ // sve ispod ostavi kako je
  ini_set('xdebug.var_display_max_depth', -1); 
  ini_set('xdebug.var_display_max_children', -1);
  ini_set('xdebug.var_display_max_data', -1);
}
```

Kad je ovo gotovo, Oblak bi trebao raditi :)

Ako ne radi, pogledaj logove i otvori Issue ovdje ako ti nešto nije jasno.


## Prilagodi Oblak svojim potrebama

Zamijeni email@example.com sa svojim emailom gdje god se pojavljuje. Uredi landing i footer. Radi što god želiš, tvoje je :)


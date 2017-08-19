<?php

/** klasa za parsiranje PCF datoteka, odvojena od Nightsparrowa kao zasebna cjelina **/
class parsePCF
{
    /** nađimo vrijednost svojstva iz datoteke. radi samo ako je jedinstvena vrijednost u PCF datoteci **/
    function getPropertyValue($file, $property)
    {
        $fcont = file_get_contents($file); // dobijmo sadržaj datoteke
        $loc_property = strpos($fcont, $property); // nađimo gdje se vrijednost nalazi u datoteci
        $propval = substr($fcont, $loc_property); // odrežimo sve od početka
        $loc_endline = strpos($propval, ';'); // do kraja vrijednosti
        $propertyline = substr($propval, 0, $loc_endline); // odrežimo vrijednost
        $pnv = $property . ': ';  // što je nepotrebno
        $strip = strlen($pnv); // nađimo duljinu nepotrebnog
        $propertyvalue = substr($propertyline, $strip); // odrežimo nepotrebno i dobijmo konačnu vrijednost
        return $propertyvalue; // vratimo čistu vrijednost nazad
    }

    /** parsiraj PCF i vrati sva svojstva i njihove vrijednosti kao niz **/
    function parsePCF($file)
    {
        $fcont = file_get_contents($file); // dobijmo sadržaj datoteke
        $lines = explode("\n", $fcont);
        $properties = array();
        foreach ($lines as $line) {
            $property = substr($line, strpos($line, ":"));
            $value = substr($line, str_replace($property . ": "));
            $value = str_replace(";", "", $value);
            $properties[$property] = $value;
        }
    }
}

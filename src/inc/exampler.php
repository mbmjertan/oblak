<?php

/**
 * Nightsparrow *
 * ExampleGenerator -- exampler.php *
 * Klasa za generiranje nasumičnih primjera za polja *
 **/
class ExampleGenerator extends Nightsparrow
{
    function example_generate_name()
    {
        //$collection = parent:get_preference('ExampleGenerator', 'UseCollection');
        $collection = 'fam';
        $names = $this->grab_collection($collection);
        shuffle($names);

        return $names[4]; // 4 je uvijek nasumičan broj :D
    }

    function example_generate_email()
    {
        $collection = 'fam';
        $names = $this->grab_collection($collection);
        shuffle($names);
        $name = $names[4];
        $name = explode(" ", $name);
        $usable = strtolower($name[0]) . strtolower($name[1]);
        $email = $this->grab_collection('email');
        shuffle($email);
        $usable = $usable . '@' . $email[4];

        return $usable;
    }

    function grab_collection($collection)
    {
        $file = rootdirpath . 'inc/fls/' . $collection . '.txt';
        $content = file_get_contents($file);
        $content = explode(" // ", $content);

        return $content;
    }
}
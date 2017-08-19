<?php

class Templates extends Nightsparrow
{
    /** if we need to grab a generic icon! this is just awful **/
    function grabIcon($icon, $format)
    {
        $icon = htmlentities($icon); // escape, dangerous characters! (although this could open more vunerabilities than it saves from. huh, I have to take a look at the best ways to fix this)
        $file = rootdirpath . 'template/icons/' . $icon . '.' . $format; // the path to the file
        if ($format == 'svg') { // who's a good little vector? yes you are yes you are
            $icf = file_get_contents($file); // let's grab the contents and return it as a <svg> element, nobody actually cares and it's faster
        } else { // if you're using an inferior format
            $icf = '<img src="' . domainpath . 'template/icons/' . $icon . $format . '">'; // just throw a <img> tag at it.
        }

        return $icf;
    }

    /** let's scan the template folder and find actual site templates, not admin pages and things like that **/
    function scanForTemplates()
    {
        $templates = array(); // a fancy array to store the template names
        $scanpath = rootdirpath . 'template/'; // this should give us the complete directory path to the template folder
        $scanresults = scandir($scanpath); // oooh, let's scan that directory and store the results there
        foreach ($scanresults as $result) { // and for each of the scanned items, do this:
            if ($result === '.' or $result === '..') {
                continue;
            } // if it's a . or .., just ignore it (why the f does php return this I just want to know about a situation where it was useful and not infuriating)

            if (is_dir($scanpath . $result)) { // take a look if it's a directory
                if (file_exists($scanpath . $result . '/' . 'template.pcf')) { // let's take a look if it has the template configuration file there -- if yes, we can almost always think it's a site template
                    array_push($templates, $result); // push it to that aforementioned fancy array
                }
            }
        }

        return $templates; // yep, that's it, return the fancy array to the other function.
    }

    /** generirajmo odabir templateova **/
    function generateTemplatePicker()
    {
        $templates = $this->scanForTemplates();

        foreach ($templates as $template) {
            include_once rootdirpath . 'inc/pcf-parser.php';
            $pcfParser = new parsePCF;
            $themefile = rootdirpath . 'template/' . $template . '/template.pcf';
            $name = $pcfParser->getPropertyValue($themefile, 'name');
            $description = $pcfParser->getPropertyValue($themefile, 'description');
            $author = $pcfParser->getPropertyValue($themefile, 'author');
            $thumb = $pcfParser->getPropertyValue($themefile, 'thumbnail');
            $thumbpath = domainpath . 'template/' . $template . '/' . $thumb;
            $type = $pcfParser->getPropertyValue($themefile, 'type');
            $license = $pcfParser->getPropertyValue($themefile, 'license');

            echo '<div class="col-md-3">';
            echo '<a href="?activate=' . $name . '">';
            echo '<img src="' . $thumbpath . '" style="height: 250px !important;" alt="">';
            echo '<br>';
            echo '<span style="margin-top:15px;padding-top:15px;font-size:18px;">' . $name . '</span>';
            echo '<br><p>' . $description . '</p><br><small>Autor: ' . $author . ' &middot; Licenca: ' . $license . '</small>';
            echo '</a></div>';
        }

    }

    function adminGenerateTemplatePicker()
    {
        $templates = $this->scanForTemplates();

        foreach ($templates as $template) {
            include_once rootdirpath . 'inc/pcf-parser.php';
            $pcfParser = new parsePCF;
            $themefile = rootdirpath . 'template/' . $template . '/template.pcf';
            $name = $pcfParser->getPropertyValue($themefile, 'name');
            $description = $pcfParser->getPropertyValue($themefile, 'description');
            $author = $pcfParser->getPropertyValue($themefile, 'author');
            $thumb = $pcfParser->getPropertyValue($themefile, 'thumbnail');
            $thumbpath = domainpath . 'template/' . $template . '/' . $thumb;
            $type = $pcfParser->getPropertyValue($themefile, 'type');
            $license = $pcfParser->getPropertyValue($themefile, 'license');

            echo '<div class="col l3">';
            echo '<a href="?activate=' . $name . '">';
            echo '<img src="' . $thumbpath . '" style="height: 200px !important;" alt="">';
            echo '<br>';
            echo '<span style="margin-top:15px;padding-top:15px;font-size:18px;">' . $name . '</span>';
            echo '<br><p>' . $description . '</p><br><small>Autor: ' . $author . ' &middot; Licenca: ' . $license . '</small>';
            echo '</a></div>';
        }

    }

    /** vraća datoteku teme **/
    function grabTemplateFile($file)
    {
        $template = file_get_contents($file);

        return $template;
    }

    function parseTemplateFile($file, $vars)
    {
        $file = $this->handleTemplateIncludes($file);
        $file = $this->handleVariableCalls($file, $vars);

        return $file;
    }

    function handleTemplateIncludes($file)
    {
        $temp_file = $file;
        $no = substr_count($temp_file, '{{');
        //echo 'no:'.$no;
        for ($i = 0; $i < $no; $i++) {
            $location_include = strpos($temp_file, '{{');
            //echo 'lo: '.$location_include;
            $value = substr($temp_file, $location_include + strlen('{{'));
            //echo 'va: '.$value.'<br>';
            $where = strlen($value) - strpos($value, '}}');
            $file_to_include = substr($value, 0, -$where);
            $fti = $file_to_include;
            include_once rootdirpath . '/inc/nightsparrow-main.php';
            $ns = new Nightsparrow();
            $file_to_include = rootdirpath . '/template/' . $ns->getSettingValue('core',
                'siteActiveTheme') . '/' . $file_to_include . '.txt';
            //echo 'fi: '.$file_to_include.'<br>';
            $line = '{{' . $fti . '}}';
            $included = file_get_contents($file_to_include);
            $temp_file = str_replace($line, $included, $temp_file);

            //var_dump($temp_file);
            return $temp_file;
        }
    }

    function handleVariableCalls($file, $vars)
    {
        $temp_file = $file;
        $temp_file = str_replace(array_keys($vars), array_values($vars), $temp_file);

        return $temp_file;
    }


}
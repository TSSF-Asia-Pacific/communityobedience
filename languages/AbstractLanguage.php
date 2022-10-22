<?php
namespace languages;
/* Extend this abstract class and override the public properties
 * It's probably easier to just copy the English version. This file is more
 * useful for code completion.
 */


use ReflectionClass;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractLanguage
{
    public $name = "Language Name";

    public $dateLocale = "en"; // See https://momentjs.com/ for possible Locales

    public function getDailyPrayersMembers($day) {
        // Lookup names for deceased and living members we are praying for
        $templateVars = [];
        foreach(range(1,3) as $region) {
            $filename = __DIR__ . "/../common/${day}_living_members_${region}.txt";
            if (file_exists($filename)) {
                $templateVars["living_members_${region}"] = file_get_contents($filename);
            }
        }
        $deceasedMembersFilename = __DIR__ . "/../common/${day}_deceased_members.txt";
        if (file_exists($deceasedMembersFilename)) {
            $templateVars['deceased_members'] = file_get_contents($deceasedMembersFilename);
        }

        return $templateVars;
    }
}
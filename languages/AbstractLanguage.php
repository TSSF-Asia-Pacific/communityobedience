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

    public $dailyPrayerOffering = "";

    public $gloriaPatra = "";

    public $openingPrayer = "";

    public $principleRubricTitleDay31 = "";

    public $principleRubricTitleNormal = "";

    public $dailyIntercessionPrayerTitle = "Daily intercession prayers...";

    public $collectTitle = "";

    /**
     * @var string[] Array of Collect days, Sunday is the first item in the array
     */
    public $collectDays = [
        "The collect for Sunday",
        "The collect for Monday",
        "The collect for Tuesday",
        "The collect for Wednesday",
        "The collect for Thursday",
        "The collect for Friday",
        "The collect for Saturday"
    ];

    public $communityPrayer = "";

    public $either = "";

    public $orDot = "";

    public $blessingOne = "";

    public $blessingTwo = "";

    /**
     * @var string Copyright string for the bible texts used
     */
    public $copyright = "";

    private Environment $twig;

    /** Get the Class base path so we can find the text files */
    protected function getBasePath() {
        return dirname((new ReflectionClass(get_class($this)))->getFileName());
    }

    public function __construct()
    {
        $loader = new FilesystemLoader($this->getBasePath());
        $this->twig = new Environment($loader, ['strict_variables' => true]);
    }

    public function getPrinciple($day) {
        return file($this->getBasePath() . "/principle/principle$day.txt");
    }

    public function getDailyPrayers($day) {
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
        return $this->twig->render("/daily/day$day.txt", $templateVars);
    }

    /**
     * @param $dayOfWeek 0 index
     */
    public function getCollect($dayOfWeek) {
        return file($this->getBasePath() . "/collect/collect$dayOfWeek.txt");
    }
}
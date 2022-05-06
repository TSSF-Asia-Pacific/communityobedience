<?php
namespace languages;
/* Extend this abstract class and override the public properties
 * It's probably easier to just copy the English version. This file is more
 * useful for code completion.
 */


use ReflectionClass;

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

    /** Get the Class base path so we can find the text files */
    protected function getBasePath() {
        return dirname((new ReflectionClass(get_class($this)))->getFileName());
    }

    public function getPrinciple($day) {
        return file($this->getBasePath() . "/principle/principle$day.txt");
    }

    public function getDailyPrayers($day) {
        return file($this->getBasePath() . "/daily/day$day.txt");
    }

    /**
     * @param $dayOfWeek 0 index
     */
    public function getCollect($dayOfWeek) {
        return file($this->getBasePath() . "/collect/collect$dayOfWeek.txt");
    }
}
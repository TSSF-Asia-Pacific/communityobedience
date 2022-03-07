<?php
namespace languages;
/* Extend this abstract class and override the public properties
 * It's probably easier to just copy the English version. This file is more
 * useful for code completion.
 */


abstract class AbstractLanguage
{
    public $name = "Language Name";

    public $dailyPrayerOffering = "";

    public $gloriaPatra = "";

    public $openingPrayer = "";

    public $principleRubricTitleDay31 = "";

    public $principleRubricTitleNormal = "";

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
}
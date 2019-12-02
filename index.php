<!DOCTYPE html>
<html manifest="cache.appcache">
<head>
    <meta name="viewport" content="initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="196x196" href="images/Icon.png">
    <link rel="apple-touch-icon" sizes="128x128" href="images/AppleIcon.png">
    <title>tssf Community Obedience</title>
    <link rel="stylesheet" href="bootstrap-3.1.1-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href='css/tssf.css'>
</head>
<?php

// autoloader
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class) {
    $file = ROOT . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

    // Load each translation into the translations array here
    $translations['en'] = new en\translation();

?>

<body>
<script src="https://code.jquery.com/jquery-3.0.0.js"></script>
<script type="text/javascript" src='moment.min.js'></script>

<script type="text/javascript">
    <?php
    echo 'let supportedLanguages = ' .  json_encode(array_keys($translations)) . ';';
    ?>
    // From https://stackoverflow.com/a/52112155
    const getLanguage = () => {
        // Check for our local storage first
        if (typeof(Storage) !== "undefined") {
            if (localStorage.language) {
                return localStorage.language;
            }
        }
        if (navigator.languages && navigator.languages.length) {
            return navigator.languages[0];
        } else {
            return navigator.userLanguage || navigator.language || navigator.browserLanguage || 'en';
        }
    };

    const getSupportedLanguage = () => {
        let detectedLanguage = getLanguage();

        if (supportedLanguages.includes(detectedLanguage) ) {
            return detectedLanguage;
        }
        return 'en';
    };

    const setLanguage = (newLang) => {
        localStorage.language = newLang;
        lang = getSupportedLanguage();

        // Update the display
        display_todays_obedience();
    };

    let intervalId;

    let lang = getSupportedLanguage();


    function display_todays_obedience() {
        // Hide all the boilerplate for all languages
        $(".translatedBoilerplate").hide();

        // Show the boilerplate for the current language
        $(".translatedBoilerplate[lang='" + lang + "']").show();

        // Ensure all divs are hidden
        $("#jsmessage").hide();
        $(".principal").hide();
        $(".collect").hide();
        $(".day").hide();

        // Work out day of month
        let dayofmonth = moment().format("D");

        let principalnum = dayofmonth;

        $("#principal_" + lang + "_" + principalnum).show();
        $("#day_" + lang + "_" + dayofmonth).show();

        // Work out day of week
        let dayofweek = moment().format("d");
        $("#collect_" + lang + "_" + dayofweek).show();
        $('#date').text(moment().format("dddd D MMMM YYYY"));
        update_display();
    }

    $(document).ready(display_todays_obedience);

    function update_display() {
        // Clear any current intervals before we start the next one
        clearInterval(intervalId);
        // Refresh every 10 minutes
        intervalId = setInterval(display_todays_obedience, 600000);
    }
</script>
<div id="jsmessage">If you can read this, you have javascript disabled, please enable javascript to use this site</div>

<div id="langselect" style="float: right">
    <?php
    foreach ($translations as $lang => $translation) {
        echo "<button onClick='setLanguage(\"$lang\");' lang='$lang'>$translation->name</button>";
    }
    ?>

</div>

<h1><em>tssf Community Obedience</em></h1>
<?php

/**
 * @var string $lang
 * @var language $translation
 */
foreach ($translations as $lang => $translation) {
?>
<p style="font-family: TimesNewRoman, 'Times New Roman', Times, Baskerville, Georgia, serif;">
    <em>Province of Asia-Pacific<br/>
        for <span id='date'></span></em>
</p>
<p class="rubric translatedBoilerplate" lang="<?= $lang ?>">
    <?= $translation->dailyPrayerOffering ?>
</p>
<p class="boilerplate translatedBoilerplate" lang="<?= $lang ?>">
    <?= $translation->gloriaPatra ?>
</p>
<p class="boilerplate translatedBoilerplate" lang="<?= $lang ?>">
    <?= $translation->openingPrayer ?>
</p>

<?php

    /* Add the principle for the day of month. */
    for ($i = 1; $i <= 31; $i++) {
        $principleFile = "$lang/principle/principle${i}.txt";
        if ($i == 31) {
            $principleRubric = $translation->principleRubricTitleDay31;
        } else {
            $principleRubric = $translation->principleRubricTitleNormal;
        }

        echo "<div id='principal_${lang}_${i}' class='principal' lang='${lang}'>";
        echo "    <p class='rubric'>$principleRubric</p>\n";
        echo "    <p class='boilerplate'>" . implode("</p>\n<p class='boilerplate'>", file($principleFile)) . "</p>\n";
        echo "</div>\n";
    }
    ?>

    <p class="rubric translatedBoilerplate" lang="<?= $lang ?>">Daily intercession prayers...</p>

    <?php
    /* Add the daily intercession prayers for the day of the month */

    for ($i = 1; $i <= 31; $i++) {
        echo "<div id='day_${lang}_${i}' class='day' lang='${lang}'>";
        $contents = file("$lang/daily/day${i}.txt");
        echo implode('<br/>', $contents) . "<br/>";
        echo "</div>\n";
    }
    ?>
    <br/>

    <p class="rubric translatedBoilerplate" lang="<?= $lang ?>"><?= $translation->collectTitle ?></p>

    <p class="boilerplate translatedBoilerplate" lang="<?= $lang ?>"><?= $translation->communityPrayer ?></p>
    <?php
    $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

    for ($i = 0; $i <= 6; $i++) {
        echo "<div id='collect_${lang}_${i}' class='collect' lang='${lang}'>";
        echo "<p class='rubric'>The collect for " . $days[$i] . "</p>";

        $collectFile = "$lang/collect/collect${i}.txt";
        echo "<p class='boilerplate'>" . implode("</p><p class='boilerplate'", file($collectFile)) . "</p>";
        echo "</div>\n";
    }
?>

<p class="rubric translatedBoilerplate" lang="<?= $lang ?>"><?= $translation->either ?></p>

<p class="boilerplate translatedBoilerplate" lang="<?= $lang ?>">
    <?= $translation->blessingOne ?>
</p>
<p class="rubric translatedBoilerplate" lang="<?= $lang ?>"><?= $translation->orDot ?></p>
<p class="boilerplate translatedBoilerplate" lang="<?= $lang ?>">
    <?= $translation->blessingTwo ?>
</p>

<?php
} // End language loop
?>


<p class="copyrite">* [Scripture quotations are from] New Revised Standard Version Bible, copyright &#64; 1989 National
    Council of the Churches of Christ in the United States of America. Used by permission. All rights reserved.</p>
<p class="copyrite">Updated: 2nd December 2019.</p>

<!-- Usage tracking -->
<!-- Matomo -->
<script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function () {
        var u = "https://piwik.whiteitsolutions.com.au/";
        _paq.push(['setTrackerUrl', u + 'piwik.php']);
        _paq.push(['setSiteId', '22']);
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>
<!-- End Matomo Code -->

<!-- Matomo Image Tracker-->
<img src="https://piwik.whiteitsolutions.com.au/piwik.php?idsite=22&amp;rec=1" style="border:0" alt=""/>
<!-- End Matomo -->

</body>
</html>

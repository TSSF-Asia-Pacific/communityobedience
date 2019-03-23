<!DOCTYPE html>
<html manifest="1cache.appcache">
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
    $supportedLanguages = ['en'];
?>

<body>
<script src="https://code.jquery.com/jquery-3.0.0.js"></script>
<script type="text/javascript" src='moment.min.js'></script>

<script type="text/javascript">
    <?php
    echo 'let supportedLanguages = ' .  json_encode($supportedLanguages) . ';';
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
    }

    const getSupportedLanguage = () => {
        let detectedLanguage = getLanguage();

        if (supportedLanguages.includes(detectedLanguage) ) {
            return detectedLanguage;
        }
        return 'en';
    }

    const setLanguage = (newLang) => {
        localStorage.language = newLang;
        lang = getSupportedLanguage()

        // Update the display
        display_todays_obedience();
    }

    let intervalId;

    let lang = getSupportedLanguage();


    function display_todays_obedience() {
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
    foreach ($supportedLanguages as $lang) {
        echo "<button onClick='setLanguage(\"$lang\");'>$lang</button>";
    }
    ?>

</div>

<h1><em>tssf Community Obedience</em></h1>
<p style="font-family: TimesNewRoman, 'Times New Roman', Times, Baskerville, Georgia, serif;">
    <em>Province of Asia-Pacific<br/>
        for <span id='date'></span></em>
</p>
<p class="rubric">
    This offering of prayer is to be said daily, where possible in the context of Morning or Evening Prayer.
</p>
<p class="boilerplate">
    In the name of the Father,<br/>
    and of the Son,<br/>
    and of the Holy Spirit. <strong>Amen</strong>
</p>
<p class="boilerplate">
    Here and in all your churches throughout the world,<br/>
    we adore you, O Christ, and we bless you,<br/>
    because by your holy cross you have redeemed the world. <strong>Amen</strong>
</p>

<?php

foreach ($supportedLanguages as $lang) {

    /* Add the principle for the day of month. */
    for ($i = 1; $i <= 31; $i++) {
        echo "<div id='principal_${lang}_${i}' class='principal'>";
        if ($i == 31) {
            $principleRubric = 'About the Principles of the Third Order.';
        } else {
            $principleRubric = 'Reading from the Principles of the Third Order.';
        }
        echo "<p class='rubric'>$principleRubric</p>\n";

        $principleFile = "$lang/boiler/principle${i}.txt";
        echo "<p class='boilerplate'>" . implode("</p>\n<p class='boilerplate'>", file($principleFile)) . "</p>\n";
        echo "</div>\n";
    }
    ?>

    <p class="rubric">Daily intercession prayers...</p>

    <?php
    /* Add the daily intercession prayers for the day of the month */

    for ($i = 1; $i <= 31; $i++) {
        echo "<div id='day_${lang}_${i}' class='day'>";
        $contents = file("$lang/tssffiles/day${i}.txt");
        echo implode('<br/>', $contents) . "<br/>";
        echo "</div>\n";
    }
    ?>

    <p class="rubric"><br/>tssf Community Collect</p>

    <p class="boilerplate">God, we give you thanks for the Third Order of the Society of St. Francis. Grant, we pray,
        that
        being knit together in community and prayer, we your servants may glorify your holy name after the example of
        Saint
        Francis, and win others to your love; through Jesus Christ our Lord. <strong>Amen</strong></p>
    <?php
    $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

    for ($i = 0; $i <= 6; $i++) {
        echo "<div id='collect_${lang}_${i}' class='collect'>";
        echo "<p class='rubric'>The collect for " . $days[$i] . "</p>";

        $collectFile = "$lang/boiler/collect${i}.txt";
        echo "<p class='boilerplate'>" . implode("</p><p class='boilerplate'", file($collectFile)) . "</p>";
        echo "</div>\n";
    }
} // End language loop
?>

<p class="rubric">Either</p>

<p class="boilerplate">
    May our blessed Lady pray for us.<br/>
    May Saint Francis pray for us.<br/>
    May Saint Clare pray for us.<br/>
    May all the saints of the Third Order pray for us.<br/>
    May the holy angels watch over us and befriend us.<br/>
    May our Lord Jesus give us his blessing and his peace. <strong>Amen</strong>
</p>
<p class="rubric">or...</p>
<p class="boilerplate">
    The grace of our Lord Jesus Christ,<br/>
    the love of God,<br/>
    and the fellowship of the Holy Spirit<br/>
    be with us all evermore. <strong>Amen</strong>
<p class="copyrite">* [Scripture quotations are from] New Revised Standard Version Bible, copyright &#64; 1989 National
    Council of the Churches of Christ in the United States of America. Used by permission. All rights reserved.</p>
<p class="copyrite">Updated: 12th March 2019.</p>

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

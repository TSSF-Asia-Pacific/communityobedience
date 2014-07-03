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

  <body>
    <script type="text/javascript" src='jquery-1.11.1.min.js' ></script>
    <script type="text/javascript" src='moment.min.js'></script>
    <script type="text/javascript">


    function display_todays_obedience()
    {
        // Ensure all divs are hidden
        $("#jsmessage").hide();
        $(".principal").hide();
        $(".collect").hide();
        $(".day").hide();

        // Work out day of month
        datenow = new moment();
        dayofmonth = datenow.format("D");

        if(dayofmonth == 31)
        {
            principalnum = Math.floor(Math.random() * (30 - 1 + 1)) + 1;
        }else{
            principalnum = dayofmonth;
        }
        $("#principal_" + principalnum).show();
        $("#day_" + dayofmonth).show();

        // Work out day of week
        dayofweek = datenow.format("d");
        $("#collect_" + dayofweek).show();
        $('#date').text(datenow.format("dddd D MMMM YYYY"));
        update_display();
    }

    $( document ).ready(display_todays_obedience);

    var nIntervId;
     
    function update_display() {
        // Refresh every 10 minutes
        IntervId = setInterval(display_todays_obedience, 600000);
    }
    </script>
    <div id="jsmessage">If you can read this, you have javascript disabled, please enable javascript to use this site</div>

    <h1><em>tssf Community Obedience</em></h1>
    <p style="font-family: TimesNewRoman, 'Times New Roman', Times, Baskerville, Georgia, serif;"><em>Province of Asia-Pacific
    <br/>for <span id='date'></span></em></p>
    <p class="rubric">This offering of prayer is to be said daily, where possible in the context of Morning or
    Evening Prayer.</p>
    <p class="boilerplate">In the name of the Father,
    <br/>and of the Son,
    <br/>and of the Holy Spirit. <strong>Amen</strong></p>
    <p class="boilerplate">Here and in all your churches throughout the world,
    <br/>we adore you, O Christ, and we bless you,
    <br/>because by your holy cross you have redeemed the world. <strong>Amen</strong></p>

<?php
/* Add the principle for the day of month. */

for($i = 1; $i <= 30; $i++)
{
    echo "<div id='principal_$i' class='principal'>";
    $principlerubric = 'Principle for day ' . $i;
    echo "<p class='rubric'>$principlerubric</p>\n";

    $principlefile = 'boiler/principle' . $i . '.txt';
    echo "<p class='boilerplate'>" . implode("</p>\n<p class='boilerplate'>", file($principlefile)) . "</p>\n";
    echo "</div>\n";
}
?>

<p class="rubric">Daily intercession prayers...</p>

<?php
/* Add the daily intercession prayers for the day of the month */

for ($i = 1; $i <= 31; $i++)
{
    echo "<div id='day_$i' class='day'>";
    $contents = file('tssffiles/day' . $i . '.txt');
    echo implode('<br/>', $contents). "<br/>";
    echo "</div>\n";
}
?>

<p class="rubric"><br/>tssf Community Collect</p>

<p class="boilerplate">God, we give you thanks for the Third Order of the Society of St. Francis. Grant, we pray, that being knit together in community and prayer, we your servants may glorify your holy name after the example of Saint Francis, and win others to your love; through Jesus Christ our Lord. <strong>Amen</strong></p>
<?php
$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

for ($i = 0; $i <= 6; $i++)
{
    echo "<div id='collect_$i' class='collect'>";
    echo "<p class='rubric'>The collect for " . $days[$i] . "</p>";

    $collectfile = 'boiler/collect' . $i . '.txt';
    echo "<p class='boilerplate'>" . implode("</p><p class='boilerplate'", file($collectfile)) . "</p>";
    echo "</div>\n";
}
?>

<p class="rubric">Either</p>

<p class="boilerplate">May our blessed Lady pray for us.<br/>May Saint Francis pray for us.<br/>May Saint Clare pray for us.<br/>May all the saints of the Third Order pray for us.<br/>May the holy angels watch over us and befriend us.<br/>May our Lord Jesus give us his blessing and his peace. <strong>Amen</strong></p>
<p class="rubric">or...</p>
<p class="boilerplate">The grace of our Lord Jesus Christ,<br/>the love of God,<br/>and the fellowship of the Holy Spirit<br/>be with us all evermore. <strong>Amen</strong>
<p class="copyrite">* [Scripture quotations are from] New Revised Standard Version Bible, copyright &#64; 1989 National Council of the Churches of Christ in the United States of America. Used by permission. All rights reserved.</p>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
            var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.purewhite.id.au/";
                _paq.push(['setTrackerUrl', u+'piwik.php']);
                _paq.push(['setSiteId', 22]);
                    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
                    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
                      })();
</script>
<noscript><p><img src="http://piwik.purewhite.id.au/piwik.php?idsite=22" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

  </body>
</html>

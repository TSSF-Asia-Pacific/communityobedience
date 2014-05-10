<html>
  <head>
    <title>tssf Community Obedience</title>
    <style>
      <?php include 'css/tssf.css'; ?>

        .principal, .day, .collect {
            display: none;
        }

        #jsmessage {
            border: 1px solid;
            margin: 10px 0px;
            padding:15px 10px 15px 50px;
            background-repeat: no-repeat;
            background-position: 10px center;
            color: #D8000C;
            background-color: #FFBABA;
        }
    </style>
  </head>

  <body>
    <script src="jquery-1.11.1.min.js"></script>
    <script src="moment.min.js"></script>
    <script>


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

        if(dayofmonth == 30)
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
    }

    $( document ).ready(display_todays_obedience);
    </script>
    <div id="jsmessage">If you can read this, you have javascript disabled, please enable javascript to use this site</div>
    <h1>tssf Community Obedience</h1>
    <em>Province of Australia, Papua New Guinea and East Asia<br/>
    <?php echo "for <span id='date'>TEST" . date("l d M Y") . "</span></em><br/>"; ?>
    <p class="rubric">In all provinces of the Third Order this offering of prayer should be made daily, either on its own or in the context of Morning or Evening Prayer.</p>
    <p class="boilerplate">In the name of the Father,<br/>and of the Son,<br/>and of the Holy Spirit. <strong>Amen</strong></p>
    <p class="boilerplate">Here and in all your churches throughout the world,<br/>we adore you, O Christ, and we bless you,<br/>because by your holy cross you have redeemed the world. <strong>Amen</strong></p>

<?php
/* We need to get the day of week and day in month */
date_default_timezone_set('Australia/Perth');

/* $dx = date('j');
echo $dx;
$pdx = $dx;
echo $pdx;
$oop = date('l');
echo $oop;
$y = "...";
echo $y; */

$today = getdate();
$d = $today['mday'];
$m = $today['wday'];
$pd = $today['mday']; 

/* Add the principle for the day of month. */
if ($pd > 30)
{
  $pd = rand(1, 30);
}

for($i = 1; $i <= 30; $i++)
{
    echo "<div id='principal_$i' class='principal'>";
    $principlerubric = 'Principle for day ' . $i;
    echo "<p class='rubric'>$principlerubric</p>";

    $principlefile = 'boiler/principle' . $i . '.txt';
    $principle_handle = fopen($principlefile, "r");
    while (!feof($principle_handle) ) {
    $line_of_text = fgets($principle_handle);
    // $parts = explode(':', trim($line_of_text) );
    echo "<p class='boilerplate'>$line_of_text</p>";
    }
    fclose($principle_handle);
    echo "</div>";
}
?>

<p class="rubric">Daily intercession prayers...</p>

<?php

for ($i = 1; $i <= 31; $i++)
{
    echo "<div id='day_$i' class='day'>";
    $filename = 'tssffiles/day' . $i . '.txt';
    $file_handle = fopen($filename, "r");
    while (!feof($file_handle) ) {

    $line_of_text = fgets($file_handle);
    // $parts = explode(':', trim($line_of_text) );
    echo "$line_of_text<br/>";
    }
    fclose($file_handle);
    echo "</div>";
}
?>

<p class="boilerplate">God, we give you thanks for the Third Order of the Society of St. Francis. Grant, we pray, that being knit together in community and prayer, we your servants may glorify your holy name after the example of Saint Francis, and win others to your love; through Jesus Christ our Lord. <strong>Amen</strong></p>
<?php
$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

for ($i = 0; $i <= 6; $i++)
{
    echo "<div id='collect_$i' class='collect'>";
    echo "<p class='rubric'>The collect for " . $days[$i] . "</p>";

    $principlefile = 'boiler/collect' . $m . '.txt';
    $principle_handle = fopen($principlefile, "r");
    while (!feof($principle_handle) ) {
    $line_of_text = fgets($principle_handle);
    // $parts = explode(':', trim($line_of_text) );
    echo "<p class='boilerplate'>$line_of_text</p>";
    }
    fclose($principle_handle);
    echo "</div>";
}
?>

<p class="rubric">The offering of prayer may continue with either Morning or Evening Prayer or conclude with either of the following:</p>

<p class="boilerplate">May our blessed Lady pray for us.<br/>May Saint Francis pray for us.<br/>May Saint Clare pray for us.<br/>May all the saints of the Third Order pray for us.<br/>May the holy angels watch over us and befriend us.<br/>May our Lord Jesus give us his blessing and his peace. <strong>Amen</strong></p>
<p class="rubric">or...</p>
<p class="boilerplate">The grace of our Lord Jesus Christ,<br/>the love of God,<br/>and the fellowship of the Holy Spirit<br/>be with us all evermore. <strong>Amen</strong>
  </body>
</html>

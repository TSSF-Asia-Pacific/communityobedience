<html>
  <head>
    <title>tssf Community Obedience</title>
    <style>
      <?php include 'css/tssf.css'; ?>
    </style>
  </head>

  <body>
    <h1>tssf Community Obedience</h1>
    <em>Province of Australia, Papua New Guinea and East Asia<br/>
    <?php echo "for " . date("l d M Y") . "</em><br/>"; ?>
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
$principlerubric = 'Principle for day ' . $pd;
echo "<p class='rubric'>$principlerubric</p>";

$principlefile = 'boiler/principle' . $pd . '.txt';
$principle_handle = fopen($principlefile, "r");
while (!feof($principle_handle) ) {
   $line_of_text = fgets($principle_handle);
   // $parts = explode(':', trim($line_of_text) );
   echo "<p class='boilerplate'>$line_of_text</p>";
}
fclose($principle_handle);
?>

<p class="rubric">Daily intercession prayers...</p>

<?php
$filename = 'tssffiles/day' . $d . '.txt';
$file_handle = fopen($filename, "r");
while (!feof($file_handle) ) {

   $line_of_text = fgets($file_handle);
   // $parts = explode(':', trim($line_of_text) );
   echo "$line_of_text<br/>";
}
fclose($file_handle);
?>

<p class="boilerplate">God, we give you thanks for the Third Order of the Society of St. Francis. Grant, we pray, that being knit together in community and prayer, we your servants may glorify your holy name after the example of Saint Francis, and win others to your love; through Jesus Christ our Lord. <strong>Amen</strong></p>
<?php
echo "<p class='rubric'>The collect for " . date("l") . "</p>";

$principlefile = 'boiler/collect' . $m . '.txt';
$principle_handle = fopen($principlefile, "r");
while (!feof($principle_handle) ) {
   $line_of_text = fgets($principle_handle);
   // $parts = explode(':', trim($line_of_text) );
   echo "<p class='boilerplate'>$line_of_text</p>";
}
fclose($principle_handle);
?>

<p class="rubric">The offering of prayer may continue with either Morning or Evening Prayer or conclude with either of the following:</p>

<p class="boilerplate">May our blessed Lady pray for us.<br/>May Saint Francis pray for us.<br/>May Saint Clare pray for us.<br/>May all the saints of the Third Order pray for us.<br/>May the holy angels watch over us and befriend us.<br/>May our Lord Jesus give us his blessing and his peace. <strong>Amen</strong></p>
<p class="rubric">or...</p>
<p class="boilerplate">The grace of our Lord Jesus Christ,<br/>the love of God,<br/>and the fellowship of the Holy Spirit<br/>be with us all evermore. <strong>Amen</strong>
  </body>
</html>
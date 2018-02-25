<html>
<head>
<title>Channel Changer</title>
</head>
<body>
<h1>
<?php
$requester = $_SERVER['REMOTE_ADDR'];
require('db.php');
$titleresult = $db->query("SELECT value FROM settings WHERE setting = 'title'");
while ($titlerow=$titleresult->fetchArray())
	echo $titlerow["value"];
echo "</h1>";
$result = $db->query("SELECT name, address as ip, tuned, serialNum FROM tuners ORDER BY name ASC");

while ($rx=$result->fetchArray()) {
    $ip = long2ip($rx['ip']);
    $name = $rx['name'];
    $dbTuned = $rx['tuned'];
    $box_serial = $rx['serialNum'];
    include("gettuned_directv.php");
    echo("<form action =\"tune_directv.php\" method=\"post\">");   
    echo($rx['name']."  <input type=\"text\" name=\"channel\" Value=\"$channel\">  ".$tuned->callsign."<br>
    <input type=\"submit\" Value=\"Tune ".$rx['name']."\">
    <input type=\"hidden\" name=\"ip\" value=\"$ip\">
    <input type=\"hidden\" name=\"requester\" value=\"$requester\">
    <input type=\"hidden\" name=\"name\" value=\"".$rx['name']."\">
    </form>
    ");
}
?>
<p>Made by Dennis - April 2017
</body>
</html>

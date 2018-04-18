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
    if (isset($channel)){
    	echo("<form action =\"tune_directv.php\" method=\"post\">");   
	    echo($rx['name']."  <input type=\"text\" name=\"channel\" Value=\"$channel\">  ".$tuned->callsign."<br>
	    <button name=\"action\" type=\"submit\" Value=\"tune\"> Tune ".$rx['name']."</button>
	    <button name=\"action\" type=\"submit\" Value=\"info\"> Info</button>
	    <button name=\"action\" type=\"submit\" Value=\"reboot\"> Reboot ".$rx['name']."</button>
	    <a href=\"remote.php?ip=$ip&name=".$rx['name']."\">Use Remote Control</a>
	    <input type=\"hidden\" name=\"ip\" value=\"$ip\">
	    <input type=\"hidden\" name=\"requester\" value=\"$requester\">
	    <input type=\"hidden\" name=\"name\" value=\"".$rx['name']."\">
	    </form>
	    ");
    }
    else {
    	echo ("<p><b>" . $rx['name'] . " isn't responding.  </b> Check back later.  
    	It will probably be found in the next scan.");
    }
    
}
?>
<p>Made by Dennis - April 2017
</body>
</html>

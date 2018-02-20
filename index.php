<html>
<head>
<title>Channel Changer</title>
</head>
<body>
<h1>Entercom NY Agile Channel Changer</h1>
<?php

$receiver_json = file_get_contents('receivers.json');
$receiver_array = json_decode($receiver_json,true);
//echo "<pre>";
foreach ($receiver_array as $key => $rx) {
    $ip = $rx['ip'];
    $type = $rx['type'];
    include("gettuned_$type.php");
    
    echo("<form action =\"tune_$type.php\" method=\"post\">");   
    echo($rx['name']."  <input type=\"text\" name=\"channel\" Value=\"$channel\">  ".$tuned->callsign."<br>
    <input type=\"submit\" Value=\"Tune ".$rx['name']."\">
    <input type=\"hidden\" name=\"ip\" value=\"$ip\">
    </form>
    ");
}
?>
<p>Made by Dennis - April 2017
</body>
</html>

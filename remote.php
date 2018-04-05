<?php

$ip = $_GET['ip'];
$requester = $_GET['requester'];
$boxname = $_GET['name'];
$key = $_GET['key'];

if ($key == NULL){
	error_log("User at $requester loaded the remote control page for $boxname",0);
	$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=$key");
}
else{
	error_log("User at $requester requested keypress $key on $boxname",0);
	$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=$key");
}

?>

<html>
	<head>
		<title>DirecTV remote</title>
	</head>
	<body>
		<h1> DirecTV Remote Control for <?php echo $boxname;?></h1>
	</body>
<img src ="remote.jpg" alt="Remote" usemap="#remotemap">
<map name="remotemap">
	<area shape ="circle" coords="121,426,22" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=menu" alt="Menu">
	<area shape ="circle" coords="56,285,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=guide" alt="Guide">
	<area shape ="circle" coords="147,258,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=list" alt="List">
	<area shape ="circle" coords="186,397,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=info" alt="Info">
	<area shape ="circle" coords="97,258,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=active" alt="Active">
	<area shape ="circle" coords="189,284,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=exit" alt="Exit">
	<area shape ="circle" coords="65,445,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=red" alt="Red">
	<area shape ="circle" coords="100,467,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=green" alt="Green">
	<area shape ="circle" coords="142,467,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=yellow" alt="Yellow">
	<area shape ="circle" coords="177,445,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=blue" alt="Blue">
	<area shape ="circle" coords="73,338,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=left" alt="Left">
	<area shape ="circle" coords="170,339,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=right" alt="Right">
	<area shape ="circle" coords="121,289,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=up" alt="Up">
	<area shape ="circle" coords="121,387,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=down" alt="Down">
	<area shape ="circle" coords="121,338,32" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=select" alt="Select">
	<area shape ="circle" coords="180,502,26" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=chanup" alt="Channel up">
	<area shape ="circle" coords="176,560,24" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=chandown" alt="Channel down">
	<area shape ="circle" coords="57,396,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=back" alt="Back">
	<area shape ="circle" coords="175,604,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=previous" alt="Previous">
	<area shape ="circle" coords="162,144,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=advance" alt="Advance">
	<area shape ="circle" coords="161,222,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=record" alt="Record">
	<area shape ="circle" coords="84,143,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=replay" alt="Replay">
	<area shape ="circle" coords="123,129,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=stop" alt="Stop">
	<area shape ="circle" coords="62,182,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=rewind" alt="Rewind">
	<area shape ="circle" coords="122,182,32" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=play" alt="Play">
	<area shape ="circle" coords="184,183,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=ffwd" alt="Fast Forward">
	<area shape ="circle" coords="84,221,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=pause" alt="Pause">
	<area shape ="circle" coords="67,763,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=dash" alt="Dash">
	<area shape ="circle" coords="173,763,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=enter" alt="Enter">
	<area shape ="circle" coords="124,84,23" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=power" alt="Power">
	<area shape ="circle" coords="50,108,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=format" alt="Format">
	<area shape ="circle" coords="120,763,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=0" alt="0">
	<area shape ="circle" coords="66,644,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=1" alt="1">
	<area shape ="circle" coords="120,644,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=2" alt="2">
	<area shape ="circle" coords="174,644,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=3" alt="3">
	<area shape ="circle" coords="66,683,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=4" alt="4">
	<area shape ="circle" coords="120,683,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=5" alt="5">
	<area shape ="circle" coords="174,683,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=6" alt="6">
	<area shape ="circle" coords="66,723,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=7" alt="7">
	<area shape ="circle" coords="120,723,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=8" alt="8">
	<area shape ="circle" coords="174,723,21" href="remote.php?ip=<?php echo $ip; ?>&requester=<?php echo $requester; ?>&name=<?php echo $boxname; ?>&key=9" alt="9">
</map>

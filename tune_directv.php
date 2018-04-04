<?php
$channel = $_POST['channel'];
$ip = $_POST['ip'];
$requester = $_POST['requester'];
$boxname = $_POST['name'];
$action = $_POST['action'];
error_log("User at $requester requested channel change to $channel on $boxname",0);

if ($action == 'reboot'){
	error_log("User at $requester requested reboot of $boxname",0);
	$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=poweroff");
	sleep(5);
	$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=poweron");
}
if ($action == 'info'){
	error_log("User at $requester requested info display on $boxname",0);
	$dinettes = file_get_contents("http://$ip:8080/remote/processKey?key=info");
	
}
else{
	if (strpos($channel,'-')!== false){
	
	    $channelparts = explode("-",2);
	    $major = sanitizeInput($channelparts[1]);
	    $minor = sanitizeinput($channelparts[2]);
	    $dinettes = file_get_contents("http://$ip:8080/tv/tune?major=$major&minor=$minor");
	}
	elseif (strpos($channel,'.')!== false){
	    $channelparts = explode(".",2);
	    $major = sanitizeInput($channelparts[1]);
	    $minor = sanitizeinput($channelparts[2]);
	    $dinettes = file_get_contents("http://$ip:8080/tv/tune?major=$major&minor=$minor");
	}
	else{
	    $major = sanitizeInput($channel);
	    $dinettes = file_get_contents("http://$ip:8080/tv/tune?major=$major");
	}
	sleep(4);
}

$status = json_decode($dinettes,true)["status"];
if ($status["code"] == 200){
	error_log("Tuner at $ip responded ". $status["code"].": ". $status["msg"],0);
}
else{
	error_log("Tuner at $ip responded ". $status["code"].": ". $status["msg"],0);
}

header("Location: index.php"); /* Redirect browser */
exit();

function sanitizeInput($string) { return preg_replace("[^0-9]", "", $string); }
?>
